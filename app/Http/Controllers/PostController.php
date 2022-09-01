<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Post;
use App\Models\Series_Post;
use App\Models\SeriesPost;
use App\Models\Tag;
use App\Models\TagContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = Auth::user();
        } catch (\Throwable $th) {
            $user = false;
        }

        //todo: get all post but not contain any tags
        $all_posts = DB::select(
            "SELECT *, p.id AS post_id
             FROM posts p, users u
             WHERE u.id = p.creator::integer
             ORDER BY u.id DESC
            "
        );
        // return $all_posts;

        //todo: push all relative tags to the corresponding post
        for ($i = 0; $i < sizeOf($all_posts); $i++) {
            $post = $all_posts[$i];
            $relative_tag = DB::select(
                "SELECT t.name, t.id
                 FROM tags t, tag_contents tc
                 WHERE t.tag_code = tc.tag_id
                 AND tc.content_id::integer = {$post->post_id}
                 AND t.type = 'post'
                "
            );
            $post->tags = $relative_tag;
            if ($user) {
                $is_bookmarked = DB::select(
                    "SELECT id
                     FROM bookmarks b
                     WHERE b.content_id = $post->post_id
                     AND b.bookmarker = $user->id
                    "
                );
                $post->bookmarked = $is_bookmarked;
            }
        }
        // return $all_posts;
        $all_questions = DB::select(
            "SELECT *, q.id AS question_id
             FROM questions q, users u
             WHERE q.questioner = u.id
             ORDER BY q.id DESC
            "
        );
        $is_login = $user ? true : false;
        return view('post.post', [
            'all_posts' => $all_posts,
            'all_questions' => $all_questions,
            'is_login' => $is_login,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = Auth::user()->id;
        $all_series = DB::select(
            "SELECT *
             FROM series
             WHERE creator = $user_id
             ORDER BY id DESC
            "
        );
        // return $all_series;
        return view('post.create-post', [
            'all_series' => $all_series,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $user_id = Auth::user()->id;
        // todo: store new post
        $new_post = new Post;
        $new_post->title = $request->title;
        $new_post->content = $request->content;
        $new_post->creator = $user_id;
        $new_post->made = "internal";
        $new_post->time = $request->time;
        $new_post->save();
        // todo: get latest post id
        $recent_post = DB::select(
            "SELECT *
             FROM posts
             WHERE creator = '$user_id'
             ORDER BY id DESC
             LIMIT 1
            "
        )[0];
        // todo: store tags
        $array_tags = explode(',', $request->tag);
        foreach ($array_tags as $tag_name) {
            $coressponding_tag = DB::select(
                "SELECT *
                 FROM tags
                 WHERE name = '$tag_name'
                 LIMIT 1
                "
            );
            if ($coressponding_tag) {
                $tag_code = $coressponding_tag[0]->tag_code;
                $new_tag_content = new TagContent;
                $new_tag_content->tag_id = $tag_code;
                $new_tag_content->content_id = $recent_post->id;
                $new_tag_content->save();
            } else {
                $new_tag_code = generate_code(10);
                $new_tag = new Tag;
                $new_tag->tag_code = $new_tag_code;
                $new_tag->name = $tag_name;
                $new_tag->creator = $user_id;
                $new_tag->type = "post";
                $new_tag->save();

                $new_tag_content = new TagContent;
                $new_tag_content->tag_id = $new_tag_code;
                $new_tag_content->content_id = $recent_post->id;
                $new_tag_content->save();
            }
        }

        // todo: store files
        if ($request->hasFile('file')) {
            $all_files = $request->file('file');
            foreach ($all_files as $file) {
                $name_file = $file->getClientOriginalName();
                $extension_file = $file->getClientOriginalExtension();
                $current_time = time();
                $fixed_file = $current_time . "." . $name_file;
                $dest_path = public_path("assets/files/{$user_id}/");
                $file->move($dest_path, $fixed_file);

                $new_file = new File;
                $new_file->belong = $recent_post->id;
                $new_file->alias = $name_file;
                $new_file->type = $extension_file;
                $new_file->url = "/" . $user_id . "/" . $fixed_file;
                // $new_file->tag =  $request->file_tag;
                $new_file->tag =  "tag_xample";
                $new_file->save();
            }
        }

        // todo: store series_post
        $array_series = explode(',', $request->array_series);
        foreach ($array_series as $series) {
            $new_series_post = new SeriesPost;
            $new_series_post->series_id = (int)$series;
            $new_series_post->post_id = $recent_post->id;
            $new_series_post->save();
        }

        return redirect()->route('post.create')->with('success', 'Bài viết đã được công bố!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name_id)
    {
        $user_id = Auth::user()->id;
        $split_request = explode('|', $name_id);
        $post_id = end($split_request);
        // return $post_id;
        $corresponding_post = DB::select(
            "SELECT * , u.id as user_id, p.id as post_id
             FROM users u, posts p
             WHERE p.id = {$post_id}
             AND p.creator::integer = u.id 
            "
        )[0];
        // return $corresponding_post;
        $relative_tag = DB::select(
            "SELECT t.name
             FROM tags t, tag_contents tc
             WHERE t.tag_code = tc.tag_id
             AND tc.content_id::integer = {$post_id}
             AND t.type = 'post'
            "
        );
        // return $relative_tag;
        //todo: push all relative tags to the corresponding post
        $relative_post = DB::select(
            "SELECT *
             FROM posts
             WHERE posts.creator = '{$corresponding_post->user_id}'
             AND posts.id != $post_id::integer
            "
        );
        // return $relative_post;

        $relative_file = DB::select(
            "SELECT *
             FROM files
             WHERE files.belong = $post_id::integer
            "
        );
        $series_posts = DB::select(
            "SELECT *, s.id AS series_id
             FROM series s, series_posts sp
             WHERE sp.post_id = $post_id
             AND s.id = sp.series_id
            "
        );
        // return $series_posts;
        for ($i = 0; $i < sizeof($series_posts); $i++) {
            $series_element = $series_posts[$i];
            $posts_of_series = DB::select(
                "SELECT *
                 FROM posts p, series_posts sp
                 WHERE p.id = sp.post_id
                 AND sp.series_id = $series_element->series_id
                "
            );
            $series_posts[$i]->relative_posts = $posts_of_series;
        }
        // return $series_posts;
        $is_author = ($corresponding_post->creator == $user_id) ? true : false;
        // return $is_author;
        $get_follower = DB::select(
            "SELECT *
             FROM follows
             WHERE followed = $corresponding_post->creator
             AND follower = $user_id
            "
        );
        // return empty($get_follower);
        $is_following = empty($get_follower) ? false : true;
        // return $is_following;
        $amount_post = DB::select(
            "SELECT COUNT(*)
             FROM posts
             WHERE creator::integer = $corresponding_post->creator
            "
        )[0]->count;
        $amount_follower = DB::select(
            "SELECT COUNT(*)
             FROM follows
             WHERE followed = $user_id
            "
        )[0]->count;
        return view('post.view-post', [
            'is_author' => $is_author,
            'corresponding_post' => $corresponding_post,
            'relative_post' => $relative_post,
            'relative_file' => $relative_file,
            'series_posts' => $series_posts,
            'relative_tag' => $relative_tag,
            'is_following' => $is_following,
            'amount_post' => $amount_post,
            'amount_follower' => $amount_follower,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return $id;
        $corresponding_post = DB::select(
            "SELECT *
             FROM posts
             WHERE posts.id = $id
            "
        )[0];
        // return $corresponding_post;
        $corresponding_tag = DB::select(
            "SELECT t.name
             FROM tags t, tag_contents tc
             WHERE t.tag_code = tc.tag_id
             AND tc.content_id::integer = $id
             AND t.type = 'post'
            "
        );
        // return $corresponding_tag;
        $all_series = DB::select(
            "SELECT name, id
             FROM series
            "
        );
        // return $all_series;
        for ($i = 0; $i < sizeof($all_series); $i++) {
            $series = $all_series[$i];
            $series_of_post_in_list_series = DB::select(
                "SELECT series_id
                 FROM series_posts
                 WHERE post_id = $id
                 AND series_id = $series->id
                "
            );
            if ($series_of_post_in_list_series) {
                $series->choosen = 'checked';
            }
        }
        // return $all_series;
        return view('post.edit-post', [
            'corresponding_post' => $corresponding_post,
            'corresponding_tag' => $corresponding_tag,
            'all_series' => $all_series,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request;
        $user_id  = Auth::user()->id;
        $split_request = explode('|', $id);
        $post_id = end($split_request);
        DB::update(
            "UPDATE posts
             SET title = '$request->title',
                 content = '$request->content',
                 time = '$request->time'
             WHERE id = $post_id
            "
        );
        $success_delete_tag = DB::delete(
            "DELETE FROM tag_contents
             WHERE content_id::integer = $post_id
            "
        );
        // todo: update tags
        $array_tags = explode(',', $request->tag);
        foreach ($array_tags as $tag_name) {
            $coressponding_tag = DB::select(
                "SELECT *
                 FROM tags
                 WHERE name = '$tag_name'
                 LIMIT 1
                "
            );
            if ($coressponding_tag) {
                $code_of_tag = $coressponding_tag[0]->tag_code;
                $post_in_series = DB::select(
                    "SELECT *
                    FROM tag_contents
                    WHERE tag_id = '$code_of_tag'
                    AND content_id::integer = $post_id
                  "
                );
                if (!$post_in_series) {
                    $new_tag_content = new TagContent;
                    $new_tag_content->tag_id = $code_of_tag;
                    $new_tag_content->content_id = $post_id;
                    $new_tag_content->save();
                }
            } else {
                $new_tag_code = generate_code(10);
                $new_tag = new Tag;
                $new_tag->tag_code = $new_tag_code;
                $new_tag->name = $tag_name;
                $new_tag->creator = $user_id;
                $new_tag->type = "post";
                $new_tag->save();

                $new_tag_content = new TagContent;
                $new_tag_content->tag_id = $new_tag_code;
                $new_tag_content->content_id = $post_id;
                $new_tag_content->save();
            }
        }
        // todo: update series
        $success_delete_series = DB::delete(
            "DELETE FROM series_posts
             WHERE post_id = $post_id
            "
        );
        $array_series = explode(',', $request->array_series);
        foreach ($array_series as $series) {
            $new_series_post = new SeriesPost;
            $new_series_post->series_id = (int)$series;
            $new_series_post->post_id = $post_id;
            $new_series_post->save();
        }
        return redirect()->route(route: 'post.show', parameters: $id)->with('success', 'Cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return $id;
        DB::delete(
            "DELETE FROM posts
             WHERE id = $id
            "
        );
        return redirect()->route(route: 'post.index')->with('success', 'Xóa thành công');
    }


    // public function comment(Request $request)
    // {
    //     $new_comment = new Post_comment;
    //     $new_comment->for = $request->post_id;
    //     $new_comment->replier = Auth::user()->id;
    //     $new_comment->content = $request->comment;
    //     $new_comment->save();

    //     return response()->json([
    //         "status" => "200",
    //         "message" => "Phát ngôn thành công!"
    //     ]);
    // }
}

<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Post;
use App\Models\Tag;
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
        $all_posts = DB::select(
            "SELECT * 
             FROM public.users, public.posts
             WHERE 
                    users.id = posts.creator::integer
            "
        );
        //todo: get all post but not contain any tags
        // return $all_posts;

        foreach ($all_posts as $post) {
            $relative_tag = DB::select(
                "SELECT  tag_one, tag_two, tag_three, tag_four, tag_five
                 FROM tags
                 WHERE tags.from = {$post->id}
                "
            );
            $post_index = array_search($post, $all_posts);
            $all_posts[$post_index]->tags = $relative_tag;
            //todo: push all relative tags to the corresponding post 
        }
        // return $all_posts;
        return view('post.post', [
            'all_posts' => $all_posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create-post');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $array_tag = explode(' ', $request->tag);

        $new_post = new Post;
        $new_post->title = $request->title;
        $new_post->content = $request->content;
        $new_post->creator = $user_id;
        $new_post->made = "internal";
        $new_post->time = $request->time;
        $new_post->save();

        $recent_post = DB::select(
            "SELECT *
             FROM posts
             WHERE creator = '$user_id'
             ORDER BY id DESC
             LIMIT 1
            "
        )[0];

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

        $new_tag = new Tag;
        $new_tag->from = $recent_post->id;
        $new_tag->of = "post";
        $new_tag->tag_one = isset($array_tag[0]) ? $array_tag[0] : 'null';
        $new_tag->tag_two = isset($array_tag[1]) ? $array_tag[1] : 'null';
        $new_tag->tag_three = isset($array_tag[2]) ? $array_tag[2] : 'null';
        $new_tag->tag_four = isset($array_tag[3]) ? $array_tag[3] : 'null';
        $new_tag->tag_five = isset($array_tag[4]) ? $array_tag[4] : 'null';
        $new_tag->save();

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
        $post_id = explode('|', $name_id)[1];
        $corresponding_post = DB::select(
            "SELECT * 
             FROM posts, users
             WHERE posts.id = {$post_id}
                   AND posts.creator::integer = users.id 
            "
        )[0];
        $relative_tag = DB::select(
            "SELECT  tag_one, tag_two, tag_three, tag_four, tag_five
                FROM tags
                WHERE tags.from = {$post_id}
            "
        )[0];
        // return $corresponding_post;
        $relative_post = DB::select(
            "SELECT *
             FROM posts
             WHERE posts.creator = '{$corresponding_post->id}'
             AND posts.id != $post_id::integer
            "
        );
        // return $relative_post;
        $corresponding_post->tags = $relative_tag;
        //todo: push all relative tags to the corresponding post 

        $relative_file = DB::select(
            "SELECT *
             FROM files
             WHERE files.belong = $post_id::integer
            "
        );
        // return $relative_file;
        return view('view-post', [
            'corresponding_post' => $corresponding_post,
            'relative_post' => $relative_post,
            'relative_file' => $relative_file,
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

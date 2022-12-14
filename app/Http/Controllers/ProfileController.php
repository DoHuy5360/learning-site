<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_informations = DB::select(
            "SELECT *, u.id AS user_id
             FROM users u
             WHERE u.id = $id
            "
        )[0];
        $user_posts = DB::select(
            "SELECT * 
             FROM users u, posts p
             WHERE u.id = p.creator::integer
             AND p.creator::integer = $id
            "
        );
        //todo: push all relative tags to the corresponding post 
        foreach ($user_posts as $post) {
            $relative_tag = DB::select(
                "SELECT t.name, t.id
                 FROM tags t, tag_contents tc
                 WHERE t.tag_code = tc.tag_id
                 AND tc.content_id::integer = {$post->id}
                 AND t.type = 'post'
                "
            );
            $post_index = array_search($post, $user_posts);
            $user_posts[$post_index]->tags = $relative_tag;
        }
        // return $user_posts;
        $user_questions = DB::select(
            "SELECT *, q.id AS question_id
             FROM questions q, users u
             WHERE q.questioner = $id
             AND u.id = $id
            "
        );
        $user_answers = DB::select(
            "SELECT qa.answer_code,
                    qa.created_at,
                    qa.content,
                    q.title,
                    q.id AS question_id
             FROM question_answers qa, questions q
             WHERE qa.replier::integer = $id
             AND qa.content_type = q.id
            "
        );
        $user_tags = DB::select(
            "SELECT name
             FROM tags
             WHERE creator::integer = $id
            "
        );
        // return $user_tags;

        $user_series = DB::select(
            "SELECT *
             FROM series
             WHERE creator = $id
            "
        );
        // return $user_series;
        for ($i = 0; $i < sizeof($user_series); $i++) {
            $series_element = $user_series[$i];
            $relative_posts_series = DB::select(
                "SELECT p.title, p.time, p.created_at, p.id
                 FROM posts p, series_posts sp
                 WHERE sp.series_id = $series_element->id
                 AND sp.post_id = p.id                
                "
            );
            $series_element->relative_posts = $relative_posts_series;
        }
        // return $user_series;
        $user_bookmarks = DB::select(
            "SELECT *, p.id AS post_id, b.id AS bookmark_id
             FROM bookmarks b, posts p, users u
             WHERE b.bookmarker = $id
             AND b.content_id = p.id
             AND p.creator::integer = u.id
             ORDER BY b.id DESC
            "
        );
        // return $user_bookmarks;
        $user_following = DB::select(
            "SELECT *, u.id AS following_id
             FROM follows f, users u
             WHERE f.follower = $id
             AND f.followed = u.id
            "
        );
        // return $user_following;
        $user_follower = DB::select(
            "SELECT *, u.id AS follower_id
             FROM follows f, users u
             WHERE f.follower = u.id
             AND f.followed = $id
            "
        );
        // return $user_follower;

        return view('profile.view-profile', [
            'user_informations' => $user_informations,
            'user_posts' => $user_posts,
            'user_questions' => $user_questions,
            'user_answers' => $user_answers,
            'user_tags' => $user_tags,
            'user_series' => $user_series,
            'user_following' => $user_following,
            'user_follower' => $user_follower,
            'user_bookmarks' => $user_bookmarks,
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
        return view('profile.edit-profile', [
            'profile_id' => $id
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
        if ($request->hasFile('avatar')) {
            $avatar_file = $request->file('avatar');
            // $file_extension = $avatar_file->getClientOriginalExtension();
            $fixed_name = 'avatar.png';
            $dest_path = public_path("assets/avatar/{$id}/");
            $avatar_file->move($dest_path, $fixed_name);

            DB::update(
                "UPDATE users
                 SET avatar = 'assets/avatar/{$id}/avatar.png'
                 WHERE id = $id
                "
            );
            return redirect()->route('profile.show', $id);
        } else {
            return "Ch??a c?? file";
        }
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

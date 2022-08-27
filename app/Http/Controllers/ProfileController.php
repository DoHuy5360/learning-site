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
        $user_id = Auth::user()->id;
        $user_informations = DB::select(
            "SELECT *
             FROM users u
             WHERE u.id = $user_id
            "
        )[0];
        $user_posts = DB::select(
            "SELECT * 
             FROM users u, posts p
             WHERE u.id = p.creator::integer
            "
        );
        //todo: push all relative tags to the corresponding post 
        foreach ($user_posts as $post) {
            $relative_tag = DB::select(
                "SELECT t.name
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
            "SELECT *, questions.id AS question_id
             FROM questions, users
             WHERE questions.questioner = users.id
            "
        );
        $user_answers = DB::select(
            "SELECT qa.answer_code,
                    qa.created_at,
                    qa.content,
                    q.title,
                    q.id AS question_id
             FROM question_answers qa, questions q
             WHERE qa.replier::integer = $user_id
             AND qa.content_type = q.id
            "
        );
        $user_tags = DB::select(
            "SELECT name
             FROM tags
             WHERE creator::integer = $user_id
            "
        );
        // return $user_tags;

        $user_series = DB::select(
            "SELECT *
             FROM series
            "
        );
        for ($i = 0; $i < sizeof($user_series); $i++) {
            $series_element = $user_series[$i];
            $relative_posts_series = DB::select(
                "SELECT p.title, p.time, p.created_at
                 FROM posts p, series_posts sp
                 WHERE sp.series_id = $series_element->id
                 AND sp.post_id = p.id                
                "
            );
            $series_element->relative_posts = $relative_posts_series;
        }
        // return $user_series;
        $user_following = DB::select(
            "SELECT *
             FROM follows f, users u
             WHERE f.follower = $user_id
             AND f.followed = u.id
            "
        );
        // return $user_following;
        $user_follower = DB::select(
            "SELECT *
             FROM follows f, users u
             WHERE f.follower = u.id
             AND f.followed = $user_id
            "
        );
        // return $user_follower;
        $amount_following = sizeof($user_following);
        $amount_post = DB::select(
            "SELECT COUNT(*)
             FROM posts
             WHERE creator::integer = $user_id
            "
        )[0]->count;
        // return $amount_post;
        $amount_tag = DB::select(
            "SELECT COUNT(*)
             FROM tags
             WHERE creator::integer = $user_id
            "
        )[0]->count;
        // return $amount_tag;
        return view('profile.view-profile', [
            'user_informations' => $user_informations,
            'user_posts' => $user_posts,
            'user_questions' => $user_questions,
            'user_answers' => $user_answers,
            'user_tags' => $user_tags,
            'user_series' => $user_series,
            'user_following' => $user_following,
            'user_follower' => $user_follower,
            'amount_following'=> $amount_following,
            'amount_post' => $amount_post,
            'amount_tag' => $amount_tag,
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

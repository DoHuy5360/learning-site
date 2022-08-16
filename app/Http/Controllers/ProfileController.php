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
                "SELECT  tag_one, tag_two, tag_three, tag_four, tag_five
                 FROM tags
                 WHERE tags.from = {$post->id}
                "
            );
            $post_index = array_search($post, $user_posts);
            $user_posts[$post_index]->tags = $relative_tag;
        }
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
            "SELECT  tag_one, tag_two, tag_three, tag_four, tag_five
             FROM tags
             WHERE creator = $user_id
            "
        );
        $all_tags = [];
        foreach ($user_tags as $key => $value) {
            array_push($all_tags, $value->tag_one);
            array_push($all_tags, $value->tag_two);
            array_push($all_tags, $value->tag_three);
            array_push($all_tags, $value->tag_four);
            array_push($all_tags, $value->tag_five);
        }
        $array_tags =  array_unique($all_tags);
        return view('profile.profile',[
            'user_informations'=>$user_informations,
            'user_posts'=>$user_posts,
            'user_questions'=>$user_questions,
            'user_answers'=>$user_answers,
            'array_tags'=>$array_tags,
        ]);
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
        //
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

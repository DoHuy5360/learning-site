<?php

namespace App\Http\Controllers;

use App\Models\Question_answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Question_answerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // return $request;
        $user_id = Auth::user()->id;
        $new_comment = new Question_answer;
        $new_comment->answer_code = generate_code(10);
        $new_comment->content_type = $request->question_id;
        $new_comment->content = $request->content;
        $new_comment->replier = $user_id;
        $new_comment->save();

        $data_answer = DB::select(
            "SELECT u.name, u.avatar, u.email, q.created_at
             FROM users u, question_answers q
             WHERE u.id = $user_id 
             AND q.replier = $user_id
             ORDER BY q.id DESC
             LIMIT 1
            "
        )[0];

        return response()->json([
            'data_answer' => $data_answer,
        ]);
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

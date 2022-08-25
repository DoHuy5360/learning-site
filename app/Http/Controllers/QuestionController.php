<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_questions = DB::select(
            "SELECT *, questions.id AS question_id
             FROM questions, users
             WHERE questions.questioner = users.id
            "
        );
        return view('question.question', [
            'all_questions' => $all_questions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('question.create-question');
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
        $question_code = generate_code(10);
        $new_question = new Question;
        $new_question->question_code = $question_code;
        $new_question->questioner = $user_id;
        $new_question->title = $request->title;
        $new_question->content = $request->content;
        // $new_question->vote = "" ;
        // $new_question->slug = "";
        $new_question->save();
        return redirect()->back()->with("success", "Câu hỏi đã được công bố.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $corresponding_question = DB::select(
            "SELECT *
             FROM questions, users
             WHERE questions.questioner = users.id
             AND questions.id = $id
            "
        )[0];
        $all_answers = DB::select(
            "SELECT *
             FROM question_answers, users
             WHERE question_answers.content_type = $id
             AND question_answers.replier = users.id
            "
        );
        return view('question.view-question', [
            'corresponding_question' => $corresponding_question,
            'question_id' => $id,
            'all_answers'=> $all_answers,
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

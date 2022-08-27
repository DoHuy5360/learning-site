<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Tag;
use App\Models\TagContent;
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
        // return $all_questions;

        // $relative_post = DB::select(
        //     "SELECT *
        //      FROM post
        //     "
        // );
        return view('question.question', [
            // '' => $,
        ]);
    }
    public function getQuestions()
    {
        $all_questions = DB::select(
            "SELECT *, questions.id AS question_id
             FROM questions, users
             WHERE questions.questioner = users.id
            "
        );
        // return $all_questions;
        for ($i = 0; $i < sizeof($all_questions); $i++) {
            $question_id = $all_questions[$i]->question_id;
            $relative_tag = DB::select(
                "SELECT t.name
                 FROM tags t, tag_contents tc
                 WHERE t.tag_code = tc.tag_id
                 AND tc.content_id::integer = $question_id
                "
            );
            $all_questions[$i]->tags = $relative_tag;
        }
        return response()->json(
            [
                'all_questions' => $all_questions
            ]
        );
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

        $recent_question = DB::select(
            "SELECT *
             FROM questions
             WHERE questioner = '$user_id'
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
                $new_tag_content->content_id = $recent_question->id;
                $new_tag_content->save();
            } else {
                $new_tag_code = generate_code(10);
                $new_tag = new Tag;
                $new_tag->tag_code = $new_tag_code;
                $new_tag->name = $tag_name;
                $new_tag->creator = $user_id;
                $new_tag->type = "question";
                $new_tag->save();

                $new_tag_content = new TagContent;
                $new_tag_content->tag_id = $new_tag_code;
                $new_tag_content->content_id = $recent_question->id;
                $new_tag_content->save();
            }
        }

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
            'all_answers' => $all_answers,
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

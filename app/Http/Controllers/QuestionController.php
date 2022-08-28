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

        $relative_posts = DB::select(
            "SELECT *
             FROM posts p, users u
             WHERE u.id = p.creator::integer
             ORDER BY u.id DESC
             LIMIT 1
            "
        );
        // return $relative_posts;
        $all_questions_length = DB::select(
            "SELECT COUNT(*)
             FROM questions, users
             WHERE questions.questioner = users.id
            "
        )[0]->count / 7;
        // return $all_questions_length;
        return view('question.question', [
            'all_questions_length' => $all_questions_length,
            'relative_posts' => $relative_posts,
        ]);
    }
    public function getQuestions($index)
    {
        // return $index;
        $range = 7;
        $start = ($index - 1) * $range;
        $all_questions = DB::select(
            "SELECT *, q.id AS question_id
             FROM questions q, users u
             WHERE q.questioner = u.id
             ORDER BY q.id DESC
             LIMIT $range OFFSET $start
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
    public function getRelativePost($tag)
    {
        // return $tag;
        $array_tags = explode(',', $tag);
        $relative_posts = DB::select(
            "SELECT *, p.id AS post_id
             FROM posts p, users u
             WHERE u.id = p.creator::integer
             ORDER BY u.id DESC
            --  LIMIT 1
            "
        );
        // return $relative_posts;
        $all_relative_posts = [];
        for ($i = 0; $i < sizeof($relative_posts); $i++) {
            $select_post = $relative_posts[$i];
            $relative_tag = DB::select(
                "SELECT t.name
                 FROM tags t, tag_contents tc
                 WHERE t.tag_code = tc.tag_id
                 AND tc.content_id::integer = $select_post->post_id
                 AND t.type = 'post'
                "
            );
            $select_post->tag = $relative_tag;
            foreach ($relative_tag as $tag) {
                if (in_array($tag->name, $array_tags)) {
                    $all_relative_posts[$i] = $select_post;
                    break;
                }
            }
        };
        // return $relative_posts;
        // return $all_relative_posts;
        return response()->json(
            [
                'all_relative_posts' => $all_relative_posts,
                'array_tags' => $array_tags,
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

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

        $all_questions = DB::select(
            "SELECT q.id
             FROM questions q, users u
             WHERE q.questioner = u.id
            "
        );
        // return $all_questions_length;
        $all_questions_length = round(sizeof($all_questions) / 7);
        return view('question.question', [
            'all_questions_length' => $all_questions_length,
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
        $array_tag_name = [];
        $all_tag_name = DB::select(
            "SELECT t.name
             FROM tags t
             WHERE t.type = 'post'
            "
        );
        foreach ($all_tag_name as $tag) {
            array_push($array_tag_name, $tag->name);
        }
        // return $array_tag_name;
        for ($i = 0; $i < sizeof($all_questions); $i++) {
            $target_question = $all_questions[$i];
            // todo: Lấy danh sách tags của câu hỏi này
            $question_id = $target_question->question_id;
            $relative_tag = DB::select(
                "SELECT t.name, t.id
                 FROM tags t, tag_contents tc
                 WHERE t.tag_code = tc.tag_id
                 AND tc.content_id::integer = $question_id
                "
            );
            $target_question->tags = $relative_tag;
            $target_question->have_relative_posts = false;
            foreach ($relative_tag as $tag) {
                if (in_array($tag->name, $array_tag_name)) {
                    $target_question->have_relative_posts = true;
                    break;
                }
            }
            // todo: Lấy danh sách người trả lời câu hỏi này
            $anser_question = DB::select(
                "SELECT DISTINCT ON (u.id) *
                 FROM question_answers qa, users u
                 WHERE qa.content_type = $target_question->question_id
                 AND qa.replier = u.id
                "
            );
            $target_question->answers = $anser_question;
            // todo: Lấy số lượng câu trả lời
            $amount_anser = DB::select(
                "SELECT COUNT(qa.id)
                 FROM question_answers qa, users u
                 WHERE qa.content_type = $target_question->question_id
                 AND qa.replier = u.id
                "
            );
            $target_question->amount_anser = $amount_anser[0]->count;
        }
        // return $all_questions;
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
                    array_push($all_relative_posts, $select_post);
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
    public function acceptQuestion(Request $request)
    {
        DB::update(
            "UPDATE question_answers
             SET accepted = false
             WHERE content_type = $request->question_id
            "
        );
        DB::update(
            "UPDATE question_answers
             SET accepted = true
             WHERE id = $request->answer_id
            "
        );
        DB::update(
            "UPDATE questions
             SET solved = true
             WHERE id = $request->question_id
            "
        );
        return response()->json(
            [
                'response' => true
            ]
        );
    }
    public function unacceptQuestion(Request $request)
    {
        DB::update(
            "UPDATE question_answers
             SET accepted = false
             WHERE id = $request->answer_id
            "
        );
        DB::update(
            "UPDATE questions
             SET solved = false
             WHERE id = $request->question_id
            "
        );
        return response()->json(
            [
                'response' => true
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

        return redirect()->route('question.show', $recent_question->id)->with("success", "Câu hỏi đã được công bố.");
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
            "SELECT *, q.id AS question_id, u.id AS author
             FROM questions q, users u
             WHERE q.questioner = u.id
             AND q.id = $id
            "
        )[0];
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $get_follower = DB::select(
                "SELECT *
                 FROM follows f, users u
                 WHERE f.followed = $corresponding_question->questioner
                 AND f.follower = $user_id
                "
            );
            // return empty($get_follower);
            $is_following = empty($get_follower) ? false : true;
            // return $is_following;

            $is_bookmarked = DB::select(
                "SELECT id
                 FROM bookmarks b
                 WHERE b.content_id = $corresponding_question->question_id
                 AND b.bookmarker = $user_id
                "
            );
            // $is_author = ($corresponding_post->creator == $corresponding_post->creator) ? true : false;
            // return $is_author;
        } else {
            $get_follower = false;
            $is_bookmarked = false;
            $is_following = false;
        }
        $relative_tags = DB::select(
            "SELECT t.name, t.id
             FROM tags t, tag_contents tc
             WHERE tc.content_id::integer = $corresponding_question->question_id
             AND tc.tag_id = t.tag_code
            "
        );
        // return $corresponding_question;
        $all_answers = DB::select(
            "SELECT *, u.id AS user_id, qa.id AS answer_id
             FROM question_answers qa, users u
             WHERE qa.content_type = $id
             AND qa.replier = u.id
            "
        );
        return view('question.view-question', [
            'corresponding_question' => $corresponding_question,
            'relative_tags' => $relative_tags,
            'question_id' => $id,
            'all_answers' => $all_answers,
            'is_following' => $is_following,
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

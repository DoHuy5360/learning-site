<?php

namespace App\Http\Controllers;

use App\Models\Reply_answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class Reply_answerController extends Controller
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
        $reply_code = generate_code(10);
        $new_reply = new Reply_answer;
        $new_reply->reply_code = $reply_code;
        $new_reply->content_type = $request->question_id;
        $new_reply->reply_for = $request->reply_for;
        $new_reply->answer_replier = $user_id;
        $new_reply->content = $request->content;
        $new_reply->save();

        $reply_information = DB::select(
            "SELECT
                    r.reply_code,
                    r.content,
                    r.created_at,
                    u.avatar,
                    u.name
             FROM reply_answers r, users u
             WHERE r.answer_replier = u.id
             AND r.content_type = $request->question_id
             ORDER BY r.id DESC
             LIMIT 1
            "
        )[0];


        return response()->json([
            'reply_information' => $reply_information
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
        $all_reply = DB::select(
            "SELECT DISTINCT ON (r.id) 
             r.reply_code, 
             r.content, 
             r.reply_for, 
             r.created_at, 
             u.avatar,
             u.email,
             u.name
             FROM reply_answers r, users u
             WHERE r.answer_replier = u.id
             AND r.content_type = $id
            "
        );
        return response()->json([
            'all_reply' => $all_reply
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

<?php

namespace App\Http\Controllers;

use App\Models\Reply_comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Reply_commentController extends Controller
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
        $new_reply = new Reply_comment;
        $new_reply->reply_code = generate_code(10);
        $new_reply->content_type = $request->post_id;
        $new_reply->reply_for = $request->reply_for;
        $new_reply->comment_replier = Auth::user()->id;
        $new_reply->reply_content = $request->reply_content;
        $new_reply->save();

        $relatest_reply = DB::select(
            "SELECT *, rc.reply_content AS content, rc.reply_code as comment_code
             FROM reply_comments rc, users u
             WHERE rc.content_type = $request->post_id
             AND rc.comment_replier = u.id
             ORDER BY rc.id DESC
             LIMIT 1 OFFSET 0
            "
        );
        return response()->json(
            [
                'relatest_reply' => $relatest_reply
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $relative_replies = DB::select(
            "SELECT *, rc.reply_content AS content, rc.reply_code as comment_code
             FROM reply_comments rc, users u
             WHERE rc.content_type = $id
             AND rc.comment_replier = u.id
             ORDER BY rc.id ASC
            "
        );
        // return $relative_replies;
        return response()->json([
            "relative_replies" => $relative_replies,
            "csrf" => csrf_token(),
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

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
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reply_relative = DB::select(
            "SELECT DISTINCT ON (reply_comments.id) *
             FROM reply_comments, post_comments, users
             WHERE reply_comments.content_type = $id
             AND reply_comments.comment_replier = users.id
             ORDER BY reply_comments.id ASC
            "
        );
        // return $reply_relative;
        return response()->json([
            "reply_information" => $reply_relative,
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

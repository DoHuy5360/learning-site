<?php

namespace App\Http\Controllers;

use App\Models\Post_comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Post_commentController extends Controller
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_comment = new Post_comment;
        $new_comment->for = $request->post_id;
        $new_comment->comment_code = generate_code(10);
        $new_comment->replier = Auth::user()->id;
        $new_comment->content = $request->comment;
        $new_comment->save();

        $relatest_comment = DB::select(
            "SELECT *
             FROM post_comments pc, users u
             WHERE pc.for = $request->post_id
             AND pc.replier = u.id
             ORDER BY pc.id DESC
             LIMIT 1 OFFSET 0
            "
        );

        return response()->json(
            [
                'relatest_comment' => $relatest_comment,
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
    }
    function getComments($id, $index)
    {
        $range = 7;
        $start = ($index - 1) * $range;
        $relative_comments = DB::select(
            "SELECT *, pc.id AS comment_id, u.id AS author_id
             FROM post_comments pc, users u
             WHERE pc.for = $id
             AND pc.replier = u.id
             ORDER BY pc.id DESC
             LIMIT $range OFFSET $start
            "
        );
        // return $relative_comment;
        return response()->json(
            [
                'relative_comments' => $relative_comments,
            ]
        );
        return view('comment.view-comment', [
            'post_id' => $id,
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_tags = DB::select(
            "SELECT *
             FROM tags
            "
        );
        return view('tag.tag', [
            'all_tags' => $all_tags,
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
        $tag_info = DB::select(
            "SELECT *
             FROM tags t
             WHERE t.id =$id
            "
        )[0];
        $relative_posts = DB::select(
            "SELECT *, p.id AS post_id
             FROM posts p, tags t, tag_contents tc, users u
             WHERE t.id = $id
             AND tc.tag_id = t.tag_code
             AND tc.content_id::integer = p.id
             AND p.creator::integer = u.id
            "
        );
        $relative_questions = DB::select(
            "SELECT *, q.id AS question_id
             FROM questions q, tags t, tag_contents tc, users u
             WHERE t.id = $id
             AND tc.tag_id = t.tag_code
             AND tc.content_id::integer = q.id
             AND q.questioner::integer = u.id
            "
        );
        $content_creators = DB::select(
            "SELECT *
             FROM tags t, tag_contents tc, users u, posts p
             WHERE t.id = $id
             AND t.tag_code = tc.tag_id
             AND tc.content_id::integer = p.id
             AND p.creator::integer = u.id
            "
        );
        $tag_series = DB::select(
            "SELECT *, s.id AS series_id, s.name AS series_name
             FROM series s, posts p, series_posts sp, tags t, tag_contents tc
             WHERE sp.series_id = s.id
             AND t.id = $id
             AND t.tag_code = tc.tag_id
             AND sp.post_id = p.id
             AND tc.content_id::integer = p.id
            "
        );
        for ($i = 0; $i < sizeof($tag_series); $i++) {
            $series_element = $tag_series[$i];
            $relative_posts_series = DB::select(
                "SELECT p.title, p.time, p.created_at, p.id
                 FROM posts p, series_posts sp
                 WHERE sp.series_id = $series_element->series_id
                 AND sp.post_id = p.id                
                "
            );
            $series_element->relative_posts = $relative_posts_series;
        }
        $popular_tags = DB::select(
            "SELECT t.id, t.name, COUNT(p.id) AS amount_posts
             FROM posts p, tags t, tag_contents tc
             WHERE p.id = tc.content_id::integer
             AND t.tag_code = tc.tag_id
             GROUP BY t.id
             LIMIT 10
            "
        );
        // return $tag_series;
        return view('tag.view-tag', [
            'tag_info' => $tag_info,
            'relative_posts' => $relative_posts,
            'relative_questions' => $relative_questions,
            'tag_series' => $tag_series,
            'content_creators' => $content_creators,
            'popular_tags' => $popular_tags,
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

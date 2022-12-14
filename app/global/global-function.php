<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserData
{
    private $data;
    /**
     * Class constructor.
     */
    function __construct($userId)
    {
        $this->userId = $userId;
    }
    function getUser()
    {
        $user = DB::select(
            "SELECT *
             FROM users u
             WHERE u.id = $this->userId
            "
        )[0];
        return $user;
    }
    function getBookMark($size = false)
    {
        $bookmark = DB::select(
            "SELECT *
             FROM bookmarks b
             WHERE b.bookmarker = $this->userId
            "
        );
        if($size){
            return sizeOf($bookmark);
        }
        return $bookmark;
    }
    function getTag($size = false)
    {
        $tag = DB::select(
            "SELECT *
             FROM tags
             WHERE creator::integer = $this->userId
            "
        );
        if($size){
            return sizeOf($tag);
        }
        return $tag;
    }
    function getPost($size = false)
    {
        $post = DB::select(
            "SELECT *
             FROM posts
             WHERE creator::integer = $this->userId
            "
        );
        if ($size) {
            return sizeof($post);
        }
        return $post;
    }
    function getFollowing($size = false)
    {
        $following = DB::select(
            "SELECT *
             FROM follows f, users u
             WHERE f.follower = $this->userId
             AND f.followed = u.id 
            "
        );
        if($size){
            return sizeOf($following);
        }
        return $following;
    }
    function getFollower($size = false)
    {
        $follower = DB::select(
            "SELECT *
             FROM follows f, users u
             WHERE f.follower = u.id
             AND f.followed = $this->userId
            "
        );
        if ($size) {
            return sizeof($follower);
        }
        return $follower;
    }
    function getQuestion($size = false)
    {
        $question = DB::select(
            "SELECT *
             FROM questions q, users u
             WHERE q.questioner = $this->userId
             AND u.id = $this->userId
            "
        );
        if($size){
            return sizeOf($question);
        }
        return $question;
    }
    function getAnswer($size = false)
    {
        $answer = DB::select(
            "SELECT *
             FROM question_answers qa, questions q
             WHERE qa.replier::integer = $this->userId
             AND qa.content_type = q.id
            "
        );
        if($size){
            return sizeOf($answer);
        }
        return $answer;
    }
}
class PostData
{
    /**
     * Class constructor.
     */
    function __construct($postId)
    {
        $this->postId = $postId;
    }
    function getPost($size = false)
    {
        $post = DB::select(
            "SELECT *
             FROM posts p
             WHERE p.id = $this->postId
             LIMIT 1
            "
        )[0];
        return $post;
    }
    function getAuthor()
    {
        $author = DB::select(
            "SELECT *
             FROM posts p, users u
             WHERE p.id = $this->postId
             AND p.creator::integer = u.id
            "
        )[0];
        return $author;
    }
    function getComment($size = false)
    {
        $comment = DB::select(
            "SELECT *
             FROM post_comments pc
             WHERE pc.for = $this->postId
            "
        );
        if ($size) {
            return sizeof($comment);
        }
        return $comment;
    }
    function getReply($size = false)
    {
        $reply = DB::select(
            "SELECT *
             FROM reply_comments rc
             WHERE rc.content_type = $this->postId
            "
        );
        if ($size) {
            return sizeOf($reply);
        }
        return $reply;
    }
    function getBookMark($size = false)
    {
        $bookmark = DB::select(
            "SELECT *
             FROM bookmarks b
             WHERE b.content_id = $this->postId
             AND b.type = 'post'
            "
        );
        if ($size) {
            return sizeOf($bookmark);
        }
        return $bookmark;
    }
    function getTag($size = false)
    {
        $tag = DB::select(
            "SELECT *, t.id AS tag_id
             FROM tags t, tag_contents tc
             WHERE t.tag_code = tc.tag_id
             AND tc.content_id::integer = $this->postId
             AND t.type = 'post'
            "
        );
        if ($size) {
            return sizeOf($tag);
        }
        return $tag;
    }
    function get()
    {
        $the_post = DB::select(
            "SELECT *
             FROM posts p
             WHERE p.id = $this->postId
             LIMIT 1
            "
        )[0];
        $author = DB::select(
            "SELECT *
             FROM users u
             WHERE u.id = $the_post->creator::integer
             LIMIT 1
            "
        )[0];
        $all_posts = DB::select(
            "SELECT COUNT(p.id)
             FROM posts p
             WHERE p.creator::integer = $author->id
            "
        );
        $all_followers = DB::select(
            "SELECT *
             FROM follows f
             WHERE f.followed = $the_post->creator
            "
        );
        $all_comments = DB::select(
            "SELECT *
             FROM post_comments pc
             WHERE pc.for = $the_post->id
            "
        );
        $all_booksmarks = DB::select(
            "SELECT *
             FROM bookmarks b
             WHERE b.content_id = $the_post->id
             AND b.type = 'post'
            "
        );
        $all_replies = DB::select(
            "SELECT *
             FROM reply_comments rc
             WHERE rc.content_type = $the_post->id
            "
        );
    }
}
class QuestionData{
    /**
     * Class constructor.
     */
    public function __construct($questionId)
    {
        $this->questionId = $questionId;
    }
    function getQuestion(){
        $question = DB::select(
            "SELECT *
             FROM questions q
             WHERE q.id = $this->questionId
            "
        )[0];
        return $question;
    }
    function getAuthor(){
        $author = DB::select(
            "SELECT *
             FROM users u, questions q
             WHERE u.id = q.questioner
             LIMIT 1
            "
        )[0];
        return $author;
    }
    function getTag($size=false){
        $tag = DB::select(
            "SELECT *, t.id AS tag_id
             FROM tags t, tag_contents tc
             WHERE t.tag_code = tc.tag_id
             AND tc.content_id::integer = $this->questionId
            "
        );
        if($size){
            return sizeOf($tag);
        }
        return $tag;
    }
    function getHelper(){
        $helper = DB::select(
            "SELECT DISTINCT ON (u.id) *
             FROM question_answers qa, users u
             WHERE qa.replier = u.id
             AND qa.content_type = $this->questionId
            "
        );
        return $helper;
    }
}
function remove_sign($str)
{
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'a', $str);
    $str = preg_replace("/(??|??|???|???|???|??|???|???|???|???|???)/", 'e', $str);
    $str = preg_replace("/(??|??|???|???|??)/", 'i', $str);
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'o', $str);
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???)/", 'u', $str);
    $str = preg_replace("/(???|??|???|???|???)/", 'y', $str);
    $str = preg_replace("/(??)/", 'd', $str);
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'A', $str);
    $str = preg_replace("/(??|??|???|???|???|??|???|???|???|???|???)/", 'E', $str);
    $str = preg_replace("/(??|??|???|???|??)/", 'I', $str);
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'O', $str);
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???)/", 'U', $str);
    $str = preg_replace("/(???|??|???|???|???)/", 'Y', $str);
    $str = preg_replace("/(??)/", 'D', $str);
    $str = preg_replace("/(\???|\???|\???|\???|\,|\!|\&|\;|\@|\#|\%|\~|\`|\=|\_|\'|\]|\[|\}|\{|\)|\(|\+|\^)/", '-', $str);
    $str = preg_replace("/( )/", '-', $str);
    $str = preg_replace("/\?/", '', $str);
    return $str;
}
function generate_code($code_length = 10)
{
    $all_codes = DB::select(
        "SELECT code
         FROM codes
        "
    );
    $array_codes = [];
    foreach ($all_codes as $code) {
        array_push($array_codes, $code->code);
    }
    $alphachar = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
    $alphachar_length = sizeof($alphachar);
    shuffle($alphachar);
    do {
        $str_code = "";
        for ($i = 0; $i < $code_length; $i++) {
            $rand_num = rand(0, $alphachar_length - 1);
            $rand_char = $alphachar[$rand_num];
            $str_code .= $rand_char;
        };
    } while (in_array($str_code, $array_codes));
    return $str_code;
}

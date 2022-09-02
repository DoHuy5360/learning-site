<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function countIndex()
{
    $user = Auth::user();
    $index = new stdClass;
    $index->bookmark = DB::select(
        "SELECT COUNT(id)
         FROM bookmarks
         WHERE bookmarker = $user->id
        "
    )[0]->count;
    $index->tag = DB::select(
        "SELECT COUNT(id)
         FROM tags
         WHERE creator::integer = $user->id
        "
    )[0]->count;
    $index->post = DB::select(
        "SELECT COUNT(id)
         FROM posts
         WHERE creator::integer = $user->id
        "
    )[0]->count; 
    $index->following = DB::select(
        "SELECT COUNT(f.id)
         FROM follows f, users u
         WHERE f.follower = $user->id
         AND f.followed = u.id 
        "
    )[0]->count;
    $index->follower = DB::select(
        "SELECT COUNT(f.id)
         FROM follows f, users u
         WHERE f.follower = u.id
         AND f.followed = $user->id
        "
    )[0]->count;
    $index->question = DB::select(
        "SELECT COUNT(q.id)
         FROM questions q, users u
         WHERE q.questioner = $user->id
         AND u.id = $user->id
        "
    )[0]->count;
    $index->answer = DB::select(
        "SELECT COUNT(q.id)
         FROM question_answers qa, questions q
         WHERE qa.replier::integer = $user->id
         AND qa.content_type = q.id
        "
    )[0]->count;
    return $index;
}

function remove_sign($str)
{
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    $str = preg_replace("/(\“|\”|\‘|\’|\,|\!|\&|\;|\@|\#|\%|\~|\`|\=|\_|\'|\]|\[|\}|\{|\)|\(|\+|\^)/", '-', $str);
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

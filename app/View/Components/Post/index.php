<?php

namespace App\View\Components\Post;

use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class index extends Component
{
    public $postId;
    public $type;
    /**
     * Create a new component instance.
     *
     * @param int $postId
     * @param string $type
     * @return void
     */
    public function __construct($postId, $type)
    {
        $this->postId = $postId;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
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
        switch ($this->type) {
            case 'comment':
                $amount_index = sizeof($all_comments) + sizeof($all_replies);
                break;
            case 'bookmark':
                $amount_index = sizeof($all_booksmarks);
                break;
            case 'reading_time':
                $amount_index = $the_post->time;
                break;
            case 'created_at':
                $amount_index = $the_post->created_at;
                break;
            case 'post':
                $amount_index = sizeOf($all_posts);
                break;
            case 'follower':
                $amount_index = sizeOf($all_followers);
                break;
            default:
                $amount_index = "app\View\Components\Post\index.php";
                break;
        }

        return view('components.post.index', [
            'amount_index' => $amount_index
        ]);
    }
}

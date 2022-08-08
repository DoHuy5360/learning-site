<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets/css/_root.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/view-post.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/view-comment.css') }}">
</head>

<body>
    <input id="post-id-of-comment" value="{{ $post_id }}" type="hidden" />
    <div id="post-view-all-comment-list">
        @foreach ($relative_comment as $comment)
            <div class="postview__card--comment" data-comment-id="{{ $comment->comment_code }}">
                <div class="postview__card--user-header">
                    <img src="{{ $comment->avatar }}" id="postview-card-comment-user-avatar" alt="" />
                    <div class="projectview-card-comment-user-info">
                        <div class="postview__cardcomment--user-infor-header">
                            <a href="">{{ $comment->name }}</a>
                            <div class="postview__cardcomment--user-icon-list">
                                <img src="./assets/avatar.png" alt="" />
                                <img src="./assets/avatar.png" alt="" />
                                <img src="./assets/avatar.png" alt="" />
                            </div>
                        </div>
                        <div class="postview__cardcomment--user-infor-footer">
                            <div class="postview__cardcomment--user-commenttime">
                                {{ $comment->created_at }}
                            </div>
                            @if ($comment->edit))
                                <ion-icon name="create-outline"></ion-icon>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="postview__card--user-body">
                    {{ $comment->content }}
                </div>
                <div class="postview__card--user-footer">
                    <p class="postview_reply_comment">Tra loi</p>
                    <p>Chia se</p>
                    <p>
                        <ion-icon name="alert-circle-outline"></ion-icon>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    <script src="{{ asset('assets/js/view-comment.js') }}"></script>
</body>
</html>
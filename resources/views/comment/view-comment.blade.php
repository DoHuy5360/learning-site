<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets/css/_root.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/view-post.css') }}">
</head>

<body>
    <input id="post-id-of-comment" value="{{ $post_id }}" type="hidden" />
    <div id="post-view-all-comment-list">
        @foreach ($relative_comment as $comment)
            <div class="postview__card--comment" data-comment-id="{{ $comment->comment_id }}">
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
                            @if ($comment->edit)
                                <ion-icon name="create-outline"></ion-icon>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="postview__card--user-body">
                    {{ $comment->content }}
                </div>
                <div class="postview__card--user-footer">
                    <p>Tra loi</p>
                    <p>Chia se</p>
                    <p>
                        <ion-icon name="alert-circle-outline"></ion-icon>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</body>

</html>
<script>
        let post_id_of_comment = document.getElementById('post-id-of-comment')
        let ajax = new XMLHttpRequest();
    ajax.open("GET", `http://127.0.0.1:8000/reply/${post_id_of_comment.value}`, true);
    ajax.send()
    
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4 && ajax.status == 200 && ajax.responseText) {
            let data = JSON.parse(this.responseText)
            const list_comment = data.reply_information
            list_comment.forEach(comment => {
                const {reply_for, avatar, name, created_at, reply_content} = comment
                const new_comment = createComment(avatar, name, created_at, reply_content)
                const target_comment = document.querySelector(`[data-comment-id="${reply_for}"]`)
                target_comment.insertAdjacentHTML('beforeend',new_comment)
            });
        }
    }
    function createComment(_user_avatar, _user_name, _created_at, _comment_content){
        return `
        <div class="postview__card--comment">
            <div class="postview__card--user-header">
                <img src="${_user_avatar}" id="postview-card-comment-user-avatar" alt="" />
                <div class="projectview-card-comment-user-info">
                        <div class="postview__cardcomment--user-infor-header">
                            <a href="">${_user_name}</a>
                            <div class="postview__cardcomment--user-icon-list">
                                <img src="./assets/avatar.png" alt="" />
                                <img src="./assets/avatar.png" alt="" />
                                <img src="./assets/avatar.png" alt="" />
                                </div>
                                </div>
                                <div class="postview__cardcomment--user-infor-footer">
                                    <div class="postview__cardcomment--user-commenttime">
                                ${_created_at}
                            </div>
                            @if ($comment->edit)
                            <ion-icon name="create-outline"></ion-icon>
                            @endif
                            </div>
                            </div>
                            </div>
                            <div class="postview__card--user-body">
                                ${_comment_content}
                                </div>
                                <div class="postview__card--user-footer">
                                    <p>Tra loi</p>
                                    <p>Chia se</p>
                                    <p>
                                        <ion-icon name="alert-circle-outline"></ion-icon>
                                        </p>
                                        </div>
                                        </div>
                                        `
                                    }

</script>
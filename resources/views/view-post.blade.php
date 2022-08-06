@extends('layouts.header-footer-public')
@section('content')
    <div id="full-height">
        <div id="post-view-body">
            <div id="post-view-content-wrap">
                <div id="post-view-side-bar-left">
                    <div id="post-view-side-bar-element">
                        <img src="{{ $corresponding_post->avatar }}" alt="" />
                        <div id="post-view-side-bar-left-star">
                            <span>238</span>
                            <ion-icon name="star-outline"></ion-icon>
                        </div>
                        <ion-icon name="bookmark-outline"></ion-icon>
                        <ion-icon name="link-outline"></ion-icon>
                        <ion-icon name="alert-circle-outline"></ion-icon>
                    </div>
                </div>
                <div id="post-view-content-left">
                    <div id="card-author-infomation">
                        <div id="post-view-author-avatar">
                            <img src="{{ $corresponding_post->avatar }}" alt="" />
                        </div>
                        <div id="post-view-author-info">
                            <div id="post-view-card-author-left-part">
                                <div id="post-view-author-left-header">
                                    <a href="">{{ $corresponding_post->name }}</a>
                                    <p>{{ $corresponding_post->email }}</p>
                                    <button>Theo dõi</button>
                                </div>
                                <div id="post-view-author-left-footer">
                                    <p class="post-view-user-index">
                                        <ion-icon name="star-outline"></ion-icon>
                                        <span>0</span>
                                    </p>
                                    <p class="post-view-user-index">
                                        <ion-icon name="person-add-outline"></ion-icon>
                                        <span>0</span>
                                    </p>
                                    <p class="post-view-user-index">
                                        <ion-icon name="clipboard-outline"></ion-icon>
                                        <span>0</span>
                                    </p>
                                </div>
                            </div>
                            <div id="post-view-card-author-right-part">
                                <div id="post-view-author-right-header">
                                    <div id="post-view-created-at">
                                        {{ $corresponding_post->created_at }}
                                    </div>
                                    <span>-</span>
                                    <div id="post-view-time-to-read">
                                        <p>
                                            Mất {{ $corresponding_post->time }} để đọc
                                        </p>
                                    </div>
                                </div>
                                <div id="post-view-author-right-footer">
                                    <p class="post-view-user-index">
                                        <ion-icon name="eye-outline"></ion-icon>
                                        <span>0</span>
                                    </p>
                                    <p class="post-view-user-index">
                                        <ion-icon name="chatbubbles-outline"></ion-icon>
                                        <span>0</span>
                                    </p>
                                    <p class="post-view-user-index">
                                        <ion-icon name="bookmark-outline"></ion-icon>
                                        <span>0</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="post-view-main-content">
                        <div id="post-view-main-content-post">
                            {{ $corresponding_post->content }}
                        </div>
                        <div id="post-view-main-content-footer">
                            @foreach ($corresponding_post->tags as $tag_key => $tag_value)
                                @if ($tag_value != 'null')
                                    <p class="postview__tag--element">
                                        <a href="">{{ $tag_value }}</a>
                                    </p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div id="post-view-content-right">
                    <div id="post-view--right-wrap">
                        <div id="post-view-content-menu">
                            <div class="postview__menu--header">
                                <p>Mục Lục</p>
                                <span></span>
                            </div>
                            <div id="post-view-menu-element-list">
                                <p>
                                    <span>1</span><a href="">tile1</a>
                                </p>
                                <p>
                                    <span>2</span><a href="">tile1</a>
                                </p>
                                <p>
                                    <span>3</span><a href="">tile1</a>
                                </p>
                                <p>
                                    <span>4</span><a href="">tile1</a>
                                </p>
                            </div>
                        </div>
                        <div id="post-view-relative-file">
                            <div class="postview__menu--header">
                                <p>File(s) đính kèm</p>
                                <span></span>
                            </div>
                            <div id="post-view-relative-file-list">
                                @if (empty($relative_file))
                                    <p>Không có file</p>
                                @else
                                    @foreach ($relative_file as $file)
                                        <div class="postview__file--element">
                                            <ion-icon name="document-outline"></ion-icon>
                                            <p>{{ $file->alias }}</p>
                                            <a href="{{ asset('assets/files/') . $file->url }}" download>
                                                <button type="button">Tải về</button>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                                {{-- <ion-icon name="folder-outline"></ion-icon> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="post-view-author-other-post">
                <div class="postview__menu--header">
                    <p>Các bài viết khác của {{ $corresponding_post->name }}</p>
                    <span></span>
                </div>
                <div id="post-view-author-orther-list">
                    @foreach ($relative_post as $post)
                        <div class="postview__card--postrelative">
                            <a href="{{ url('/post') . '/' . remove_sign($post->title) . '|' . $post->id }}">
                                <div class="postview__card--postrelative-header">
                                    {{ $post->title }}
                                </div>
                            </a>
                            <div class="postview__card--postrelative-footer">
                                <a href="" class="postview__card--postrelative-author-name">
                                    {{ $corresponding_post->name }}
                                </a>
                                <div class="postview__card--postrelative-time-to-read">
                                    <p>
                                        Đọc trong {{ $post->time }}
                                    </p>
                                </div>
                                <div class="postview__card--postrelative-author-index">
                                    <p>
                                        <ion-icon name="eye-outline"></ion-icon>
                                        <span>0</span>
                                    </p>
                                    <p>
                                        <ion-icon name="star-outline"></ion-icon>
                                        <span>0</span>
                                    </p>
                                    <p>
                                        <ion-icon name="bookmark-outline"></ion-icon>
                                        <span>0</span>
                                    </p>
                                    <p>
                                        <ion-icon name="chatbubbles-outline"></ion-icon>
                                        <span>0</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="post-view-comment-wrap">
                    <div class="postview__menu--header">
                        <p>Bình luận</p>
                        <span></span>
                    </div>
                    <div id="post-view-user-comment-field-wrap">
                        <form action="{{ url('post/') }}" id="post-view-user-comment-field" method="POST">
                            @csrf
                            <input name="post_id" value="{{ $corresponding_post->post_id }}" type="hidden">
                            <textarea name="comment" id="postview-commnent-area"></textarea>
                            <button type="submit">Bình luận
                                <ion-icon name="paper-plane-outline"></ion-icon>
                            </button>
                        </form>
                        <div id="post-view-all-comment-list">
                            @foreach ($relative_comment as $comment)
                                <div class="postview__card--comment">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let comment_form = document.getElementById('post-view-user-comment-field')
        comment_form.addEventListener('submit', e => {
            e.preventDefault();
            let ajax = new XMLHttpRequest();
            ajax.open("POST", comment_form.getAttribute("action"), true);
            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let data = JSON.parse(this.responseText);
                    alert(data.status + " - " + data.message)
                }
                if (this.status == 500) {
                    // alert(this.responseText)
                    alert("Phát ngôn thất bại")
                }
            }
            let form_data = new FormData(comment_form);
            ajax.send(form_data)
            return false;
        })
    </script>
@endsection

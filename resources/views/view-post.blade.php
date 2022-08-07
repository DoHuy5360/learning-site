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
                        <form action="{{ route('comment.store') }}" id="post-view-user-comment-field" method="POST">
                            @csrf
                            <input name="post_id" value="{{ $corresponding_post->post_id }}" type="hidden">
                            <textarea name="comment" id="postview-commnent-area" required></textarea>
                            <button id="post-view-submit-comment-btn" type="submit">Bình luận
                                <ion-icon name="paper-plane-outline"></ion-icon>
                            </button>
                        </form>
                        <iframe id="post-view-comment-frame" src="{{ 'http://127.0.0.1:8000/comment/' . $corresponding_post->post_id }}" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            let comment_btn = document.getElementById("post-view-submit-comment-btn")
            let comment_frame = document.getElementById('post-view-comment-frame')
            let comment_form = document.getElementById('post-view-user-comment-field')
            let commnent_area = document.getElementById('postview-commnent-area')
            comment_form.addEventListener('submit', e => {
                comment_btn.disabled = true;
                e.preventDefault();
                let ajax = new XMLHttpRequest();
                ajax.open("POST", comment_form.getAttribute("action"), true);
                ajax.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // let data = JSON.parse(this.responseText);
                        // alert(data.status + " - " + data.message)
                        commnent_area.value = ""
                        comment_btn.disabled = false
                    }
                    if (this.status == 500) {
                        // alert(this.responseText)
                        alert("Phát ngôn thất bại")
                    }
                }
                let form_data = new FormData(comment_form);
                ajax.send(form_data)
                comment_frame.contentWindow.location.reload()
                updateFrameHeight()
                return false;
            })

            function updateFrameHeight() {
                setTimeout(() => {
                    let get_content_height = comment_frame.contentWindow.document.getElementById('post-view-all-comment-list')
                    const content_height = get_content_height.offsetHeight + 100
                    comment_frame.style.height = `${content_height}px`
                }, 2000);
            }
            updateFrameHeight()
        }
    </script>
@endsection

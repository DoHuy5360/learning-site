@extends('layouts.header-footer-public')
@section('script')
    <script src="{{ asset('assets/js/post/view-post.js') }}"></script>
@endsection
@section('content')
    @if ($message = Session::get('success'))
        <div class="success-message">{{ $message }}</div>
    @endif
    @php
        $user = new UserData($corresponding_post->author_id);
        $user_info = $user->getUser();
        $post_content = new PostData($corresponding_post->post_id);
        $post_info = $post_content->getPost();
    @endphp
    <div class="full-height">
        <div id="post-view-body">
            <div id="post-view-content-wrap">
                <div id="post-view-side-bar-left">
                    <div id="post-view-side-bar-element">
                        <img id="post-view-hidden-avatar" src="{{ asset($user_info->avatar) }}" alt="" />
                        <div id="post-view-side-bar-left-star">
                            <span>238</span>
                            <ion-icon name="star-outline"></ion-icon>
                        </div>
                        @auth
                            <div class="postPs__bookmark--field">
                                <form class="postPs__bookmark--form" style="display: {{ $is_bookmarked ? 'block' : 'none' }};" data-explain-label="Nhấp chuột để lưu lại" method="POST">
                                    @csrf
                                    <input type="hidden" name="content_id" value="{{ $post_info->id }}">
                                    <input type="hidden" name="type" value="post">
                                    <button class="postPs__bookmark--btn" type="submit">
                                        <ion-icon name="bookmark-outline"></ion-icon>
                                    </button>
                                </form>
                                <form class="postPs__unbookmark--form" style="display: {{ !$is_bookmarked ? 'block' : 'none' }};" data-bookmark-id="{{ $post_info->id }}"
                                    data-explain-label="Nhấp chuột để bỏ lưu" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="postPs__unbookmark--btn" type="submit">
                                        <ion-icon name="bookmark"></ion-icon>
                                    </button>
                                </form>
                            </div>
                        @else
                            <ion-icon name="bookmark-outline"></ion-icon>
                        @endauth
                        <ion-icon name="link-outline"></ion-icon>
                        <ion-icon name="alert-circle-outline"></ion-icon>
                    </div>
                </div>
                <div id="post-view-content-left">
                    <div id="card-author-infomation">
                        <div id="post-view-author-avatar">
                            <img src="{{ asset($user_info->avatar) }}" alt="" />
                        </div>
                        <div id="post-view-author-info">
                            <div id="post-view-card-author-left-part">
                                <div id="post-view-author-left-header">
                                    <a href="">{{ $user_info->name }}</a>
                                    <p>{{ $user_info->email }}</p>
                                    @auth
                                        <form action="{{ route('follow.destroy', $user_info->id) }}" id="postVw-unfollow-form" style="display:{{ $is_following ? 'block' : 'none' }};" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button id="postVw-unfollow-btn" type="submit">Hủy theo dõi</button>
                                        </form>
                                        <form action="{{ route('follow.store') }}" id="postVw-follow-form" style="display:{{ !$is_following ? 'block' : 'none' }};" method="POST">
                                            @csrf
                                            <input type="hidden" name="followed" value="{{ $user_info->id }}">
                                            <button class="postVw__follow--btn" type="submit">Theo dõi</button>
                                        </form>
                                    @else
                                    <a href="{{ route('login') }}">
                                        <button class="postVw__follow--btn" type="button">Đăng nhập để theo dõi!</button>
                                    </a>
                                    @endauth
                                </div>
                                <div id="post-view-author-left-footer">
                                    <p class="post-view-user-index">
                                        <ion-icon name="star-outline"></ion-icon>
                                        <span>0</span>
                                    </p>
                                    <p class="post-view-user-index">
                                        <ion-icon name="person-add-outline"></ion-icon>
                                        <span>{{ $user->getFollower(size: true) }}</span>
                                    </p>
                                    <p class="post-view-user-index">
                                        <ion-icon name="paper-plane-outline"></ion-icon>
                                        <span>{{ $user->getPost(size: true) }}</span>
                                    </p>
                                </div>
                            </div>
                            <div id="post-view-card-author-right-part">
                                <div id="post-view-author-right-header">
                                    <div id="post-view-created-at">
                                        <span>{{ $post_info->created_at }}</span>
                                    </div>
                                    <span>-</span>
                                    <div id="post-view-time-to-read">
                                        <p>Mất {{ $post_info->time }} để đọc</p>
                                    </div>
                                </div>
                                <div id="post-view-author-right-footer">
                                    <p class="post-view-user-index">
                                        <ion-icon name="eye"></ion-icon>
                                        <span>0</span>
                                    </p>
                                    <p class="post-view-user-index">
                                        <ion-icon name="chatbubble"></ion-icon>
                                        <span>{{ $post_content->getComment(size: true) + $post_content->getReply(size: true) }}</span>
                                    </p>
                                    <p class="post-view-user-index">
                                        <ion-icon name="bookmark"></ion-icon>
                                        <span>{{ $post_content->getBookMark(size: true) }}</span>
                                    </p>
                                    <div id="postVw-option-setting">
                                        @auth
                                            <input id="postVw-setting-btn" type="checkbox" value="">
                                            <label for="postVw-setting-btn">
                                                <ion-icon name="ellipsis-horizontal-outline"></ion-icon>
                                                @if ($post_content->getAuthor()->id == Auth::user()->id)
                                                    <div id="setting-box">
                                                        <a href="{{ route('post.edit', $post_info->id) }}" class="postVw-option-btn">
                                                            <ion-icon name="create-outline"></ion-icon>
                                                            <span>Sửa bài viết</span>
                                                        </a>
                                                        <form action="{{ route('post.destroy', $post_info->id) }}" class="postVw-option-btn" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <ion-icon name="trash-outline"></ion-icon>
                                                            <button type="submit">Xóa bài viết</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            @endauth
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="post-view-main-content">
                        <h1>{{ $post_info->title }}</h1>
                        <div id="post-view-main-content-post">
                            {{ $post_info->content }}
                        </div>
                        <div id="post-view-main-content-footer">
                            @foreach ($post_content->getTag() as $tag)
                                <a class="post__card--tag" href="{{ route('tag.show', $tag->tag_id) }}">{{ $tag->name }}</a>
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
                            <div id="post-view-menu-element-list"></div>
                        </div>
                        @foreach ($series_posts as $series)
                            <div class="postView__series--field">
                                <div class="postview__menu--header">
                                    <p>{{ $series->name }}</p>
                                    <span></span>
                                </div>
                                <div class="postVw__relativePost--series">
                                    @foreach ($series->relative_posts as $post)
                                        <a class="postVw__series--otherpost" href="{{ route('post.show', remove_sign($post->title) . '|' . $post->post_id) }}">
                                            {{ $post->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
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
                <div id="post-view-relative-post-wrap">
                    <div class="postview__menu--header">
                        <p>Các bài viết khác của {{ $user_info->name }}</p>
                        <span></span>
                    </div>
                    <div id="post-view-author-orther-list">
                        @foreach ($relative_post as $post)
                            @php
                                $author = new UserData($corresponding_post->author_id);
                                $post_relative = new PostData($post->post_id);
                                $post_relative_infor = $post_relative->getPost();
                            @endphp
                            <div class="postview__card--postrelative">
                                <div class="postview__card--headerWrap">
                                    <div class="postview__card--postrelative-time-to-read">
                                        Đọc trong {{ $post_relative_infor->time }}
                                    </div>
                                    <a class="postview__card--postrelative-title" href="{{ url('/post') . '/' . remove_sign($post_relative_infor->title) . '|' . $post_relative_infor->id }}">
                                        {{ $post_relative_infor->title }}
                                    </a>
                                </div>
                                <div class="postview__card--postrelative-footer">
                                    <a href="" class="postview__card--postrelative-author-name">
                                        {{ $author->getUser()->name }}
                                    </a>
                                    <div class="postview__card--postrelative-author-index">
                                        <div>
                                            <ion-icon name="eye-outline"></ion-icon>
                                            <span>0</span>
                                        </div>
                                        <div>
                                            <ion-icon name="star-outline"></ion-icon>
                                            <span>0</span>
                                        </div>
                                        <div>
                                            <ion-icon name="bookmark-outline"></ion-icon>
                                            <span>{{ $post_relative->getBookMark(size: true) }}</span>
                                        </div>
                                        <div>
                                            <ion-icon name="chatbubbles-outline"></ion-icon>
                                            <span>{{ $post_relative->getComment(size: true) + $post_relative->getReply(size: true) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="post-view-comment-wrap">
                    <div class="postview__menu--header">
                        <p>Bình luận</p>
                        <span></span>
                    </div>
                    <div id="post-view-user-comment-field-wrap">
                        <form action="{{ route('post-comment.store') }}" id="post-view-user-comment-field" method="POST">
                            @csrf
                            <input name="post_id" value="{{ $post_info->id }}" type="hidden">
                            <textarea name="comment" id="postview-commnent-area" required></textarea>
                            <button id="post-view-submit-comment-btn" type="submit">
                                <span>Bình luận</span>
                                <ion-icon name="chatbubble-outline"></ion-icon>
                            </button>
                        </form>
                        <div id="postVw-comment-list" data-post-id="{{ $post_info->id }}"></div>
                        <div id="question-list-index-question">
                            <button id="question-previous-index" type="button">
                                <ion-icon name="chevron-back-outline"></ion-icon>
                            </button>
                            <div id="question-wrap-box-index">
                                @for ($wrap = 0; $wrap <= $relative_comment_length; $wrap += 10)
                                    <div class="index__questions--wrap">
                                        @for ($ascending = 1; $ascending < 11; $ascending++)
                                            @php
                                                $post_index = $wrap + $ascending;
                                            @endphp
                                            @if ($post_index <= $relative_comment_length + 1)
                                                <div class="index__questions" data-questions-index="{{ $post_index }}">
                                                    {{ $post_index }}
                                                </div>
                                            @endif
                                        @endfor
                                    </div>
                                @endfor
                            </div>
                            <button id="question-next-index" type="button">
                                <ion-icon name="chevron-forward-outline"></ion-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

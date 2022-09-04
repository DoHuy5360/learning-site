@extends('layouts.header-footer-public')
@section('script')
    <script src="{{ asset('assets/js/post/view-post.js') }}"></script>
@endsection
@section('content')
    @if ($message = Session::get('success'))
        <div class="success-message">{{ $message }}</div>
    @endif
    <div class="full-height">
        <div id="post-view-body">
            <div id="post-view-content-wrap">
                <div id="post-view-side-bar-left">
                    <div id="post-view-side-bar-element">
                        <img id="post-view-hidden-avatar" src="{{ $corresponding_post->avatar }}" alt="" />
                        <div id="post-view-side-bar-left-star">
                            <span>238</span>
                            <ion-icon name="star-outline"></ion-icon>
                        </div>
                        <div class="postPs__bookmark--field">
                            <form class="postPs__bookmark--form" style="display: {{ empty($is_bookmarked) ? 'block' : 'none' }};" data-explain-label="Nhấp chuột để lưu lại" method="POST">
                                @csrf
                                <input type="hidden" name="content_id" value="{{ $corresponding_post->post_id }}">
                                <input type="hidden" name="type" value="post">
                                <button class="postPs__bookmark--btn" type="submit">
                                    <ion-icon name="bookmark-outline"></ion-icon>
                                </button>
                            </form>
                            <form class="postPs__unbookmark--form" style="display: {{ !empty($is_bookmarked) ? 'block' : 'none' }};" data-bookmark-id="{{ $corresponding_post->post_id }}"
                                data-explain-label="Nhấp chuột để bỏ lưu" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="postPs__unbookmark--btn" type="submit">
                                    <ion-icon name="bookmark"></ion-icon>
                                </button>
                            </form>
                        </div>
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
                                    <form action="{{ route('follow.destroy', $corresponding_post->author_id) }}" id="postVw-unfollow-form" style="display:{{ $is_following ? 'block' : 'none' }};"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button id="postVw-unfollow-btn" type="submit">Hủy theo dõi</button>
                                    </form>
                                    <form action="{{ route('follow.store') }}" id="postVw-follow-form" style="display:{{ !$is_following ? 'block' : 'none' }};" method="POST">
                                        @csrf
                                        <input type="hidden" name="followed" value="{{ $corresponding_post->author_id }}">
                                        <button id="postVw-follow-btn" type="submit">Theo dõi</button>
                                    </form>
                                </div>
                                <div id="post-view-author-left-footer">
                                    <p class="post-view-user-index">
                                        <ion-icon name="star-outline"></ion-icon>
                                        <span>0</span>
                                    </p>
                                    <p class="post-view-user-index">
                                        <ion-icon name="person-add-outline"></ion-icon>
                                        <x-post.index :post-id="$corresponding_post->post_id" type="follower"/>
                                    </p>
                                    <p class="post-view-user-index">
                                        <ion-icon name="paper-plane-outline"></ion-icon>
                                        <x-post.index :post-id="$corresponding_post->post_id" type="post"/>
                                    </p>
                                </div>
                            </div>
                            <div id="post-view-card-author-right-part">
                                <div id="post-view-author-right-header">
                                    <div id="post-view-created-at">
                                        <x-post.index :post-id="$corresponding_post->post_id" type="created_at"/>
                                    </div>
                                    <span>-</span>
                                    <div id="post-view-time-to-read">
                                        <p>
                                        Mất <x-post.index :post-id="$corresponding_post->post_id" type="reading_time"/> để đọc
                                        </p>
                                    </div>
                                </div>
                                <div id="post-view-author-right-footer">
                                    <p class="post-view-user-index">
                                        <ion-icon name="eye"></ion-icon>
                                        <span>0</span>
                                    </p>
                                    <p class="post-view-user-index">
                                        <ion-icon name="chatbubble"></ion-icon>
                                        <x-post.index :post-id="$corresponding_post->post_id" type="comment"/>
                                    </p>
                                    <p class="post-view-user-index">
                                        <ion-icon name="bookmark"></ion-icon>
                                        <x-post.index :post-id="$corresponding_post->post_id" type="bookmark"/>
                                    </p>
                                    <div id="postVw-option-setting">
                                        <input id="postVw-setting-btn" type="checkbox" value="">
                                        <label for="postVw-setting-btn">
                                            <ion-icon name="ellipsis-horizontal-outline"></ion-icon>
                                            @if ($is_author)
                                                <div id="setting-box">
                                                    <a href="{{ route('post.edit', $corresponding_post->id) }}" class="postVw-option-btn">
                                                        <ion-icon name="create-outline"></ion-icon>
                                                        <span>Sửa bài viết</span>
                                                    </a>
                                                    <form action="{{ route('post.destroy', $corresponding_post->id) }}" class="postVw-option-btn" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <ion-icon name="trash-outline"></ion-icon>
                                                        <button type="submit">Xóa bài viết</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="post-view-main-content">
                        <h1>{{ $corresponding_post->title }}</h1>
                        <div id="post-view-main-content-post">
                            {{ $corresponding_post->content }}
                        </div>
                        <div id="post-view-main-content-footer">
                            @foreach ($relative_tag as $tag)
                                <a class="post__card--tag" href="{{ route('tag.show', $tag->id) }}">{{ $tag->name }}</a>
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
                        <p>Các bài viết khác của {{ $corresponding_post->name }}</p>
                        <span></span>
                    </div>
                    <div id="post-view-author-orther-list">
                        @foreach ($relative_post as $post)
                            <div class="postview__card--postrelative">
                                <div class="postview__card--headerWrap">
                                    <div class="postview__card--postrelative-time-to-read">
                                        Đọc trong {{ $post->time }}
                                    </div>
                                    <a class="postview__card--postrelative-title" href="{{ url('/post') . '/' . remove_sign($post->title) . '|' . $post->id }}">
                                        {{ $post->title }}
                                    </a>
                                </div>
                                <div class="postview__card--postrelative-footer">
                                    <a href="" class="postview__card--postrelative-author-name">
                                        {{ $corresponding_post->name }}
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
                                            <x-post.index :post-id="$post->post_id" type="bookmark"/>
                                        </div>
                                        <div>
                                            <ion-icon name="chatbubbles-outline"></ion-icon>
                                            <x-post.index :post-id="$post->post_id" type="comment"/>
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
                            <input name="post_id" value="{{ $corresponding_post->post_id }}" type="hidden">
                            <textarea name="comment" id="postview-commnent-area" required></textarea>
                            <button id="post-view-submit-comment-btn" type="submit">
                                <span>Bình luận</span>
                                <ion-icon name="chatbubble-outline"></ion-icon>
                            </button>
                        </form>
                        <div id="postVw-comment-list" data-post-id="{{ $corresponding_post->post_id }}"></div>
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

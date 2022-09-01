@extends('layouts.header-footer-public')
@section('script')
    <script src="{{ asset('assets/js/post/post.js') }}"></script>
@endsection
@section('content')
    <h1 id="welcome">Chào mừng đến với Learning Site</h1>
    @if ($message = Session::get('success'))
        <div class="success-message">{{ $message }}</div>
    @endif
    <div id="site-body">
        <div id="body-part-left">
            <h2 class="body__link--wrap">
                <a href="" class="body__link--redirect">Các bài viết mới nhất</a>
                <span></span>
            </h2>
            <div id="body-content-left">
                <!-- posts -->
                <div class="body__post--wrap">
                    @foreach ($all_posts as $post)
                        <div class="post__card--wrap">
                            <div class="post__card--useravatar">
                                <img src="{{ $post->avatar }}" alt="" />
                            </div>
                            <div class="post__card--wrapcontent">
                                <div class="post__card--header">
                                    <a href="" class="post__card--username"> {{ $post->name }} </a>
                                    <div class="post__created--time">{{ $post->created_at }}</div>
                                    <div class="post-reading-time"><span>Đọc trong </span>{{ $post->time }}</div>
                                    <ion-icon name="link-outline"></ion-icon>
                                    @if ($is_login)
                                        <div class="postPs__bookmark--field">
                                            <form class="postPs__bookmark--form" style="display: {{ empty($post->bookmarked) ? 'block' : 'none' }};" data-explain-label="Nhấp chuột để lưu lại" method="POST">
                                                @csrf
                                                <input type="hidden" name="content_id" value="{{ $post->post_id }}">
                                                <input type="hidden" name="type" value="post">
                                                <button class="postPs__bookmark--btn" type="submit">
                                                    <ion-icon name="bookmark-outline"></ion-icon>
                                                </button>
                                            </form>
                                            <form class="postPs__unbookmark--form" style="display: {{ !empty($post->bookmarked) ? 'block' : 'none' }};"
                                                data-bookmark-id="{{ $post->post_id }}" data-explain-label="Nhấp chuột để bỏ lưu" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="postPs__unbookmark--btn" type="submit">
                                                    <ion-icon name="bookmark"></ion-icon>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                                <div class="post__card--body">
                                    <h2 class="post__card--title">
                                        <a href="{{ route('post.show', remove_sign($post->title) . '|' . $post->post_id) }}">{{ $post->title }}</a>
                                    </h2>
                                </div>
                                <div class="post__card--footer">
                                    @foreach ($post->tags as $tag)
                                        <a href="{{ route('tag.show', $tag->id) }}" class="post__card--tag">{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div id="body-part-right">
            <div id="body-content-right">
                <h2 class="body__link--wrap">
                    <a href="{{ route('question.index') }}" class="body__link--redirect">Các câu hỏi mới nhất</a>
                    <span></span>
                </h2>
                <div class="body__question--wrap">
                    @foreach ($all_questions as $question)
                        <div class="question__card--wrap">
                            <div class="question__card--header">
                                <h2 class="question__card--title">
                                    <a href="{{ url('/question') . '/' . $question->question_id }}">{{ $question->title }}</a>
                                </h2>
                            </div>
                            <div class="question__card--body">
                                <div class="question__index question__card--helpful">
                                    <ion-icon name="star-outline"></ion-icon>
                                    <span>0</span>
                                </div>
                                <div class="question__index question__card--answer">
                                    <ion-icon name="hand-right-outline"></ion-icon>
                                    <span>0</span>
                                </div>
                                <div class="question__index question__card--comment">
                                    <ion-icon name="chatbubbles-outline"></ion-icon>
                                    <span>0</span>
                                </div>
                                <div class="question__index question__card--view">
                                    <ion-icon name="eye-outline"></ion-icon>
                                    <span>0</span>
                                </div>
                            </div>
                            <div class="question__card--footer">
                                <a href="" class="question__card--username"> {{ $question->name }} </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

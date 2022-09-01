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
                <div id="post-list-wrap" class="body__post--wrap">
                    <!-- posts -->
                </div>
                <div id="question-list-index-question">
                    <button id="question-previous-index" type="button">
                        <ion-icon name="chevron-back-outline"></ion-icon>
                    </button>
                    <div id="question-wrap-box-index">
                        @for ($wrap = 0; $wrap < $all_posts_length; $wrap += 10)
                            <div class="index__questions--wrap">
                                @for ($ascending = 1; $ascending < 11; $ascending++)
                                    @php
                                        $post_index = $wrap + $ascending;
                                    @endphp
                                    @if ($post_index <= $all_posts_length + 1)
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

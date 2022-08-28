@extends('layouts.header-footer-public')
@section('script')
    <script src="{{ asset('assets/js/ajax.js') }}"></script>
    <script src="{{ asset('assets/js/question/question.js') }}"></script>
@endsection
@section('content')
    <div id="question-site-body">
        <div id="question-view-menu">
            <div id="question-menu-width">
                <div id="option-view">
                    <a href="" class="menu__option--link"> Mới Nhất </a>
                    <a href="" class="menu__option--link"> Đã Giải Đáp </a>
                    <a href="" class="menu__option--link"> Chưa Giải Đáp </a>
                    <a href="" class="menu__option--link"> Lưu Trữ </a>
                </div>
                <div id="create-question">
                    <a href="{{ route('question.create') }}" class="menu__option--link">Đặt Câu Hỏi</a>
                </div>
            </div>
        </div>
        <div id="question-body-width">
            <div id="content-body-wrap">
                <div id="body-left-part-question">
                    <div id="question-wrap-question">
                        <div id="question-list-wrap">
                            {{-- questions --}}
                        </div>
                    </div>
                    <div id="question-list-index-question">
                        <button id="question-previous-index">
                            <ion-icon name="chevron-back-outline"></ion-icon>
                        </button>
                        <div id="question-wrap-box-index">
                            @for ($wrap = 0; $wrap < $all_questions_length; $wrap += 5)
                                <div class="index__questions--wrap">
                                    @for ($index = 1; $index < 6; $index++)
                                        {{-- <input class="index__questions" value="{{ $wrap + $index }}" data-questions-index="{{ $wrap + $index }}" type="button" /> --}}
                                        <div class="index__questions" data-questions-index="{{ $wrap + $index }}">
                                            {{ $wrap + $index }}
                                        </div>
                                    @endfor
                                </div>
                            @endfor
                        </div>
                        <button id="question-next-index">
                            <ion-icon name="chevron-forward-outline"></ion-icon>
                        </button>
                    </div>
                </div>
                <div id="body-right-part-question">
                    <div id="make-fixed-position">
                        <p id="redirect-post-link">
                            <a href=""> Các bài viết liên quan </a>
                            <span></span>
                        </p>
                        <div id="question-rightpart-list-relativepost">
                            {{-- @foreach ($relative_posts as $post)
                                <div class="postrelative__card--wrap">
                                    <div class="relative__post--header">
                                        <p>
                                            <a href="">{{ $post->title }}</a>
                                        </p>
                                    </div>
                                    <div class="relative__post--body">
                                        <div class="relative__post--index">
                                            <ion-icon name="star-outline"></ion-icon>
                                            <span>0</span>
                                        </div>
                                        <div class="relative__post--index">
                                            <ion-icon name="chatbubbles-outline"></ion-icon>
                                            <span>0</span>
                                        </div>
                                        <div class="relative__post--index">
                                            <ion-icon name="bookmark-outline"></ion-icon>
                                            <span>0</span>
                                        </div>
                                        <div class="relative__post--index">
                                            <ion-icon name="eye-outline"></ion-icon>
                                            <span>0</span>
                                        </div>
                                    </div>
                                    <div class="relative__post--footer">
                                        <p class="relative__post--authorname">
                                            <a href="">{{ $post->name }}</a>
                                        </p>
                                    </div>
                                </div>
                            @endforeach --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.header-footer-public')
@section('script')
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
                        <button id="question-previous-index" type="button">
                            <ion-icon name="chevron-back-outline"></ion-icon>
                        </button>
                        <div id="question-wrap-box-index">
                            @for ($wrap = 0; $wrap <= $all_questions_length; $wrap += 10)
                                <div class="index__questions--wrap">
                                    @for ($ascending = 1; $ascending < 11; $ascending++)
                                        @php
                                            $question_index = $wrap + $ascending;
                                        @endphp
                                        @if ($question_index <= $all_questions_length + 1)
                                            <div class="index__questions" data-questions-index="{{ $question_index }}">
                                                {{ $question_index }}
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
                <div id="body-right-part-question">
                    <div id="make-fixed-position">
                        <p id="redirect-post-link">
                            <a href=""> Các bài viết liên quan </a>
                            <span></span>
                        </p>
                        <div id="question-rightpart-list-relativepost">
                            {{-- relative post --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

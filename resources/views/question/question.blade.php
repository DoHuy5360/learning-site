@extends('layouts.header-footer-public')
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
                    <div id="question-list-wrap">
                        @foreach ($all_questions as $question)
                            <div class="card__question--wrap">
                                <div class="card__question--leftpart">
                                    <div class="cardquestion__leftpart--header">
                                        <ion-icon name="time-outline"></ion-icon>
                                        <p>{{ $question->created_at }}</p>
                                    </div>
                                    <div class="cardquestion__leftpart--footer">
                                        <div class="cardquestion__leftpart--index">
                                            <ion-icon name="hand-left-outline"></ion-icon>
                                            <span>0</span>
                                        </div>
                                        <div class="cardquestion__leftpart--index">
                                            <ion-icon name="star-outline"></ion-icon>
                                            <span>0</span>
                                        </div>
                                        <div class="cardquestion__leftpart--index">
                                            <ion-icon name="chatbubbles-outline"></ion-icon>
                                            <span>0</span>
                                        </div>
                                        <div class="cardquestion__leftpart--index">
                                            <ion-icon name="eye-outline"></ion-icon>
                                            <span>0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card__question--rightpart">
                                    <div class="cardquestion__rightpart--header">
                                        <div class="cardquestion__author--avatar">
                                            <img src="{{ $question->avatar }}" alt="" />
                                        </div>
                                        <div class="cardquestion__author--name">
                                            <a href="">{{ $question->name }}</a>
                                        </div>
                                        <ion-icon name="arrow-undo-outline"></ion-icon>
                                        <div class="cardquestion__list--helper">
                                            <img src="./assets/avatar.png" alt="" />
                                        </div>
                                    </div>
                                    <div class="cardquestion__rightpart--body">
                                        <a href="{{ url('/question') . '/' . $question->question_id }}">{{ $question->title }}</a>
                                    </div>
                                    <div class="cardquestion__rightpart--footer">
                                        <div class="cardquestion__list-tag">
                                            <a href="">HTML</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="body-right-part-question">
                    <div id="make-fixed-position">
                        <p id="redirect-post-link">
                            <a href=""> Các bài viết liên quan </a>
                            <span></span>
                        </p>
                        <div id="question-rightpart-list-relativepost">
                            <div class="postrelative__card--wrap">
                                <div class="relative__post--header">
                                    <p>
                                        <a href="">Cach lua ga trong the ky 21</a>
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
                                        <a href="">Do Huy</a>
                                    </p>
                                </div>
                            </div>
                            <div class="postrelative__card--wrap">
                                <div class="relative__post--header">
                                    <p>
                                        <a href="">Cach lua ga trong the ky 21</a>
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
                                        <a href="">Do Huy</a>
                                    </p>
                                </div>
                            </div>
                            <div class="postrelative__card--wrap">
                                <div class="relative__post--header">
                                    <p>
                                        <a href="">Cach lua ga trong the ky 21</a>
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
                                        <a href="">Do Huy</a>
                                    </p>
                                </div>
                            </div>
                            <div class="postrelative__card--wrap">
                                <div class="relative__post--header">
                                    <p>
                                        <a href="">Cach lua ga trong the ky 21</a>
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
                                        <a href="">Do Huy</a>
                                    </p>
                                </div>
                            </div>
                            <div class="postrelative__card--wrap">
                                <div class="relative__post--header">
                                    <p>
                                        <a href="">Cach lua ga trong the ky 21</a>
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
                                        <a href="">Do Huy</a>
                                    </p>
                                </div>
                            </div>
                            <div class="postrelative__card--wrap">
                                <div class="relative__post--header">
                                    <p>
                                        <a href="">Cach lua ga trong the ky 21</a>
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
                                        <a href="">Do Huy</a>
                                    </p>
                                </div>
                            </div>
                            <div class="postrelative__card--wrap">
                                <div class="relative__post--header">
                                    <p>
                                        <a href="">Cach lua ga trong the ky 21</a>
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
                                        <a href="">Do Huy</a>
                                    </p>
                                </div>
                            </div>
                            <div class="postrelative__card--wrap">
                                <div class="relative__post--header">
                                    <p>
                                        <a href="">Cach lua ga trong the ky 21</a>
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
                                        <a href="">Do Huy</a>
                                    </p>
                                </div>
                            </div>
                            <div class="postrelative__card--wrap">
                                <div class="relative__post--header">
                                    <p>
                                        <a href="">Cach lua ga trong the ky 21</a>
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
                                        <a href="">Do Huy</a>
                                    </p>
                                </div>
                            </div>
                            <div class="postrelative__card--wrap">
                                <div class="relative__post--header">
                                    <p>
                                        <a href="">Cach lua ga trong the ky 21</a>
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
                                        <a href="">Do Huy</a>
                                    </p>
                                </div>
                            </div>
                            <div class="postrelative__card--wrap">
                                <div class="relative__post--header">
                                    <p>
                                        <a href="">Cach lua ga trong the ky 21</a>
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
                                        <a href="">Do Huy</a>
                                    </p>
                                </div>
                            </div>
                            <div class="postrelative__card--wrap">
                                <div class="relative__post--header">
                                    <p>
                                        <a href="">Cach lua ga trong the ky 21</a>
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
                                        <a href="">Do Huy</a>
                                    </p>
                                </div>
                            </div>
                            <div class="postrelative__card--wrap">
                                <div class="relative__post--header">
                                    <p>
                                        <a href="">Cach lua ga trong the ky 21</a>
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
                                        <a href="">Do Huy</a>
                                    </p>
                                </div>
                            </div>
                            <div class="postrelative__card--wrap">
                                <div class="relative__post--header">
                                    <p>
                                        <a href="">Cach lua ga trong the ky 21</a>
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
                                        <a href="">Do Huy</a>
                                    </p>
                                </div>
                            </div>
                            <div class="postrelative__card--wrap">
                                <div class="relative__post--header">
                                    <p>
                                        <a href="">Cach lua ga trong the ky 21</a>
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
                                        <a href="">Do Huy</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

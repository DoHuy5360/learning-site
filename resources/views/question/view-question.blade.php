@extends('layouts.header-footer-public')
@section('script')
    <script src="{{ asset('assets/js/question/view-question.js') }}"></script>
@endsection
@section('content')
    @if ($message = Session::get('success'))
        <div class="success-message">{{ $message }}</div>
    @endif
    <div class="full-height">
        <div id="quesVw-contents-body-wr">
            <div id="quesVw-question-top-wr">
                <div id="quesVw-interact-left-wr">
                    <div id="quesVw-what-top" class="interact__icon">
                        <ion-icon name="help-outline"></ion-icon>
                    </div>
                    <div id="quesVw-help-bottom" class="interact__icon">
                        <ion-icon name="alert-circle-outline"></ion-icon>
                    </div>
                </div>
                <div id="quesVw-ques_info-right-wr">
                    <div id="quesVw-ques_ques_field-top-wr">
                        <div id="quesVw-ques_text-left-wr">
                            <div id="quesVw-ques_index-lv1-wr">
                                <div class="group__index">
                                    <ion-icon name="time-outline"></ion-icon>
                                    <span> {{ $corresponding_question->created_at }} </span>
                                </div>
                                <div class="group__index">
                                    <ion-icon name="eye-outline"></ion-icon>
                                    <span>23493</span>
                                </div>
                                <div class="group__index">
                                    <ion-icon name="bookmark-outline"></ion-icon>
                                    <span>9834</span>
                                </div>
                                <div class="group__index">
                                    <ion-icon name="chatbox-outline"></ion-icon>
                                    <span>935</span>
                                </div>
                            </div>
                            <div id="quesVw-ques_title-lv2-wr">
                                <h1>{{ $corresponding_question->title }}</h1>
                            </div>
                            <div id="quesVw-ques_tag-lv3-ls">
                                @foreach ($relative_tags as $tag)
                                    <a href="{{ route('tag.show', $tag->id) }}" class="underline__none">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                            <div id="quesVw-ques_question-lv4-wr">
                                {{ $corresponding_question->content }}
                            </div>
                            <div id="quesVw-ques_answer-lv5-wr">
                                <button id="quesVw-open_answer-btn" type="button">
                                    <span>Trả Lời</span>
                                    <ion-icon name="chatbubble-outline"></ion-icon>
                                </button>
                            </div>
                        </div>
                        <div class="quesVw-ans_author-right-wr">
                            <div id="quesVw-aut_info-lv1-wr">
                                <img src="{{ $corresponding_question->avatar }}" alt="" />
                                <div id="quesVw-auth_info-right-wr">
                                    <a href="" id="quesVw-aut_name-top" class="underline__none">{{ $corresponding_question->name }}</a>
                                    <span id="quesVw-aut_email-bottom">{{ $corresponding_question->email }}</span>
                                </div>
                            </div>
                            <div class="author__interact--wr">
                                <div class="author__infor--wr">
                                    <div class="group__index">
                                        <ion-icon name="star-outline"></ion-icon>
                                        <span>453</span>
                                    </div>
                                    <div class="group__index">
                                        <ion-icon name="person-add-outline"></ion-icon>
                                        <span>453</span>
                                    </div>
                                    <div class="group__index">
                                        <ion-icon name="help-outline"></ion-icon>
                                        <span>453</span>
                                    </div>
                                    <div class="group__index">
                                        <ion-icon name="paper-plane-outline"></ion-icon>
                                        <span>453</span>
                                    </div>
                                </div>
                                @auth
                                    <form action="{{ route('follow.destroy', $corresponding_question->user_id) }}" id="postVw-unfollow-form" style="display:{{ $is_following ? 'block' : 'none' }};" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button id="postVw-unfollow-btn" type="submit">Hủy theo dõi</button>
                                    </form>
                                    <form action="{{ route('follow.store') }}" id="postVw-follow-form" style="display:{{ !$is_following ? 'block' : 'none' }};" method="POST">
                                        @csrf
                                        <input type="hidden" name="followed" value="{{ $corresponding_question->user_id }}">
                                        <button class="postVw__follow--btn" type="submit">Theo dõi</button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}">
                                        <button class="postVw__follow--btn" type="button">Theo dõi</button>
                                    </a>
                                @endauth
                            </div>
                            <div id="quesVw-aut_bookquesVw-chat_form-wrM-lv3-wr">
                                <form action="" id="quesVw-ques_bookmark-form" method="post">
                                    <ion-icon name="bookmark-outline"></ion-icon>
                                    <button type="submit">Lưu Trữ Câu Hỏi Này</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="quesVw-comment_field-bellow-wr">
                        <button id="quesVw-open_comment-btn" type="button">Bình luận cho câu hỏi này ...</button>
                    </div>
                    <div id="quesVw-send_text-bottom-wr">
                        <form action="" id="quesVw-answer_form-wr" method="post">
                            @csrf
                            <input id="quesVw-question_id" type="hidden" name="question_id" value="{{ $question_id }}">
                            <input type="hidden" name="reply_for" value="{{ $corresponding_question->question_code }}">
                            <textarea name="content" id="quesVw-answer_field-write" cols="30" rows="10" placeholder="Bạn đang tạo câu trả lời!"></textarea>
                            <div id="quesVw-option_form-btn-wrap">
                                <button id="quesVw-btn-close-form" type="button">Close</button>
                                <button class="quesVw-btn-send-form" type="submit">Send</button>
                            </div>
                        </form>
                        <form action="" id="quesVw-comment_form-wr" method="post">
                            @csrf
                            <input id="quesVw-question_id" type="hidden" name="question_id" value="{{ $question_id }}">
                            <input type="hidden" name="reply_for" value="{{ $corresponding_question->question_code }}">
                            <textarea name="content" id="quesVw-comment_field-write" cols="30" rows="10" placeholder="Bạn đang tạo bình luận!"></textarea>
                            <div id="quesVw-option_form-btn-wrap">
                                <button id="quesVw-btn-close-form" type="button">Close</button>
                                <button class="quesVw-btn-send-form" type="submit">Send</button>
                            </div>
                        </form>
                    </div>
                    <div id="quesVw-reply-list" data-answer-code="{{ $corresponding_question->question_code }}"></div>
                </div>
            </div>
            <!-- todo answer start -->
            <div class="quesVw-answer-bellow-wr">
                <div id="quesVw-ans_info-right-wr">
                    @foreach ($all_answers as $answer)
                        <div class="quesVw-ans_ans_field-top-wr">
                            <div class="quesVw-ans_wrap-top-wr" data-answer-code="{{ $answer->answer_code }}">
                                <div class="quesVw-ans_element-top-wr">
                                    <div class="quesVw-ans_text-left-wr">
                                        <div class="quesVw-ans_index-lv1-wr">
                                            <div class="group__index">
                                                <ion-icon name="time-outline"></ion-icon>
                                                <span>{{ $answer->created_at }}</span>
                                            </div>
                                        </div>
                                        <div id="quesVw-ques_question-lv4-wr">
                                            <p>{{ $answer->content }}</p>
                                        </div>
                                        <div class="quesVw-answer_comment_field-bellow-wr">
                                            <button class="quesVw-answer_comment-btn" type="button">Bình luận cho câu trả lời này ...</button>
                                        </div>
                                    </div>
                                    <div id="quesVw-ques_author-right-wr">
                                        <div id="quesVw-aut_info-lv1-wr">
                                            <img src="{{ $answer->avatar }}" alt="" />
                                            <div id="quesVw-auth_info-right-wr">
                                                <a href="" id="quesVw-aut_name-top" class="underline__none">{{ $answer->name }}</a>
                                                <span id="quesVw-aut_email-bottom">{{ $answer->email }}</span>
                                            </div>
                                        </div>
                                        <div class="author__interact--wr">
                                            <div class="author__infor--wr">
                                                <div class="group__index">
                                                    <ion-icon name="star-outline"></ion-icon>
                                                    <span>453</span>
                                                </div>
                                                <div class="group__index">
                                                    <ion-icon name="person-add-outline"></ion-icon>
                                                    <span>453</span>
                                                </div>
                                                <div class="group__index">
                                                    <ion-icon name="help-outline"></ion-icon>
                                                    <span>453</span>
                                                </div>
                                                <div class="group__index">
                                                    <ion-icon name="paper-plane-outline"></ion-icon>
                                                    <span>453</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        let create_comment_btn = document.getElementById('quesVw-open_comment-btn')
        let create_answer_btn = document.getElementById('quesVw-open_answer-btn')
        let close_form_btn = document.getElementById('quesVw-btn-close-form')

        let answer_form = document.getElementById('quesVw-answer_form-wr')
        let comment_form = document.getElementById('quesVw-comment_form-wr')

        create_comment_btn.addEventListener('click', e => {
            comment_form.classList.add('chat_active')
            answer_form.classList.remove('chat_active')
        })
        create_answer_btn.addEventListener('click', e => {
            answer_form.classList.add('chat_active')
            comment_form.classList.remove('chat_active')
        })
        close_form_btn.addEventListener('click', e => {
            answer_form.classList.remove('chat_active')
            comment_form.classList.remove('chat_active')
        })
    </script>
@endsection

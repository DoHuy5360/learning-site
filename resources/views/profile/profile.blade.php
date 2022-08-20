@extends('layouts.header-footer-create')
@section('content')
    <div id="profile-wrap-all">
        <div id="profile-header-wrap">
            <div class="align-width">
                <div id="profile-avatar-name-edit-wrap">
                    <img src="{{ $user_informations->avatar }}" alt="" />
                    <div id="profile-name-edit-wrap">
                        <span>{{ $user_informations->name }}</span>
                        <a href="">Edit</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="profile-menu-wrap">
            <div class="align-width">
                <div id="profile-list-option">
                    <a href="#profile-post-table" class="profile-option">Bai Viet</a>
                    <a href="#profile-series-table" class="profile-option">Series</a>
                    <a href="#profile-question-table" class="profile-option">Cau Hoi</a>
                    <a href="#profile-answer-table" class="profile-option">Cau Tra Loi</a>
                    <a href="#profile-bookmark-table" class="profile-option">Bookmark</a>
                    <a href="#profile-following-table" class="profile-option">Dang Theo Doi</a>
                    <a href="#profile-follower-table" class="profile-option">Nguoi Theo Doi</a>
                    <a href="#profile-tag-table" class="profile-option">The</a>
                    <a href="#profile-reputaion-table" class="profile-option">Reputations</a>
                    <a href="#aprofile-contact-table" class="profile-option">Lien He</a>
                </div>
            </div>
        </div>
        <div class="align-width">
            <div id="profile-display-index-wrap">
                <div id="profile-display-left">
                    <div id="profile-post-table" class="profile__table--display">
                        @foreach ($user_posts as $post)
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
                                        <ion-icon name="bookmark-outline"></ion-icon>
                                    </div>
                                    <div class="post__card--body">
                                        <h2 class="post__card--title">
                                            @php
                                                $convert_slug = remove_sign($post->title);
                                            @endphp
                                            <a href="{{ url("/post/{$convert_slug}|{$post->id}") }}">{{ $post->title }}</a>
                                        </h2>
                                    </div>
                                    <div class="post__card--footer">
                                        @foreach ($post->tags[0] as $tag_key => $tag_value)
                                            @if ($tag_value != 'null')
                                                <a href="" class="post__card--tag">{{ $tag_value }}</a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="profile-series-table" class="profile__table--display">
                        @foreach ($user_series as $series)
                            <p>{{ $series->name }}</p>
                        @endforeach
                    </div>
                    <div id="profile-question-table" class="profile__table--display">
                        @foreach ($user_questions as $question)
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
                    <div id="profile-answer-table" class="profile__table--display">
                        @foreach ($user_answers as $answer)
                            <div class="quesVw-ans_ans_field-top-wr">
                                <div class="quesVw-ans_wrap-top-wr" data-answer-code="{{ $answer->answer_code }}">
                                    <div class="quesVw-ans_element-top-wr">
                                        <div class="question__title--injection">
                                            <h4>Câu Hỏi:</h4>
                                            <a href="{{ url('/question') . '/' . $answer->question_id }}" class="underline__none">{{ $answer->title }}</a>
                                        </div>
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
                                            {{-- <div class="quesVw-answer_comment_field-bellow-wr">
                                            <button class="quesVw-answer_comment-btn" type="button">Bình luận cho câu trả lời này ...</button>
                                        </div> --}}
                                        </div>
                                        {{-- <div id="quesVw-ques_author-right-wr">
                                        <div id="quesVw-aut_info-lv1-wr">
                                            <img src="{{ $user_informations->avatar }}" alt="" />
                                            <div id="quesVw-auth_info-right-wr">
                                                <a href="" id="quesVw-aut_name-top" class="underline__none">{{ $user_informations->name }}</a>
                                                <span id="quesVw-aut_email-bottom">{{ $user_informations->email }}</span>
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
                                            <form action="" id="quesVw-aut_follow-form" method="post">
                                                <button type="submit">Theo Dõi</button>
                                            </form>
                                        </div>
                                    </div> --}}
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                    <div id="profile-bookmark-table" class="profile__table--display">#a5</div>
                    <div id="profile-following-table" class="profile__table--display">#a6</div>
                    <div id="profile-follower-table" class="profile__table--display">#a7</div>
                    <div id="profile-tag-table" class="profile__table--display">
                        @foreach ($array_tags as $tag)
                            <p>
                                <a href="" class="underline__none">{{ $tag }}</a>
                            </p>
                            @endforeach
                    </div>
                    <div id="profile-reputaion-table" class="profile__table--display">#a9</div>
                    <div id="aprofile-contact-table" class="profile__table--display">#a10</div>
                </div>
                <div id="profile-display-right">
                    <div id="profile-index-table">
                        <div class="profile__index--row">
                            <div class="profile__index--name">
                                Tổng số lượt xem bài viết
                            </div>
                            <div class="profile__index--index">1443</div>
                        </div>
                        <div class="profile__index--row">
                            <div class="profile__index--name">
                                Reputations
                            </div>
                            <div class="profile__index--index">34</div>
                        </div>
                        <div class="profile__index--row">
                            <div class="profile__index--name">
                                Các thẻ theo dõi
                            </div>
                            <div class="profile__index--index">1431</div>
                        </div>
                        <div class="profile__index--row">
                            <div class="profile__index--name">
                                Đang theo dõi các người dùng
                            </div>
                            <div class="profile__index--index">13</div>
                        </div>
                        <div class="profile__index--row">
                            <div class="profile__index--name">
                                Các người dùng đang theo dõi
                            </div>
                            <div class="profile__index--index">1414</div>
                        </div>
                        <div class="profile__index--row">
                            <div class="profile__index--name">Bài viết</div>
                            <div class="profile__index--index">14843</div>
                        </div>
                        <div class="profile__index--row">
                            <div class="profile__index--name">Bookmark</div>
                            <div class="profile__index--index">43</div>
                        </div>
                        <div class="profile__index--row">
                            <div class="profile__index--name">
                                Tổng số câu hỏi
                            </div>
                            <div class="profile__index--index">14393</div>
                        </div>
                        <div class="profile__index--row">
                            <div class="profile__index--name">
                                Tổng số câu trả lời
                            </div>
                            <div class="profile__index--index">1493749</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

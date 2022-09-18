@extends('layouts.header-footer-create')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/tag/tag.css') }}">
@endsection
@section('script')
    <script src="{{ asset('assets/js/profile/view-profile.js') }}"></script>
@endsection
@section('content')
    <div id="profile-wrap-all">
        <div id="profile-header-wrap">
            <div class="align-width">
                <div id="profile-avatar-name-edit-wrap">
                    <img src="{{ asset($user_informations->avatar) }}" alt="" />
                    <div id="profile-name-edit-wrap">
                        <span>{{ $user_informations->name }}</span>
                        @auth
                            @if ($user_informations->user_id == Auth::user()->id)
                                <a href="{{ route('profile.edit', $user_informations->user_id) }}">Edit</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <div id="profile-menu-wrap">
            <div class="align-width">
                <div id="profile-list-option">
                    <a href="#profile-post-table" class="profile-option">Bài viết</a>
                    <a href="#profile-series-table" class="profile-option">Chuỗi bài viết</a>
                    <a href="#profile-question-table" class="profile-option">Câu hỏi</a>
                    <a href="#profile-answer-table" class="profile-option">Câu trả lời</a>
                    <a href="#profile-bookmark-table" class="profile-option">Đánh dấu</a>
                    <a href="#profile-following-table" class="profile-option">Đang theo dõi</a>
                    <a href="#profile-follower-table" class="profile-option">Người theo dõi</a>
                    <a href="#profile-tag-table" class="profile-option">Thẻ</a>
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
                                    <img src="{{ asset($post->avatar) }}" alt="" />
                                </div>
                                <div class="post__card--wrapcontent">
                                    <div class="post__card--header">
                                        <a href="" class="post__card--username"> {{ $post->name }} </a>
                                        <div class="post__created--time">{{ $post->created_at }}</div>
                                        <div class="post-reading-time"><span>Đọc trong </span>{{ $post->time }}</div>
                                        <ion-icon name="link-outline"></ion-icon>
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
                                        @foreach ($post->tags as $tag)
                                            <a href="{{ route('tag.show', $tag->id) }}" class="post__card--tag">{{ $tag->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="profile-series-table" class="profile__table--display">
                        @foreach ($user_series as $series)
                            <div class="profileVw__series--wrap">
                                <div class="profileVw__series--title">
                                    <div class="profileVw__series--name">
                                        {{ $series->name }}
                                    </div>
                                    <div class="profileVw__series--created">
                                        {{ $series->created_at }}
                                    </div>
                                    <div class="profileVw__series--seperate">/</div>
                                    <div class="profileVw__series--amount-posts">
                                        <span>{{ sizeOf($series->relative_posts) }}</span>
                                        <ion-icon name="reader-outline"></ion-icon>
                                    </div>
                                </div>
                                <ol class="profileVw__series--posts">
                                    @foreach ($series->relative_posts as $post)
                                        <a href="{{ route('post.show', $post->id) }}" class="profileVw__posts--link">
                                            <li>{{ $post->title }}</li>
                                        </a>
                                    @endforeach
                                </ol>
                            </div>
                        @endforeach
                    </div>
                    <div id="profile-question-table" class="profile__table--display">
                        @foreach ($user_questions as $question)
                            @php
                                $current_question = new QuestionData($question->question_id);
                                $question_info = $current_question->getQuestion();
                                $author = $current_question->getAuthor();
                            @endphp
                            <div class="card__question--wrap">
                                <div class="card__question--leftpart">
                                    <div class="cardquestion__leftpart--header">
                                        <ion-icon name="time-outline"></ion-icon>
                                        <p>{{ $question_info->created_at }}</p>
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
                                            <img src="{{ asset($author->avatar) }}" alt="" />
                                        </div>
                                        <div class="cardquestion__author--name">
                                            <a href="{{ route('profile.show', $author->id) }}">{{ $author->name }}</a>
                                        </div>
                                        <ion-icon name="arrow-undo-outline"></ion-icon>
                                        <div class="cardquestion__list--helper">
                                            @foreach ($current_question->getHelper() as $helper)
                                                <img src="{{ asset($helper->avatar) }}" alt="" />
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="cardquestion__rightpart--body">
                                        <a href="{{ route('question.show', $question_info->id) }}">{{ $question_info->title }}</a>
                                    </div>
                                    <div class="cardquestion__rightpart--footer">
                                        <div class="cardquestion__list-tag">
                                            @foreach ($current_question->getTag() as $tag)
                                                <a href="{{ route('tag.show', $tag->tag_id) }}" class="post__card--tag">{{ $tag->name }}</a>
                                            @endforeach
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
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                    <div id="profile-bookmark-table" class="profile__table--display">
                        @foreach ($user_bookmarks as $bookmark)
                            @php
                                $profileVwpost = new PostData($bookmark->post_id);
                            @endphp
                            <div class="post__card--wrap">
                                <div class="post__card--useravatar">
                                    <img src="{{ asset($bookmark->avatar) }}" alt="" />
                                </div>
                                <div class="post__card--wrapcontent">
                                    <div class="post__card--header">
                                        <a href="" class="post__card--username"> {{ $bookmark->name }} </a>
                                        <div class="post__created--time">{{ $bookmark->created_at }}</div>
                                        <div class="post-reading-time"><span>Đọc trong </span>{{ $bookmark->time }}</div>
                                        <ion-icon name="link-outline"></ion-icon>
                                        <ion-icon name="bookmark-outline"></ion-icon>
                                    </div>
                                    <div class="post__card--body">
                                        <h2 class="post__card--title">
                                            @php
                                                $convert_slug = remove_sign($bookmark->title);
                                            @endphp
                                            <a href="{{ url("/post/{$convert_slug}|{$bookmark->post_id}") }}">{{ $bookmark->title }}</a>
                                        </h2>
                                    </div>
                                    <div class="post__card--footer">
                                        @foreach ($profileVwpost->getTag() as $tag)
                                            <a href="{{ route('tag.show', $tag->tag_id) }}" class="post__card--tag">{{ $tag->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="profile-following-table" class="profile__table--display">
                        @foreach ($user_following as $following)
                            <div class="profile__following--wrap">
                                <div class="profile__following--wrapavatar">
                                    <img class="profile__following--avatar" src="{{ asset($following->avatar) }}" alt="">
                                </div>
                                <div class="profile__following--infomation">
                                    <div class="profile__following--name">
                                        <a href="{{ route('profile.show',$following->following_id) }}" class="underline__none">{{ $following->name }}</a>
                                        <button class="profile__follow--btn" type="button">Theo dõi</button>
                                    </div>
                                    <div class="profile__following--email">
                                        {{ $following->email }}
                                    </div>
                                    <div class="profile__following--index">
                                        <div class="profile__following">
                                            <ion-icon name="star-outline"></ion-icon>
                                            <span>3493</span>
                                        </div>
                                        <div class="profile__following">
                                            <ion-icon name="paper-plane-outline"></ion-icon>
                                            <span>449</span>
                                        </div>
                                        <div class="profile__following">
                                            <ion-icon name="person-add-outline"></ion-icon>
                                            <span>33</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="profile-follower-table" class="profile__table--display">
                        @foreach ($user_follower as $follower)
                            <div class="profile__following--wrap">
                                <div class="profile__following--wrapavatar">
                                    <img class="profile__following--avatar" src="{{ asset($follower->avatar) }}" alt="">
                                </div>
                                <div class="profile__following--infomation">
                                    <div class="profile__following--name">
                                        <a href="{{ route('profile.show',$follower->follower_id) }}" class="underline__none">{{ $follower->name }}</a>
                                        <button class="profile__follow--btn" type="button">Theo dõi</button>
                                    </div>
                                    <div class="profile__following--email">
                                        {{ $follower->email }}
                                    </div>
                                    <div class="profile__following--index">
                                        <div class="profile__following">
                                            <ion-icon name="star-outline"></ion-icon>
                                            <span>3493</span>
                                        </div>
                                        <div class="profile__following">
                                            <ion-icon name="paper-plane-outline"></ion-icon>
                                            <span>449</span>
                                        </div>
                                        <div class="profile__following">
                                            <ion-icon name="person-add-outline"></ion-icon>
                                            <span>33</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="profile-tag-table" class="profile__table--display">
                        @php
                            $profileVw_user = new UserData($user_informations->id);
                        @endphp
                        @foreach ($profileVw_user->getTag() as $tag)
                            <div class="tagTg__card--wrap">
                                <div class="tagTg__card--follow">
                                    <img src="{{ isset($tag->tag_avatar) ? $tag->tag_avatar : 'https://bit.ly/3pbRb8m' }}" alt="" class="tagTg__card--image">
                                    <button class="tagTg__card--followBtn" type="button">Theo dõi</button>
                                </div>
                                <div class="tagTg__card--info">
                                    <a href="{{ route('tag.show', $tag->id) }}" class="tagTg__card--name">{{ $tag->name }}</a>
                                    <div class="tagTg__card--index">
                                        <div class="tagTg__index--element">
                                            <div class="tagTg__index--amount">23234</div>
                                            <span></span>
                                            <div class="tagTg__index--name">Bài viết</div>
                                        </div>
                                        <div class="tagTg__index--element">
                                            <div class="tagTg__index--amount">4839</div>
                                            <span></span>
                                            <div class="tagTg__index--name">Câu hỏi</div>
                                        </div>
                                        <div class="tagTg__index--element">
                                            <div class="tagTg__index--amount">9384</div>
                                            <span></span>
                                            <div class="tagTg__index--name">Nhà sáng tạo</div>
                                        </div>
                                        <div class="tagTg__index--element">
                                            <div class="tagTg__index--amount">349</div>
                                            <span></span>
                                            <div class="tagTg__index--name">Người theo dõi</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="profile-display-right">
                    <div id="profile-index-table">
                        @php
                            $user = new UserData($user_informations->id);
                        @endphp
                        <div class="profile__index--row">
                            <div class="profile__index--name">Lượt xem các bài viết</div>
                            <div class="profile__index--index">1443</div>
                        </div>
                        <div class="profile__index--row">
                            <div class="profile__index--name">Đang được theo dõi</div>
                            <div class="profile__index--index">{{ $user->getFollower(size: true) }}</div>
                        </div>
                        <div class="profile__index--row">
                            <div class="profile__index--name">Đang theo dõi</div>
                            <div class="profile__index--index">{{ $user->getFollowing(size: true) }}</div>
                        </div>
                        <div class="profile__index--row">
                            <div class="profile__index--name">Câu trả lời</div>
                            <div class="profile__index--index">{{ $user->getAnswer(size: true) }}</div>
                        </div>
                        <div class="profile__index--row">
                            <div class="profile__index--name">Đánh dấu</div>
                            <div class="profile__index--index">{{ $user->getBookmark(size: true) }}</div>
                        </div>
                        <div class="profile__index--row">
                            <div class="profile__index--name">Câu hỏi</div>
                            <div class="profile__index--index">{{ $user->getQuestion(size: true) }}</div>
                        </div>
                        <div class="profile__index--row">
                            <div class="profile__index--name">Bài viết</div>
                            <div class="profile__index--index">{{ $user->getPost(size: true) }}</div>
                        </div>
                        <div class="profile__index--row">
                            <div class="profile__index--name">Thẻ</div>
                            <div class="profile__index--index">{{ $user->getTag(size: true) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

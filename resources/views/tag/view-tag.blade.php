@extends('layouts.header-footer-create')
@section('title', 'Tags')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/tag/view-tag.css') }}">
@endsection
@section('script')
    <script src="{{ asset('assets/js/tag/view-tag.js') }}"></script>
@endsection
@section('content')
    <div id="tagVw-wrap-all">
        <div id="tagVw-header-wrap">
            <div id="tagVw-tag-info">
                <img src="https://bit.ly/3pbRb8m" id="tagVw-avatar" alt="">
                <div id="tagVw-wrap-name">
                    <div id="tagVw-name">{{ $tag_info->name }}</div>
                    <button id="tagVw-follow" type="button">Theo Doi</button>
                </div>
            </div>
            <div id="tagVw-tag-description">
                <p id="tagVw-big-letters"></p>
                <p id="tagVw-paragraph">{{ $tag_info->tag_description }}</p>
            </div>
        </div>
        <div id="tagVw-body-wrap">
            <div id="tagVw-left-part">
                <div id="tagVw-menu-bar">
                    <a href="#tagVw-content-post" class="tagVw__option--choice">Bai Viet</a>
                    <a href="#tagVw-content-series" class="tagVw__option--choice">Series</a>
                    <a href="#tagVw-content-question" class="tagVw__option--choice">Cau Hoi</a>
                    <a href="#tagVw-content-creator" class="tagVw__option--choice">Nguoi Tao Noi Dung</a>
                </div>
                <div id="tagVw-content-wrap">
                    <div id="tagVw-filter-wrap">
                        <span>Sap Xep Theo</span>
                        <span>Bai viet moi nhat</span>
                    </div>
                    <div id="tagVw-content-view">
                        <div id="tagVw-list-content">
                            <div id="tagVw-content-post" class="tagVw__content--option">
                                @foreach ($relative_posts as $post)
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
                                                    <a href="{{ route('post.show', remove_sign($post->title) . '|' . $post->post_id) }}">{{ $post->title }}</a>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div id="tagVw-content-series" class="tagVw__content--option">
                                @foreach ($tag_series as $series)
                                    <p>
                                        {{ $series->series_name }}
                                    </p>
                                @endforeach
                            </div>
                            <div id="tagVw-content-question" class="tagVw__content--option">
                                @foreach ($relative_questions as $question)
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
                                                    <a href="/profile/${this.questioner}">{{ $question->name }}</a>
                                                </div>
                                                <ion-icon name="arrow-undo-outline"></ion-icon>
                                                <div class="cardquestion__list--helper">
                                                    @@
                                                </div>
                                            </div>
                                            <div class="cardquestion__rightpart--body">
                                                <a href="/question/{{ $question->question_id }}">{{ $question->title }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div id="tagVw-content-creator" class="tagVw__content--option">
                                @foreach ($content_creators as $creator)
                                    <div class="profile__following--wrap">
                                        <div class="profile__following--wrapavatar">
                                            <img class="profile__following--avatar" src="{{ $creator->avatar }}" alt="">
                                        </div>
                                        <div class="profile__following--infomation">
                                            <div class="profile__following--name">
                                                <a href="" class="underline__none">{{ $creator->name }}</a>
                                                <button class="profile__follow--btn">Theo dõi</button>
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
                                            <div class="profile__following--email">
                                                {{ $creator->email }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tagVw-right-part">
                <div id="tagVw-content-first">
                    <div id="tagVw-tag-name">
                        <span>Tag name</span>
                        <span></span>
                    </div>
                    <div id="tagVw-tag-index">
                        <div class="tagVw__index--wrap">
                            <div class="tagVw__index--amount">425</div>
                            <p class="tagVw__index--name">Bai Viet</p>
                        </div>
                        <div class="tagVw__index--wrap">
                            <div class="tagVw__index--amount">2525</div>
                            <p class="tagVw__index--name">Cau Hoi</p>
                        </div>
                        <div class="tagVw__index--wrap">
                            <div class="tagVw__index--amount">23562</div>
                            <p class="tagVw__index--name">Nguoi theo doi</p>
                        </div>
                    </div>
                </div>
                <div id="tagVw-content-second">
                    <div id="tagVw-tag-popular">
                        <span>Tag pho bien</span>
                        <span></span>
                    </div>
                    <div id="tagVw-list-tag">
                        <div class="tagVw__tag--others">
                            <div class="tagVw__others--name">Javascript</div>
                            <div class="tagVw__others--amount">3924</div>
                        </div>
                        <div class="tagVw__tag--others">
                            <div class="tagVw__others--name">PHP</div>
                            <div class="tagVw__others--amount">2420</div>
                        </div>
                        <div class="tagVw__tag--others">
                            <div class="tagVw__others--name">Python</div>
                            <div class="tagVw__others--amount">5984</div>
                        </div>
                        <div class="tagVw__tag--others">
                            <div class="tagVw__others--name">HTML</div>
                            <div class="tagVw__others--amount">59585</div>
                        </div>
                    </div>
                    <div id="tagVw-all-tag-link">
                        <ion-icon name="pricetags-outline"></ion-icon>
                        <span>Xem tat ca tag</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

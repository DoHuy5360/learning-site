@extends('layouts.header-footer-public')
@section('content')
    <h1 id="welcome">Chào mừng đến với Learning Site</h1>
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
            </div>
        </div>
        <div id="body-part-right">
            <div id="body-content-right">
                <h2 class="body__link--wrap">
                    <a href="" class="body__link--redirect">Các câu hỏi mới nhất</a>
                    <span></span>
                </h2>
                <div class="body__question--wrap">
                    <div class="question__card--wrap">
                        <div class="question__card--header">
                            <h2 class="question__card--title">
                                <a href="">Lam cach nao de hack facebook</a>
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
                            <a href="" class="question__card--username"> Do huy </a>
                        </div>
                    </div>
                    <div class="question__card--wrap">
                        <div class="question__card--header">
                            <h2 class="question__card--title">
                                <a href="">Lam cach nao de hack facebook</a>
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
                            <a href="" class="question__card--username"> Do huy </a>
                        </div>
                    </div>
                    <div class="question__card--wrap">
                        <div class="question__card--header">
                            <h2 class="question__card--title">
                                <a href="">Lam cach nao de hack facebook</a>
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
                            <a href="" class="question__card--username"> Do huy </a>
                        </div>
                    </div>
                    <div class="question__card--wrap">
                        <div class="question__card--header">
                            <h2 class="question__card--title">
                                <a href="">Lam cach nao de hack facebook</a>
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
                            <a href="" class="question__card--username"> Do huy </a>
                        </div>
                    </div>
                    <div class="question__card--wrap">
                        <div class="question__card--header">
                            <h2 class="question__card--title">
                                <a href="">Lam cach nao de hack facebook</a>
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
                            <a href="" class="question__card--username"> Do huy </a>
                        </div>
                    </div>
                    <div class="question__card--wrap">
                        <div class="question__card--header">
                            <h2 class="question__card--title">
                                <a href="">Lam cach nao de hack facebook</a>
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
                            <a href="" class="question__card--username"> Do huy </a>
                        </div>
                    </div>
                    <div class="question__card--wrap">
                        <div class="question__card--header">
                            <h2 class="question__card--title">
                                <a href="">Lam cach nao de hack facebook</a>
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
                            <a href="" class="question__card--username"> Do huy </a>
                        </div>
                    </div>
                    <div class="question__card--wrap">
                        <div class="question__card--header">
                            <h2 class="question__card--title">
                                <a href="">Lam cach nao de hack facebook</a>
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
                            <a href="" class="question__card--username"> Do huy </a>
                        </div>
                    </div>
                    <div class="question__card--wrap">
                        <div class="question__card--header">
                            <h2 class="question__card--title">
                                <a href="">Lam cach nao de hack facebook</a>
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
                            <a href="" class="question__card--username"> Do huy </a>
                        </div>
                    </div>
                    <div class="question__card--wrap">
                        <div class="question__card--header">
                            <h2 class="question__card--title">
                                <a href="">Lam cach nao de hack facebook</a>
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
                            <a href="" class="question__card--username"> Do huy </a>
                        </div>
                    </div>
                    <div class="question__card--wrap">
                        <div class="question__card--header">
                            <h2 class="question__card--title">
                                <a href="">Lam cach nao de hack facebook</a>
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
                            <a href="" class="question__card--username"> Do huy </a>
                        </div>
                    </div>
                    <div class="question__card--wrap">
                        <div class="question__card--header">
                            <h2 class="question__card--title">
                                <a href="">Lam cach nao de hack facebook</a>
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
                            <a href="" class="question__card--username"> Do huy </a>
                        </div>
                    </div>
                    <div class="question__card--wrap">
                        <div class="question__card--header">
                            <h2 class="question__card--title">
                                <a href="">Lam cach nao de hack facebook</a>
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
                            <a href="" class="question__card--username"> Do huy </a>
                        </div>
                    </div>
                    <div class="question__card--wrap">
                        <div class="question__card--header">
                            <h2 class="question__card--title">
                                <a href="">Lam cach nao de hack facebook</a>
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
                            <a href="" class="question__card--username"> Do huy </a>
                        </div>
                    </div>
                    <div class="question__card--wrap">
                        <div class="question__card--header">
                            <h2 class="question__card--title">
                                <a href="">Lam cach nao de hack facebook</a>
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
                            <a href="" class="question__card--username"> Do huy </a>
                        </div>
                    </div>
                    <div class="question__card--wrap">
                        <div class="question__card--header">
                            <h2 class="question__card--title">
                                <a href="">Lam cach nao de hack facebook</a>
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
                            <a href="" class="question__card--username"> Do huy </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

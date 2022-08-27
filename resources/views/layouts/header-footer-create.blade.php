<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/_root.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header-footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/post.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/question.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/view-question.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/create-post.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/create-question.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">

    <title>
        @yield('title')
    </title>
</head>

<body>
    <div id="site-structure">
        <header id="site-header">
            <div id="header-width">
                <div class="header__part header__part--left">
                    <img id="header-logo" src="https://firebasestorage.googleapis.com/v0/b/image-resize-5d865.appspot.com/o/Images%2FmyLogo.png?alt=media&token=13f9f9ff-4ca8-42ff-adb4-5d972c0ebe98" />
                    <div id="wrap-link">
                        <a href="{{ url('/') }}" class="header__link--redirect">Bài Viết</a>
                        <a href="{{ route('question.index') }}" class="header__link--redirect">Hỏi Đáp</a>
                        <a href="" class="header__link--redirect">Tài Liệu</a>
                        <a href="" class="header__link--redirect">Đỉnh Núi</a>
                    </div>
                </div>
                <div class="header__part header__part--center">
                    <div id="header-search">
                        <input type="text" name="" id="input-search" />
                        <div id="search-tag"></div>
                        <ion-icon name="search-outline"></ion-icon>
                    </div>
                    <div id="suggest-wrap">
                        <div id="tags-wrap">
                            <div id="suggest-tag">Word</div>
                            <div id="suggest-tag">Exel</div>
                            <div id="suggest-tag">Power poin</div>
                            <div id="suggest-tag">Python</div>
                            <div id="suggest-tag">Css</div>
                            <div id="suggest-tag">Javascript</div>
                            <div id="suggest-tag">PHP</div>
                            <div id="suggest-tag">HTML</div>
                            <div id="suggest-tag">C#</div>
                            <div id="suggest-tag">React</div>
                            <div id="suggest-tag">Angular</div>
                        </div>
                    </div>
                </div>
                <div class="header__part header__part--right">
                    @if (Route::has('login'))
                        <div id="auth-field">
                            @auth
                                <div id="wrap-notification">
                                    <ion-icon name="help-outline"></ion-icon>
                                    <ion-icon name="settings-outline"></ion-icon>
                                    <ion-icon name="chatbubble-outline"></ion-icon>
                                    <ion-icon name="star-outline"></ion-icon>
                                    <ion-icon name="notifications-outline"></ion-icon>
                                    <ion-icon name="bookmarks-outline"></ion-icon>
                                    <ion-icon name="paper-plane-outline"></ion-icon>
                                </div>
                                <div id="user-self-management">
                                    <img id="header-user-avatar" src="{{ Auth::user()->avatar }}" alt="" draggable="false">
                                    <div id="user-management-list-wrap">
                                        <div id="user-management-list">
                                            <button class="option__cell" type="button">Profile</button>
                                            <button class="option__cell" type="button">Setting</button>
                                            <form id="form-logout" action="{{ route('logout') }}" method="post">
                                                @csrf
                                                <button class="option__cell" type="submit">Log out</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div id="login-register-field">
                                    <a href="{{ route('login') }}" class="auth__link--redirect">Đăng Nhập</a>
                                    <span>/</span>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="auth__link--redirect">Đăng Ký</a>
                                    @endif
                                </div>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </header>
        <!-- --------------------------------- End header -->
        @yield('content')
        <!-- todo --------------------------------- End body -->
        <!-- --------------------------------- End footer -->
    </div>
    <script
        type="module"
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
    ></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
    @yield('script')
</body>

</html>

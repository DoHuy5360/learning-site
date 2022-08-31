<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/_root.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header-footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/post.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/view-post.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/question.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/view-question.css') }}">
    <title>Document</title>
</head>

<body>
    <div id="site-structure">
        <header id="site-header">
            <div id="header-width">
                <div class="header__part header__part--left">
                    <img id="header-logo" src="https://firebasestorage.googleapis.com/v0/b/image-resize-5d865.appspot.com/o/Images%2FmyLogo.png?alt=media&token=13f9f9ff-4ca8-42ff-adb4-5d972c0ebe98" />
                    <div id="wrap-link">
                        <a href="{{ url('/') }}" class="header__link--redirect">Bài Viết</a>
                        <a href="{{ url('/question') }}" class="header__link--redirect">Hỏi Đáp</a>
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
                                    <a href="{{ url('/post/create') }}">
                                        <ion-icon name="paper-plane-outline"></ion-icon>
                                    </a>
                                </div>
                                <div id="user-self-management">
                                    <img id="header-user-avatar" src="{{ Auth::user()->avatar }}" alt="" draggable="false">
                                    <div id="user-management-list-wrap">
                                        <div id="user-management-list">
                                            <a href="{{ route('profile.show', Auth::user()->id) }}">
                                                <button class="option__cell" type="button">Profile</button>
                                            </a>
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
        <div id="wrap-background"></div>
        <!-- todo --------------------------------- End background -->
        @yield('content')

        <!-- todo --------------------------------- End body -->
        <footer id="site-footer">
            <div id="footer-width">
                <div id="footer-part-top">
                    <div id="footer-part-left" class="footer__part">
                        <div id="footer-left-admin">
                            <h3>Quản Trị Viên</h3>
                            <div class="footer__list--info">
                                <a href="">Lưu Ý</a>
                                <a href="">Báo Lỗi</a>
                                <a href="">Phản Hồi</a>
                            </div>
                        </div>
                        <div id="footer-left-users">
                            <h3>Người dùng</h3>
                            <div class="footer__list--info">
                                <a href="">Danh Sách Tác Giả</a>
                                <a href="">Nhãn Nội Dung</a>
                                <a href="">Sự Kiện</a>
                            </div>
                        </div>
                    </div>
                    <div id="footer-part-center" class="footer__part">
                        <h3>Về chúng tôi</h3>
                        <div class="footer__list--info">
                            <a href="">Thông tin</a>
                            <a href="">Hợp tác</a>
                            <a href="">Thuê</a>
                        </div>
                    </div>
                    <div id="footer-part-right" class="footer__part">
                        <h3>Learning Site</h3>
                        <div class="footer__list--info">
                            <a href="">Giới Thiệu</a>
                            <a href="">Điều Khoản</a>
                        </div>
                    </div>
                </div>
                <div id="footer-part-bottom">
                    <div id="footer__left--bottom">
                        <div id="footer-language-wrap">
                            <ion-icon name="language-outline"></ion-icon>
                            <input type="text" readonly />
                            <ion-icon name="chevron-back-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- --------------------------------- End footer -->
    </div>
    <script
        type="module"
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
    ></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="{{ asset('assets/js/ajax.js') }}"></script>
    @yield('script')
</body>

</html>
<script src="{{ asset('assets/js/post.js') }}"></script>

@extends('layouts.header-footer-create')
@section('title', 'Tags')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/tag/view-tag.css') }}">
@endsection
@section('content')
    <div id="tagVw-wrap-all">
        <div id="tagVw-header-wrap">
            <div id="tagVw-tag-info">
                <img src="https://bit.ly/3pbRb8m" id="tagVw-avatar" alt="">
                <div id="tagVw-wrap-name">
                    <div id="tagVw-name">Tag Name</div>
                    <button id="tagVw-follow">Theo Doi</button>
                </div>
            </div>
            <div id="tagVw-tag-description">
                <p id="tagVw-big-letters">L</p>
                <p id="tagVw-paragraph">
                    orem ipsum dolor, sit amet consectetur adipisicing elit. Adipisci aliquid quos perspiciatis soluta itaque, inventore, delectus tenetur magni unde eum et. Provident, iusto ratione
                    consectetur enim minima atque harum obcaecati?
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Adipisci aliquid quos perspiciatis soluta itaque, inventore, delectus tenetur magni unde eum et. Provident, iusto ratione
                    consectetur enim minima atque harum obcaecati?
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Adipisci aliquid quos perspiciatis soluta itaque, inventore, delectus tenetur magni unde eum et. Provident, iusto ratione
                    consectetur enim minima atque harum obcaecati?
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Adipisci aliquid quos perspiciatis soluta itaque, inventore, delectus tenetur magni unde eum et. Provident, iusto ratione
                    consectetur enim minima atque harum obcaecati?
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Adipisci aliquid quos perspiciatis soluta itaque, inventore, delectus tenetur magni unde eum et. Provident, iusto ratione
                    consectetur enim minima atque harum obcaecati?
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Adipisci aliquid quos perspiciatis soluta itaque, inventore, delectus tenetur magni unde eum et. Provident, iusto ratione
                    consectetur enim minima atque harum obcaecati?
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Adipisci aliquid quos perspiciatis soluta itaque, inventore, delectus tenetur magni unde eum et. Provident, iusto ratione
                    consectetur enim minima atque harum obcaecati?
                </p>
            </div>
        </div>
        <div id="tagVw-body-wrap">
            <div id="tagVw-left-part">
                <div id="tagVw-menu-bar">
                    <a href="" class="tagVw__option--choice">Bai Viet</a>
                    <a href="" class="tagVw__option--choice">Series</a>
                    <a href="" class="tagVw__option--choice">Cau Hoi</a>
                    <a href="" class="tagVw__option--choice">Nguoi Theo Doi</a>
                </div>
                <div id="tagVw-content-wrap">
                    <div id="tagVw-filter-wrap">
                        <span>Sap Xep Theo</span>
                        <span>Bai viet moi nhat</span>
                    </div>
                    <div id="tagVw-content-view">
                        <div id="tagVw-list-content">
                            <div class="tagVw__content--option">
                                {{-- Post here --}}
                            </div>
                            <div class="tagVw__content--option"></div>
                            <div class="tagVw__content--option"></div>
                            <div class="tagVw__content--option"></div>
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

@extends('layouts.header-footer-create')
@section('title', 'Tất cả thẻ')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/tag/tag.css') }}">
@endsection
@section('script')

@endsection
@section('content')
    <div id="tagTg-wrap-all">
        <div id="tagTg-header-wrap">
            <div id="tagTg-amount-tag">
                <p>Có {{ sizeOf($all_tags) }} chủ đề</p>
            </div>
            <span class="tagTg__underline"></span>
            <div id="tagTg-search-type">
                <span class="tagTg__option--bar">Loại nội dung</span>
                <button id="tagTg-search-btn" type="button">Tất cả</button>
            </div>
            <span class="tagTg__underline"></span>
            <div id="tagTg-sort-type">
                <span class="tagTg__option--bar">Sắp xếp theo</span>
                <button id="tagTg-sort-btn" type="button">Phổ biến</button>
            </div>
        </div>
        <div id="tagTg-body">
            @foreach ($all_tags as $tag)
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
@endsection

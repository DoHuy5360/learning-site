@extends('layouts.header-footer-create')
@section('title')
    Chỉnh sửa bài viết
@endsection
@section('script')
    <script src="{{ asset('assets/js/post/edit-post.js') }}"></script>
    <script src="{{ asset('assets/js/post/create-post.js') }}"></script>
@endsection
@section('content')
    <form action="{{ route('post.update', remove_sign($corresponding_post->title) . '|' . $corresponding_post->id) }}" id="update-post-form" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PATCH')
        <input name="time" id="time-to-read-post" type="hidden" />
        <input name="raw_content" id="raw-content" value="{{ $corresponding_post->content }}" type="hidden" />
        <input name="array_series" id="list-series" type="hidden">
        <div id="editer-full-wrap">
            <div id="editor-input-title">
                <label class="create-post-label" for="create-post-title-input">Nhập tiêu đề ở đây.</label>
                <input name="title" id="create-post-title-input" value="{{ $corresponding_post->title }}" placeholder="..." type="text" required />
            </div>
            <div id="editor-input-tag-wrap">
                <label class="create-post-label" for="create-post-tag-input">Nhập tag ở đây, tối đa 5 tags.</label>
                <div id="create-post-input-tag-field">
                    <div id="editor-input-tag">
                        <div id="editor-list-tag">
                            @foreach ($corresponding_tag as $tag)
                                <div class="editor__tag--box">
                                    <div class="editor__tag--name">{{ $tag->name }}</div>
                                    <button class="editor__tag--remove" type="button">
                                        <ion-icon name="close-outline"></ion-icon>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <input name="tag" id="create-post-tag-input" placeholder="..." type="text" required />
                    </div>
                    <button id="send-request-to-update-post" type="button">Cập nhật thay đổi</button>
                </div>
            </div>
            <div id="edit-advance-option">
                <div id="editor-input-file">
                    <label class="create-post-label" for="create-post-file-input">Chọn file đính kèm nếu có, giới hạn 1 file.</label>
                    <input name="file[]" id="create-post-file-input" type="file" multiple>
                </div>
                <div id="edit-series-choice">
                    <input type="checkbox" name="" id="edit-series-add-btn" value="">
                    <label id="edit-series-hidden-box" for="edit-series-add-btn">
                        <p>Thêm vào Series</p>
                        <div id="edit-series-list">
                            <div id="edit-add-series-box">
                                <input type="text" name="" id="edit-add-new-series" placeholder="Series mới" required>
                                <button type="button" id="edit-add-series-btn">Tạo</button>
                            </div>
                            @foreach ($all_series as $series)
                                <div class="series__element">
                                    <label for="input-series-element">{{ $series->name }}</label>
                                    @if (isset($series->choosen))
                                        <input class="input__series--element" type="checkbox" data-series-id="{{ $series->id }}" {{ $series->choosen }}>
                                    @else
                                        <input class="input__series--element" type="checkbox" data-series-id="{{ $series->id }}">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </label>
                </div>
            </div>
            <div id="editor-board-wrap">
                <input name="content" id="update-content" type="hidden" />
                <div name="post-area" aria-disabled="true"></div>
            </div>
        </div>
    </form>
@endsection

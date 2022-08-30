@extends('layouts.header-footer-create')
@section('script')
    <script src="{{ asset('assets/js/post/create-post.js') }}"></script>
@endsection
@section('content')
    @if ($message = Session::get('success'))
        <div class="success-message">{{ $message }}</div>
    @endif
    <form action="{{ route('post.store') }}" id="create-post-form" enctype="multipart/form-data" method="POST">
        @csrf
        <input name="time" id="time-to-read-post" type="hidden" />
        <input name="array_series" id="list-series" type="hidden">
        <div id="editer-full-wrap">
            <div id="editor-input-title">
                <label class="create-post-label" for="create-post-title-input">Nhập tiêu đề ở đây.</label>
                <input name="title" id="create-post-title-input" placeholder="..." type="text" required />
            </div>
            <div id="editor-input-tag-wrap">
                <label class="create-post-label" for="create-post-tag-input">Nhập tag ở đây, tối đa 5 tags.</label>
                <div id="create-post-input-tag-field">
                    <div id="editor-input-tag">
                        <div id="editor-list-tag"></div>
                        <input name="tag" id="create-post-tag-input" placeholder="..." type="text" required />
                    </div>
                    <button id="send-request-to-store-post" type="button">Công bố bài viết</button>
                </div>
            </div>
            <div id="edit-advance-option">
                <div id="editor-input-file">
                    <label class="create-post-label" for="create-post-file-input">Chọn file đính kèm nếu có, giới hạn 3 file.</label>
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
                                    <input type="checkbox" data-series-id="{{ $series->id }}" class="input__series--element">
                                </div>
                            @endforeach
                        </div>
                    </label>
                </div>
            </div>
            <div id="editor-board-wrap">
                <input name="content" id="post-content" type="hidden" />
                <div name="post-area" aria-disabled="true"></div>
            </div>
        </div>
    </form>
@endsection

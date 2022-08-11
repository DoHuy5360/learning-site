@extends('layouts.header-footer-create')
@section('content')
    @if ($message = Session::get('success'))
        <div class="success-message">{{ $message }}</div>
    @endif
    <form action="{{ route('post.store') }}" id="create-post-form" enctype="multipart/form-data" method="POST">
        @csrf
        <input name="time" id="time-to-read-post" type="hidden" />
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
            <div id="editor-input-file">
                <label class="create-post-label" for="create-post-file-input">Chọn file đính kèm nếu có, giới hạn 1 file.</label>
                <input name="file[]" id="create-post-file-input" type="file" multiple>
            </div>
            <div id="editor-board-wrap">
                <input name="content" id="post-content" type="hidden" />
                <div name="post-area" aria-disabled="true"></div>
            </div>
        </div>
    </form>
@endsection

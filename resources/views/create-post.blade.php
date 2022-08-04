@extends('layouts.header-footer-create')
@section('content')
    @if ($message = Session::get('success'))
        <div class="success-message">{{ $message }}</div>
    @endif
    <form action="{{ route('post.store') }}" id="create-post-form" method="POST">
    @csrf
    <input name="time" id="time-to-read-post" type="hidden"/>
    <div id="editer-full-wrap">
        <div id="editor-input-title">
            <input name="title" placeholder="Nhập tiêu đề ở đây" type="text" required/>
        </div>
        <div id="editor-input-tag-wrap">
            <div id="editor-input-tag">
                <div id="editor-list-tag"></div>
                <input name="tag" placeholder="Nhập tag ở đây tối đa 5 tags" type="text" required/>
            </div>
            <button id="send-request-to-store-post" type="button">Công bố bài viết</button>
        </div>
        <div id="editor-board-wrap">
            <input name="content" id="post-content" type="hidden" />
            <div name="area" aria-disabled="true"></div>
        </div>
    </div>
    </form>
@endsection

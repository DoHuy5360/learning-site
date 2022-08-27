@extends('layouts.header-footer-create')
@section('script')
    <script src="{{ asset('assets/js/question/create-question.js') }}"></script>
@endsection
@section('content')
    @if ($message = Session::get('success'))
        <div class="success-message">{{ $message }}</div>
    @endif
    <form action="{{ route('question.store') }}" id="create-question-form" method="POST">
        @csrf
        <div id="editer-full-wrap">
            <div id="editor-input-title">
                <label class="create-question-label" for="create-question-title-input">Nhập tiêu đề ở đây.</label>
                <input name="title" id="create-question-title-input" placeholder="..." type="text" required />
            </div>
            <div id="editor-input-tag-wrap">
                <label class="create-question-label" for="create-question-tag-input">Nhập tag ở đây, tối đa 5 tags.</label>
                <div id="create-question-input-tag-field">
                    <div id="editor-input-tag">
                        <div id="editor-list-tag"></div>
                        <input name="tag" id="create-question-tag-input" placeholder="..." type="text" required />
                    </div>
                    <button id="send-request-to-store-question" type="button">Công bố câu hỏi</button>
                </div>
            </div>
            <div id="editor-board-wrap">
                <input name="content" id="question-content" type="hidden" />
                <div name="question-area" aria-disabled="true"></div>
            </div>
        </div>
    </form>
@endsection

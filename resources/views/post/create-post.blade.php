@extends('layouts.header-footer-create')
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
    <script>
        const csrf_token = document.querySelector('[name="_token"]').value
        // const list_series = document.getElementById('edit-series-list')
        const add_series_box = document.getElementById('edit-add-series-box')

        document.getElementById('edit-add-series-btn').addEventListener('click', e => {
            const series_name = document.getElementById('edit-add-new-series');
            const ajax = new XMLHttpRequest();
            ajax.open('POST', 'http://127.0.0.1:8000/series')
            ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
            ajax.send(`_token=${csrf_token}&series_name=${series_name.value}`)
            ajax.onreadystatechange = function() {
                if (this.readyState == 4 & this.status == 200 && this.responseText) {
                    const data_response = JSON.parse(this.responseText)
                    const {
                        series_information
                    } = data_response
                    const series_html = `
                    <div class="series__element">
                        <label for="input-series-element">${series_information}</label>
                        <input type="checkbox" name="series_element" id="">
                    </div>
                    `
                    add_series_box.insertAdjacentHTML('afterend', series_html)
                }
            }
        })

        // next step is send request
    </script>
@endsection

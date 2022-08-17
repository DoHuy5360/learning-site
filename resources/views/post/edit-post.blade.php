@extends('layouts.header-footer-create')
@section('content')
    {{-- @if ($message = Session::get('success'))
        <div class="success-message">{{ $message }}</div>
    @endif --}}
    <form action="{{ route('post.update', remove_sign($corresponding_post->title) . '|' . $corresponding_post->id) }}" id="update-post-form" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PATCH')
        <input name="time" id="time-to-read-post" type="hidden" />
        <input name="raw_content" id="raw-content" value="{{ $corresponding_post->content }}" type="hidden" />
        <div id="editer-full-wrap">
            <div id="editor-input-title">
                <label class="create-post-label" for="create-post-title-input">Nhập tiêu đề ở đây.</label>
                <input name="title" id="create-post-title-input" value="{{ $corresponding_post->title }}" placeholder="..." type="text" required />
            </div>
            <div id="editor-input-tag-wrap">
                <label class="create-post-label" for="create-post-tag-input">Nhập tag ở đây, tối đa 5 tags.</label>
                <div id="create-post-input-tag-field">
                    <div id="editor-input-tag">
                        <div id="editor-list-tag"></div>
                        <input name="tag" id="create-post-tag-input" placeholder="..." type="text" required />
                    </div>
                    <button id="send-request-to-update-post" type="button">Cập nhật thay đổi</button>
                </div>
            </div>
            <div id="editor-input-file">
                <label class="create-post-label" for="create-post-file-input">Chọn file đính kèm nếu có, giới hạn 1 file.</label>
                <input name="file[]" id="create-post-file-input" type="file" multiple>
            </div>
            <div id="editor-board-wrap">
                <input name="content" id="update-content" type="hidden" />
                <div name="post-area" aria-disabled="true"></div>
            </div>
        </div>
    </form>
    <script>
        window.onload = function() {
            const raw_content = document.getElementById('raw-content');
            const iframe_window = document.querySelector('.cke_wysiwyg_frame.cke_reset')
            const textarea_field = iframe_window.contentWindow.document.querySelector('[role="textbox"]')
            textarea_field.innerHTML = raw_content.value;
            raw_content.remove()
            let send_request_to_update_post = document.getElementById(
                "send-request-to-update-post"
            );

            function getTextAreaElement() {
                const text_area = document.querySelector(".cke_wysiwyg_frame.cke_reset");
                const content =
                    text_area.contentWindow.document.querySelector("[role='textbox']");
                return content;
            }
            const sixty_seconds = 60;
            const sixty_minutes = 60;
            const average_word_read_per_minute = 240; // Base on Google search
            const average_word_read_per_hour = average_word_read_per_minute * sixty_minutes;

            function getTimeToReadParagraph(_post_content) {
                const split_every_words = _post_content.split(" "),
                    total_word_in_post_content = split_every_words.length;
                average_time_to_read =
                    total_word_in_post_content / average_word_read_per_hour;
                const total_word_per_second =
                    average_time_to_read * sixty_minutes * sixty_seconds,
                    total_word_per_minute = average_time_to_read * sixty_minutes;
                let how_much_time, kind_of_time;
                if (total_word_per_second < sixty_seconds) {
                    how_much_time = total_word_per_second;
                    kind_of_time = "giây";
                } else if (total_word_per_minute < sixty_minutes) {
                    how_much_time = total_word_per_minute;
                    kind_of_time = "phút";
                } else {
                    how_much_time = average_time_to_read;
                    kind_of_time = "giờ";
                }
                const time_to_read = `${how_much_time.toFixed(1)} ${kind_of_time}`;
                return time_to_read;
            }
            const update_content = document.getElementById("update-content");
            const update_post_form = document.getElementById("update-post-form");
            const time_to_read_post = document.getElementById("time-to-read-post");
            send_request_to_update_post.addEventListener("click", (e) => {
                const textarea_element = getTextAreaElement();
                update_content.value = textarea_element.innerHTML;
                time_to_read_post.value = getTimeToReadParagraph(
                    textarea_element.innerText
                );
                update_post_form.submit();
            });

        }
    </script>
@endsection

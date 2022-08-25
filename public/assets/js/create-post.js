// todo: insert editor plugin
CKEDITOR.replace("post-area");
CKEDITOR.plugins.registered["save"] = {
    init: function (editor) {
        var command = editor.addCommand("save", {
            modes: { wysiwyg: 1, source: 1 },
            exec: function (editor) {
                const text_area = document.querySelector(
                        ".cke_wysiwyg_frame.cke_reset"
                    ),
                    content =
                        text_area.contentWindow.document.querySelector(
                            "[role='textbox']"
                        );
                document.getElementById("content").value = content.innerHTML;
                return;
            },
        });
        editor.ui.addButton("Save", { label: "My Save", command: "save" });
    },
};
// todo: get contents inside the editor textarea
function getTextAreaElement() {
    const text_area = document.querySelector(".cke_wysiwyg_frame.cke_reset");
    const content =
        text_area.contentWindow.document.querySelector("[role='textbox']");
    return content;
}
// todo: get time to read th post
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
let send_request_to_store_post = document.getElementById(
    "send-request-to-store-post"
);
let post_content = document.getElementById("post-content");
let create_post_form = document.getElementById("create-post-form");
let time_to_read_post = document.getElementById("time-to-read-post");
let list_series = document.getElementById("list-series");

// todo: process before send request
send_request_to_store_post.addEventListener("click", (e) => {
    // const list_tags = document.querySelectorAll('.editor__tag--name')
    const textarea_element = getTextAreaElement();
    post_content.value = textarea_element.innerHTML;
    time_to_read_post.value = getTimeToReadParagraph(
        textarea_element.innerHTML
    );
    list_series.value = series_selected_aray;
    tags_input_node.value = list_tags;
    create_post_form.submit();
});
// todo: add series ids to an array
let series_selected_aray = [];
const list_series_element = document.querySelectorAll(
    ".input__series--element"
);
list_series_element.forEach((series) => {
    series.addEventListener("change", (e) => {
        const data_series_id = series.getAttribute("data-series-id");
        if (e.currentTarget.checked) {
            series_selected_aray.push(data_series_id);
            // console.log(series_selected_aray);
        } else {
            const series_index = series_selected_aray.indexOf(data_series_id);
            series_selected_aray.splice(series_index, 1);
            // console.log(series_selected_aray);
        }
    });
});
let list_tags = [];
const list_tags_node = document.getElementById("editor-list-tag");
const tags_input_node = document.getElementById("create-post-tag-input");
tags_input_node.addEventListener("keydown", (e) => {
    if (e.code == "Enter") {
        const tag_name = tags_input_node.value;
        const tag_html = createTagNode(tag_name);
        list_tags_node.appendChild(tag_html)
        list_tags.push(tags_input_node.value);
        tags_input_node.value = "";
    }
});
function createTagNode(_tag_name) {
    const tag_box = document.createElement('div');
    tag_box.setAttribute('class', 'editor__tag--box')
    const tag_name = document.createElement('div');
    tag_name.setAttribute('class', 'editor__tag--name')
    tag_name.textContent = _tag_name
    const remove_tag = document.createElement('button')
    remove_tag.setAttribute('class', 'editor__tag--remove')
    remove_tag.setAttribute('type', 'button')
    remove_tag.innerHTML = '<ion-icon name="close-outline"></ion-icon>'
    remove_tag.addEventListener('click', e =>{
        const tag_index = list_tags.indexOf(_tag_name)
        list_tags.splice(tag_index,1)
        tag_box.remove()
    })
    tag_box.appendChild(tag_name)
    tag_box.appendChild(remove_tag)
    return tag_box;
    return `
    <div class="editor__tag--box">
        <div class="c">${_tag_name}</div>
        <button class="editor__tag--remove" type="button">
            <ion-icon name="close-outline"></ion-icon>
        </button>
    </div>
    `;
}
// window.onload = function () {
//     const text_area = document.querySelector(".cke_wysiwyg_frame.cke_reset");
//     content =
//         text_area.contentWindow.document.querySelector("[role='textbox']");
//     content.addEventListener("input", (e) => {
//         document.getElementById("content").value = content.innerHTML;
//     });
// };

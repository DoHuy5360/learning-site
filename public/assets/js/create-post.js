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
let send_request_to_store_post = document.getElementById(
        "send-request-to-store-post"
    ),
    post_content = document.getElementById("post-content"),
    create_post_form = document.getElementById("create-post-form");
time_to_read_post = document.getElementById("time-to-read-post");

send_request_to_store_post.addEventListener("click", (e) => {
    const textarea_element = getTextAreaElement();
    post_content.value = textarea_element.innerHTML;
    time_to_read_post.value = getTimeToReadParagraph(
        textarea_element.innerText
    );
    create_post_form.submit();
});
// window.onload = function () {
//     const text_area = document.querySelector(".cke_wysiwyg_frame.cke_reset");
//     content =
//         text_area.contentWindow.document.querySelector("[role='textbox']");
//     content.addEventListener("input", (e) => {
//         document.getElementById("content").value = content.innerHTML;
//     });
// };

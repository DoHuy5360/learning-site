CKEDITOR.replace("question-area");
CKEDITOR.plugins.registered["save"] = {
    init: function (editor) {
        var command = editor.addCommand("save", {
            modes: {
                wysiwyg: 1,
                source: 1,
            },
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
        editor.ui.addButton("Save", {
            label: "My Save",
            command: "save",
        });
    },
};

function getTextAreaElement() {
    const text_area = document.querySelector(".cke_wysiwyg_frame.cke_reset");
    const content =
        text_area.contentWindow.document.querySelector("[role='textbox']");
    return content;
}
const question_form = document.getElementById("create-question-form");
const question_content = document.getElementById("question-content");
document
    .getElementById("send-request-to-store-question")
    .addEventListener("click", (e) => {
        question_content.value = getTextAreaElement().innerHTML;
        tags_input_node.value = list_tags;
        question_form.submit();
    });
// todo: tag
let list_tags = [];
const list_tags_node = document.getElementById("editor-list-tag");
const tags_input_node = document.getElementById("create-question-tag-input");
tags_input_node.addEventListener("keydown", (e) => {
    if (e.code == "Enter") {
        const tag_name = tags_input_node.value;
        const tag_html = createTagNode(tag_name);
        list_tags_node.appendChild(tag_html)
        list_tags.push(tag_name);
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
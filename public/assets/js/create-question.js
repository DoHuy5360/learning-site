CKEDITOR.replace("question-area");
        CKEDITOR.plugins.registered["save"] = {
            init: function(editor) {
                var command = editor.addCommand("save", {
                    modes: {
                        wysiwyg: 1,
                        source: 1
                    },
                    exec: function(editor) {
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
                    command: "save"
                });
            },
        };

        function getTextAreaElement() {
            const text_area = document.querySelector(".cke_wysiwyg_frame.cke_reset");
            const content =
                text_area.contentWindow.document.querySelector("[role='textbox']");
            return content;
        }
        const question_form = document.getElementById('create-question-form')
        const question_content = document.getElementById('question-content')
        document.getElementById('send-request-to-store-question').addEventListener('click', e => {
            question_content.value = getTextAreaElement().innerHTML;
            question_form.submit()
        })
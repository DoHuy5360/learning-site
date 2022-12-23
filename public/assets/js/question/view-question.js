let ConvertStringToHTML = function (str) {
    let parser = new DOMParser();
    let doc = parser.parseFromString(str, "text/html");
    return doc.body;
};
let question_content = document.getElementById("quesVw-ques_question-lv4-wr");
let question_content_converted = ConvertStringToHTML(
    question_content.innerText
);
question_content.innerHTML = question_content_converted.innerHTML;
// ! ----------------------------------------- Reply answer -------------------
let form_message;
const QUESTION_ID = document.getElementById("quesVw-question_id");
const csrf_token = document.querySelector('[name="_token"]');
function setEventForAllReplyAnswerBtn() {
    const all_reply_answer_btn = document.querySelectorAll(
        ".quesVw-answer_comment-btn"
    );
    all_reply_answer_btn.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.stopImmediatePropagation();
            const parent_element_lv2 = e.target.parentNode.parentNode;
            const parent_wrap_have_code =
                e.target.parentNode.parentNode.parentNode.parentNode;
            const answer_code =
                parent_wrap_have_code.getAttribute("data-answer-code");
            const reply_answer = createAnswerComment(
                QUESTION_ID.value,
                answer_code
            );
            if (!form_message) {
                removeDuplicateReplyBox(
                    parent_element_lv2,
                    reply_answer,
                    answer_code
                );
            } else {
                form_message.remove();
                removeDuplicateReplyBox(
                    parent_element_lv2,
                    reply_answer,
                    answer_code
                );
            }
        });
    });
}
//! ---------------------------- remove duplicate reply box function -------------------
function removeDuplicateReplyBox(
    parent_element_lv2,
    reply_answer,
    answer_code
) {
    parent_element_lv2.insertAdjacentHTML("beforeend", reply_answer);
    const close_reply = document.querySelector(".quesVw-comment_form-close");
    close_reply.addEventListener("click", (e) => {
        e.target.parentNode.parentNode.remove();
    });
    form_message = document.querySelector(".quesVw-comment_form-wr");
    form_message.addEventListener("submit", (e) => {
        e.preventDefault();
        const data_form = new FormData(form_message);
        const reply_obj = new AJAX();
        reply_obj.createAjax(
            (_method = "POST"),
            (_url = "/reply-answer"),
            (_form = data_form),
            (response) => {
                const reply_data = response.reply_information;
                reply_obj.insertResponseToNodeData(
                    (_data_name = "data-answer-code"),
                    (_data_value = answer_code),
                    (_response = reply_data),
                    (_html_content = createReply),
                    (_position = "beforeend")
                );
                setEventForAllReplyAnswerBtn();
            }
        );
    });
}
setEventForAllReplyAnswerBtn();
function createAnswerComment(_question_id, _reply_for) {
    // todo : reply request form injection
    // todo : -> avoid render multiple HTML elements
    return `
    <form action="" class="quesVw-comment_form-wr" method="post">
        <input type="hidden" name="_token" value="${csrf_token.value}">
        <input type="hidden" name="question_id" value="${_question_id}">
        <input type="hidden" name="reply_for" value="${_reply_for}">
        <textarea name="content" class="quesVw-comment_field-write" cols="30" rows="10" placeholder="Ghi gi do" required></textarea>
        <div id="quesVw-option_form-btn-wrap">
            <button class="quesVw-comment_form-close" type="button">Close</button>
            <button class="quesVw-btn-send-form" type="submit">Send</button>
        </div>
    </form>
    `;
}

//! ---------------------------- create answer box then display answer -------------------
const question_answer_form = document.getElementById("quesVw-answer_form-wr");
const answer_content = document.getElementById("quesVw-answer_field-write");
const list_answer = document.getElementById("quesVw-ans_info-right-wr");
question_answer_form.addEventListener("submit", (e) => {
    e.preventDefault();
    const form_data = new FormData(question_answer_form);
    const answer_obj = new AJAX();
    answer_obj.createAjax(
        (_method = "POST"),
        (_url = "/question-comment"),
        (_form = form_data),
        (response) => {
            const answer_info = response.data_answer;
            const answer_html = createAnswer.call(
                answer_info,
                answer_content.value
            );
            list_answer.insertAdjacentHTML("afterbegin", answer_html);
            setEventForAllReplyAnswerBtn();
        }
    );
});
//! ---------------------------- create comment box then display answer -------------------
const question_comment_form = document.getElementById("quesVw-comment_form-wr");
const comment_content = document.getElementById("quesVw-comment_field-write");
const list_comment = document.getElementById("quesVw-reply-list");
question_comment_form.addEventListener("submit", (e) => {
    e.preventDefault();
    const form_data = new FormData(question_comment_form);
    const comment_obj = new AJAX();
    comment_obj.createAjax(
        (_method = "POST"),
        (_url = "/reply-answer"),
        (_form = form_data),
        (response) => {
            const comment_info = response.reply_information;
            const comment_html = createReply.call(comment_info);
            list_comment.insertAdjacentHTML("beforeend", comment_html);
            setEventForAllReplyAnswerBtn();
        }
    );
});

function createAnswer(_answer) {
    return `
    <div class="quesVw-ans_ans_field-top-wr">
        <div class="quesVw-ans_wrap-top-wr">
            <div class="quesVw-ans_element-top-wr">
                <div class="quesVw-ans_text-left-wr">
                    <div class="quesVw-ans_index-lv1-wr">
                        <div class="group__index">
                            <ion-icon name="time-outline"></ion-icon>
                            <span>${this.created_at}</span>
                        </div>
                    </div>
                    <div id="quesVw-ques_question-lv4-wr">
                        <p>${_answer}</p>
                    </div>
                </div>
                <div class="quesVw-ans_author-right-wr">
                    <div id="quesVw-aut_info-lv1-wr">
                        <img src="${
                            window.location.origin + this.avatar
                        }" alt="" />
                        <div id="quesVw-auth_info-right-wr">
                            <a href="" id="quesVw-aut_name-top" class="underline__none">${
                                this.name
                            }</a>
                            <span id="quesVw-aut_email-bottom">${
                                this.email
                            }</span>
                        </div>
                    </div>
                    <div class="author__interact--wr">
                        <div class="author__infor--wr">
                            <div class="group__index">
                                <ion-icon name="star-outline"></ion-icon>
                                <span>453</span>
                            </div>
                            <div class="group__index">
                                <ion-icon name="person-add-outline"></ion-icon>
                                <span>453</span>
                            </div>
                            <div class="group__index">
                                <ion-icon name="help-outline"></ion-icon>
                                <span>453</span>
                            </div>
                            <div class="group__index">
                                <ion-icon name="paper-plane-outline"></ion-icon>
                                <span>453</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    `;
}
// ! ------------------ display answer and reply message -----------------------------
const display_reply = new AJAX();
display_reply.createAjax(
    (_method = "GET"),
    (_url = `/reply-answer/${QUESTION_ID.value}`),
    (_form = undefined),
    (response) => {
        response.all_reply.forEach((reply) => {
            display_reply.insertResponseToNodeData(
                (_data_name = "data-answer-code"),
                (_data_value = reply.reply_for),
                (_response = reply),
                (_html_content = createReply),
                (_position = "beforeend")
            );
            setEventForAllReplyAnswerBtn();
        });
    }
);
function createReply() {
    // todo : reply answer html code
    return `
    <div class="quesVw-ans_text-left-wr for_reply" data-answer-code="${
        this.reply_code
    }">
        <div class="quesVw-ans_detail-top-wr">
            <div class="reply__text--left">
                <div>
                    <span>${this.content}</span>
                    <span class="reply__created--at">${this.created_at}</span>
                </div>
                <div class="quesVw-answer_comment_field-bellow-wr">
                    <button class="quesVw-answer_comment-btn" type="button">
                        Trả lời bình luận này ...
                    </button>
                </div>
            </div>
            <div class="reply__author--right">
                <img class="author__wrap--avatar" src="${
                    window.location.origin + "/" + this.avatar
                }" alt="" />
                <div class="author__wrap--name">${this.name}</div>
            </div>
        </div>
    </div>

    `;
}
// ! ------------------------------------------- accept answer -------------------------
let accept_temporary;
const all_form_accept = document.querySelectorAll(".questionVw__accept--form");
const all_form_unaccept = document.querySelectorAll(
    ".questionVw__unaccept--form"
);
if (all_form_accept && all_form_unaccept) {
    all_form_accept.forEach((form) => {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const form_data = new FormData(form);
            const accept_obj = new AJAX();
            accept_obj.createAjax(
                (_method = "POST"),
                (_path = "/accept"),
                (_form = form_data),
                (response) => {
                    form.style.display = "none";
                    const unaccept_form = form.parentNode.querySelector(
                        ".questionVw__unaccept--form"
                    );
                    unaccept_form.style.display = "block";
                    if (accept_temporary) {
                        accept_temporary.style.display = "none";
                        accept_temporary.parentNode.querySelector(
                            ".questionVw__accept--form"
                        ).style.display = "block";
                        accept_temporary = unaccept_form;
                    } else {
                        accept_temporary = unaccept_form;
                    }
                }
            );
        });
        if (form.getAttribute("data-accept") == "true") {
            accept_temporary = form.parentNode.querySelector(
                ".questionVw__unaccept--form"
            );
        }
    });
}
all_form_unaccept.forEach((form) => {
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        const form_data = new FormData(form);
        const unaccept_obj = new AJAX();
        unaccept_obj.createAjax(
            (_method = "POST"),
            (_path = "/unaccept"),
            (_form = form_data),
            (response) => {
                form.style.display = "none";
                const accept_form = form.parentNode.querySelector(
                    ".questionVw__accept--form"
                );
                accept_form.style.display = "block";
                accept_temporary = null;
            }
        );
    });
});
// ! ------------------------------------------- follow -------------------------
const follow_form = document.getElementById("postVw-follow-form");
follow_form.addEventListener("submit", (e) => {
    e.preventDefault();
    const follow_post = new AJAX();
    const form_data = new FormData(follow_form);
    follow_post.createAjax(
        (_method = "POST"),
        (_url = "/follow"),
        (_form = form_data),
        (response) => {
            // console.log(response.response);
            ``;
            follow_form.style.display = "none";
            unfollow_form.style.display = "block";
        }
    );
});
const unfollow_form = document.getElementById("postVw-unfollow-form");
unfollow_form.addEventListener("submit", (e) => {
    e.preventDefault();
    const form_data = new FormData(unfollow_form);
    const form_url = unfollow_form.getAttribute("action");
    const unfollow_post = new AJAX();
    unfollow_post.createAjax(
        (_method = "POST"),
        (_url = form_url),
        (_form = form_data),
        (response) => {
            // console.log(response.response);
            unfollow_form.style.display = "none";
            follow_form.style.display = "block";
        }
    );
});
createExplainLabel();

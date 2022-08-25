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
// todo --------------------------------------------
const question_id = document.getElementById("quesVw-question_id");
const csrf_token = document.querySelector('[name="_token"]');
let chat_form_not_exist = true;
function setEventForAllReplyAnswerBtn() {
    const all_reply_answer_btn = document.querySelectorAll(
        ".quesVw-answer_comment-btn"
    );
    all_reply_answer_btn.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.stopImmediatePropagation();
            if (chat_form_not_exist) {
                // todo : parent level 2 where is the place that the 'reply form' will appear inside
                const parent_element_lv2 = e.target.parentNode.parentNode;
                // todo : parent level 4 where is the place that have 'data-answer-code'
                // todo : -> answer's 'data-answer-code' is destination of the 'reply form'
                const parent_element_lv4 =
                    e.target.parentNode.parentNode.parentNode.parentNode;
                const answer_code =
                    parent_element_lv4.getAttribute("data-answer-code");
                // todo : -> for insert message form to the place we need
                const comment_html = createAnswerComment(
                    question_id.value,
                    answer_code
                );
                parent_element_lv2.insertAdjacentHTML(
                    "beforeend",
                    comment_html
                );
                const form_message = document.querySelector(
                        ".quesVw-comment_form-wr"
                    ),
                    close_comment_form = document.querySelector(
                        ".quesVw-comment_form-close"
                    );
                close_comment_form.addEventListener("click", (e) => {
                    form_message.remove();
                    chat_form_not_exist = true;
                });
                form_message.addEventListener("submit", (e) => {
                    e.preventDefault();
                    const data_form = new FormData(form_message);
                    const request_url = form_message.getAttribute("action");
                    createAjax(
                        (_method = "POST"),
                        (_url = request_url),
                        (_form = data_form),
                        (_response_data) => {
                            const reply_data = _response_data.reply_information;
                            const reply_html = createReply.call(reply_data);
                            const target_answer = document.querySelector(
                                `[data-answer-code="${answer_code}"]`
                            );
                            target_answer.insertAdjacentHTML(
                                "beforeend",
                                reply_html
                            );
                        }
                    );
                });
            }
            chat_form_not_exist = false;
        });
    });
}
setEventForAllReplyAnswerBtn();
function createAnswerComment(_question_id, _reply_for) {
    // todo : reply request form injection
    // todo : -> avoid render multiple HTML elements
    return `
    <form action="/reply-answer" class="quesVw-comment_form-wr" method="post">
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

// todo : sending comment request and display comment template
const question_comment_form = document.getElementById("quesVw-chat_form-wr");
const list_answer = document.getElementById("quesVw-ans_info-right-wr");
question_comment_form.addEventListener("submit", (e) => {
    // todo : stop page redirect when form is submitted
    e.preventDefault();
    // todo : create new request form action
    const form_data = new FormData(question_comment_form);
    if (question_comment_form.getAttribute("data-mesage-type") == "answer") {
        createAjax(
            (_method = "POST"),
            (_url = "http://127.0.0.1:8000/question-comment"),
            (_form = form_data),
            (_comment_information) => {
                // todo : _comment_information contain response data from | route('question-comment.store') |
                // todo : -> include comment information and user information who is create this one
                const answer_content = document.getElementById(
                    "quesVw-chat_field-write"
                );
                // todo : get content from textarea for display
                // todo : -> Because render 'HTML texts' from database need 1 more step to display by Javasript convert
                const answer_html = createAnswer.call(
                    _comment_information.data_answer,
                    answer_content.value
                );
                list_answer.insertAdjacentHTML("afterbegin", answer_html);
            }
        );
    } else {
        // todo: send reply question request and display reply template
        createAjax(
            (_method = "POST"),
            (_url = "http://127.0.0.1:8000/reply-answer"),
            (_form = form_data),
            (_reply_information) => {
                const reply_html = createReply.call(
                    _reply_information.reply_information,
                );
                const reply_question_node = document.getElementById('quesVw-reply-list')
                reply_question_node.insertAdjacentHTML("beforeend", reply_html);
            }
        );
    }
});

function createAnswer(_answer) {
    // todo : answer template html code?
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
                        <img src="${this.avatar}" alt="" />
                        <div id="quesVw-auth_info-right-wr">
                            <a href="" id="quesVw-aut_name-top" class="underline__none">${this.name}</a>
                            <span id="quesVw-aut_email-bottom">${this.email}</span>
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
                        <form action="" id="quesVw-aut_follow-form" method="post">
                            <button type="submit">Theo Dõi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    `;
}
// todo : display reply comment message
createAjax(
    (_method = "GET"),
    (_url = `http://127.0.0.1:8000/reply-answer/${question_id.value}`),
    (_form = undefined),
    (_array_reply_answer) => {
        _array_reply_answer.all_reply.forEach((reply) => {
            // todo : select the element which have 'data-answer-code'
            // todo : -> to know where is the place that reply message will arrive
            const target_answer = document.querySelector(
                `[data-answer-code="${reply.reply_for}"]`
            );
            // console.log(reply.reply_for);
            // console.log(target_answer);
            // todo : passing [json||object] data to createReply() function by using call()
            const reply_html = createReply.call(reply);
            target_answer.insertAdjacentHTML("beforeend", reply_html);
            // todo : Because reply comment message arrive later so we need to DOM selector again
            setEventForAllReplyAnswerBtn();
        });
    }
);
function createReply() {
    // todo : reply answer html code
    return `
    <div class="quesVw-ans_text-left-wr for_reply" data-answer-code="${this.reply_code}">
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
                    <img class="author__wrap--avatar" src="${this.avatar}" alt="" />
                    <div class="author__wrap--name">${this.name}</div>
                </div>
        </div>
    </div>

    `;
}
function createAjax(_method, _url, _form, _callback) {
    const ajax = new XMLHttpRequest();
    ajax.open(_method, _url);
    ajax.send(_form);
    ajax.onreadystatechange = function () {
        if (this.status == 200 && this.readyState == 4 && this.responseText) {
            const data_response = JSON.parse(this.responseText);
            _callback(data_response);
        }
    };
}

const first_n_questions = new AJAX();
first_n_questions.createAjax(
    (_method = "GET"),
    (_path = "/question-list/1"),
    (_form = undefined),
    (data_response) => {
        const questions_data = data_response.all_questions;
        first_n_questions.insertResponseToNodeId(
            (_node_id = "question-list-wrap"),
            (_response = questions_data),
            (_createHtml = createQuestionHtml)
        );
        setEventRelativePost();
    }
);
let first_index_questions = document.querySelector(".index__questions");
first_index_questions.classList.add("active");
const list_index_questions = document.querySelectorAll(".index__questions");
list_index_questions.forEach((index) => {
    index.addEventListener("click", (e) => {
        first_index_questions.classList.remove("active");
        index.classList.add("active");
        first_index_questions = index;
        const list_questions = document.getElementById("question-list-wrap");
        list_questions.innerHTML = "";
        const data_question_id = index.getAttribute("data-questions-index");
        const n_questions = new AJAX();
        n_questions.createAjax(
            (_method = "GET"),
            (_path = `/question-list/${data_question_id}`),
            (_form = undefined),
            (data_response) => {
                const questions_data = data_response.all_questions;
                first_n_questions.insertResponseToNodeId(
                    (_node_id = "question-list-wrap"),
                    (_response = questions_data),
                    (_createHtml = createQuestionHtml)
                );
                setEventRelativePost();
            }
        );
    });
});
function createQuestionHtml() {
    const tag_list = document.createElement("div");
    let open_relativePost_btn;
    if (this.tags.length != 0) {
        this.tags.forEach((tag) => {
            const tag_link = document.createElement("a");
            tag_link.setAttribute("href", "#");
            tag_link.textContent = tag.name;
            tag_list.appendChild(tag_link);
        });
        const relativePost_btn_wrap = document.createElement("div");
        const relativePost_btn = document.createElement("button");
        relativePost_btn.setAttribute("class", "question__tags--relativePost");
        relativePost_btn.setAttribute("type", "button");
        relativePost_btn.innerHTML =
        '<ion-icon name="newspaper-outline"></ion-icon>';
        relativePost_btn_wrap.appendChild(relativePost_btn);
        open_relativePost_btn = relativePost_btn_wrap.innerHTML;
    } else {
        open_relativePost_btn = "";
    }
    const answer_avatar_list = document.createElement("div");
    this.answers.forEach(answer => {
        const avatar_answer = document.createElement('img')
        avatar_answer.setAttribute('src',answer.avatar)
        avatar_answer.setAttribute('title',answer.name)
        answer_avatar_list.appendChild(avatar_answer)
    })
    return `
    <div class="card__question--wrap">
        <div class="card__question--leftpart">
            <div class="cardquestion__leftpart--header">
                <ion-icon name="time-outline"></ion-icon>
                <p>${this.created_at}</p>
            </div>
            <div class="cardquestion__leftpart--footer">
                <div class="cardquestion__leftpart--index">
                    <ion-icon name="hand-left-outline"></ion-icon>
                    <span>0</span>
                </div>
                <div class="cardquestion__leftpart--index">
                    <ion-icon name="star-outline"></ion-icon>
                    <span>0</span>
                </div>
                <div class="cardquestion__leftpart--index">
                    <ion-icon name="chatbubbles-outline"></ion-icon>
                    <span>${this.amount_anser}</span>
                </div>
                <div class="cardquestion__leftpart--index">
                    <ion-icon name="eye-outline"></ion-icon>
                    <span>0</span>
                </div>
            </div>
        </div>
        <div class="card__question--rightpart">
            <div class="cardquestion__rightpart--header">
                <div class="cardquestion__author--avatar">
                    <img src="${this.avatar}" alt="" />
                </div>
                <div class="cardquestion__author--name">
                    <a href="/profile/${this.questioner}">${this.name}</a>
                </div>
                <ion-icon name="arrow-undo-outline"></ion-icon>
                <div class="cardquestion__list--helper">
                    ${answer_avatar_list.innerHTML}
                </div>
            </div>
            <div class="cardquestion__rightpart--body">
                <a href="/question/${this.question_id}">${this.title}</a>
            </div>
            <div class="cardquestion__rightpart--footer">
                <div class="cardquestion__list-tag">
                    ${tag_list.innerHTML}
                </div>
                ${open_relativePost_btn}
            </div>
        </div>
    </div>
    `;
}
const question_previous_btn = document.getElementById(
    "question-previous-index"
);
const question_next_btn = document.getElementById("question-next-index");
const question_index_bar = document.getElementById("question-wrap-box-index");
let current_index = 0;
const all_index_element = question_index_bar.children;
question_next_btn.addEventListener("click", (e) => {
    all_index_element[current_index].style.display = "none";
    current_index++;
    all_index_element[current_index].style.display = "flex";
    if (current_index == all_index_element.length - 1) {
        question_next_btn.disabled = true;
        question_previous_btn.disabled = false;
    } else {
        question_next_btn.disabled = false;
        question_previous_btn.disabled = false;
    }
});
question_previous_btn.disabled = true;
question_previous_btn.addEventListener("click", (e) => {
    all_index_element[current_index].style.display = "none";
    current_index--;
    all_index_element[current_index].style.display = "flex";
    if (current_index != 0) {
        question_previous_btn.disabled = false;
        question_next_btn.disabled = false;
    } else {
        question_next_btn.disabled = false;
        question_previous_btn.disabled = true;
    }
});
// todo: --------------
function setEventRelativePost() {
    const questions_node = document.querySelectorAll(
        ".question__tags--relativePost"
    );
    questions_node.forEach((question) => {
        question.addEventListener("click", (e) => {
            const list_tags_wrap = question.parentNode.querySelector(
                ".cardquestion__list-tag"
            );
            const array_tags = [...list_tags_wrap.children];
            let list_tags = [];
            array_tags.forEach((tag) => {
                list_tags.push(tag.innerText);
            });
            const relative_post = new AJAX();
            relative_post.createAjax(
                (_method = "GET"),
                (_path = `/post-relative/${list_tags}`),
                (_form = undefined),
                (data_response) => {
                    console.log(data_response);
                    const questions_data = data_response.all_relative_posts;
                    const relativePost_list_wrap = document.getElementById(
                        "question-rightpart-list-relativepost"
                    );
                    relativePost_list_wrap.innerHTML = "";
                    relative_post.insertResponseToNodeId(
                        (_node_id = "question-rightpart-list-relativepost"),
                        (_response = questions_data),
                        (_createHtml = createRelativePost)
                    );
                }
            );
        });
    });
}
function createRelativePost() {
    return `
    <div class="postrelative__card--wrap">
        <div class="relative__post--header">
            <p>
                <a href="/post/${this.post_id}">${this.title}</a>
            </p>
        </div>
        <div class="relative__post--body">
            <div class="relative__post--index">
                <ion-icon name="star-outline"></ion-icon>
                <span>0</span>
            </div>
            <div class="relative__post--index">
                <ion-icon name="chatbubbles-outline"></ion-icon>
                <span>0</span>
            </div>
            <div class="relative__post--index">
                <ion-icon name="bookmark-outline"></ion-icon>
                <span>0</span>
            </div>
            <div class="relative__post--index">
                <ion-icon name="eye-outline"></ion-icon>
                <span>0</span>
            </div>
        </div>
        <div class="relative__post--footer">
            <p class="relative__post--authorname">
                <a href="">${this.name}</a>
            </p>
        </div>
    </div>
    `;
}

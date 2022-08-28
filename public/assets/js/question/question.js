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
    }
);
const list_index_questions = document.querySelectorAll(".index__questions");
list_index_questions.forEach((index) => {
    index.addEventListener("click", (e) => {
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
            }
        );
    });
});
function createQuestionHtml() {
    const tag_list = document.createElement("div");
    this.tags.forEach((tag) => {
        const tag_link = document.createElement("a");
        tag_link.setAttribute("href", "#");
        tag_link.textContent = tag.name;
        tag_list.appendChild(tag_link);
    });
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
                    <span>0</span>
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
                    <a href="">${this.name}</a>
                </div>
                <ion-icon name="arrow-undo-outline"></ion-icon>
                <div class="cardquestion__list--helper">
                    <img src="./assets/avatar.png" alt="" />
                </div>
            </div>
            <div class="cardquestion__rightpart--body">
                <a href="/question/${this.question_id}">${this.title}</a>
            </div>
            <div class="cardquestion__rightpart--footer">
                <div class="cardquestion__list-tag">
                    ${tag_list.innerHTML}
                </div>
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
        question_previous_btn.disabled = true;
    }
});

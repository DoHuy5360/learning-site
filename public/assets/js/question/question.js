const questions = new AJAX();
questions.createAjax(
    (_method = "GET"),
    (_path = "/question-list"),
    (_form = undefined),
    (response_data) => {
        const questions_data = response_data.all_questions;
        questions.insertResponseToNodeId(
            (_node_id = "question-list-wrap"),
            (_response = questions_data),
            (_createHtml = createQuestionHtml)
        );
    }
);
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

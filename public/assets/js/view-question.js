let ConvertStringToHTML = function (str) {
    let parser = new DOMParser();
    let doc = parser.parseFromString(str, "text/html");
    return doc.body;
};
let question_content = document.getElementById("quesVw-ques_question-lv4-wr");
let question_content_converted = ConvertStringToHTML(question_content.innerText);
question_content.innerHTML = question_content_converted.innerHTML;
// todo --------------------------------------------

let question_comment_form = document.getElementById('quesVw-chat_form-wr');
const list_answer = document.getElementById('quesVw-ans_info-right-wr')
question_comment_form.addEventListener('submit', e=>{
    e.preventDefault()
    const ajax = new XMLHttpRequest();
    const form_data = new FormData(question_comment_form)
    ajax.open('POST', question_comment_form.getAttribute('action'))
    ajax.send(form_data)
    ajax.onreadystatechange = function(){
        if (this.status == 200 && this.readyState == 4 && this.responseText){
            const data_response = JSON.parse(this.responseText)
            const answer_content = document.getElementById('quesVw-chat_field-write');
            // const answer_data = Object.assign({}, data_response.user, data_response.answer)
            const answer_html = createAnswer.call(data_response.data_answer, answer_content.value)
            list_answer.insertAdjacentHTML('afterbegin', answer_html)
        }
    }
})

function createAnswer(_answer){
    return `
    <div class="quesVw-ans_ans_field-top-wr">
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
        <div id="quesVw-ques_author-right-wr">
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
    
    `
}
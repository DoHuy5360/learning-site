let ConvertStringToHTML = function (str) {
    let parser = new DOMParser();
    let doc = parser.parseFromString(str, "text/html");
    return doc.body;
};
let question_content = document.getElementById("quesVw-ques_question-lv4-wr");
let question_content_converted = ConvertStringToHTML(question_content.innerText);
question_content.innerHTML = question_content_converted.innerHTML;
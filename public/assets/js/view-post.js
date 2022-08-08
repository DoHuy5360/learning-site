
let ConvertStringToHTML = function (str) {
    let parser = new DOMParser();
    let doc = parser.parseFromString(str, "text/html");
    return doc.body;
};
let post_content = document.getElementById("post-view-main-content-post");
let post_content_converted = ConvertStringToHTML(post_content.innerText);
post_content.innerHTML = post_content_converted.innerHTML;
// todo --------------------------------------------------- ajax
let comment_btn = document.getElementById("post-view-submit-comment-btn");
let comment_frame = document.getElementById("post-view-comment-frame");
let comment_form = document.getElementById("post-view-user-comment-field");
let commnent_area = document.getElementById("postview-commnent-area");
comment_form.addEventListener("submit", (e) => {
    comment_btn.disabled = true;
    e.preventDefault();
    let ajax = new XMLHttpRequest();
    ajax.open("POST", comment_form.getAttribute("action"), true);
    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // let data = JSON.parse(this.responseText);
            // alert(data.status + " - " + data.message)
            commnent_area.value = "";
            comment_btn.disabled = false;
        }
        if (this.status == 500) {
            // alert(this.responseText)
            alert("Phát ngôn thất bại");
        }
    };
    let form_data = new FormData(comment_form);
    ajax.send(form_data);
    comment_frame.contentWindow.location.reload();
    updateFrameHeight();
    return false;
});

function updateFrameHeight() {
    setTimeout(() => {
        let get_content_height =
            comment_frame.contentWindow.document.getElementById(
                "post-view-all-comment-list"
            );
        const content_height = get_content_height.offsetHeight + 100;
        comment_frame.style.height = `${content_height}px`;
    }, 1000);
}
updateFrameHeight();
let ConvertStringToHTML = function (str) {
    let parser = new DOMParser();
    let doc = parser.parseFromString(str, "text/html");
    return doc.body;
};
let post_content = document.getElementById("post-view-main-content-post");
let post_content_converted = ConvertStringToHTML(post_content.innerText);
post_content.innerHTML = post_content_converted.innerHTML;

// todo --------------------------------------------------- check element is exist in viewport
const list_title_wrap = document.getElementById("post-view-menu-element-list");
const select_all_titles = document.querySelectorAll(
    "#post-view-main-content h2"
);
for (var i = 0; i < select_all_titles.length; i++) {
    const title = select_all_titles[i];
    const h2_id = `${title.nodeName}-${i}`;
    title.setAttribute("id", h2_id);
    // title.setAttribute("class", "title__active")
    const title_element = `
        <p>
            <a href="#${h2_id}">${title.outerText}</a>
        </p>
    `;
    list_title_wrap.insertAdjacentHTML("beforeend", title_element);
}
function checkElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <=
            (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <=
            (window.innerWidth || document.documentElement.clientWidth)
    );
}
const hidden_avatar = document.getElementById("post-view-hidden-avatar");
document.addEventListener(
    "scroll",
    (e) => {
        select_all_titles.forEach((title) => {
            const is_in_viewport = checkElementInViewport(title);
            const title_link = document.querySelector(`[href="#${title.id}"]`);
            if (is_in_viewport) {
                title_link.setAttribute("class", "title__active");
            } else {
                title_link.removeAttribute("class", "title__active");
            }
        });
        if (
            document.body.scrollTop > 400 ||
            document.documentElement.scrollTop > 400
        ) {
            hidden_avatar.style.opacity = "1";
        } else {
            hidden_avatar.style.opacity = "0";
        }
    },
    // { passive: true }
);
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

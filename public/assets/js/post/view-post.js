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
    }
    // { passive: true }
);
// ! ------------------------------ Hiển thị bình luận mới tạo ----------------------------------
let comment_btn = document.getElementById("post-view-submit-comment-btn");
let comment_frame = document.getElementById("post-view-comment-frame");
let comment_form = document.getElementById("post-view-user-comment-field");
let commnent_area = document.getElementById("postview-commnent-area");
comment_form.addEventListener("submit", (e) => {
    comment_btn.disabled = true;
    e.preventDefault();
    let form_data = new FormData(comment_form);
    const comment_box = new AJAX();
    comment_box.createAjax(
        (_method = "POST"),
        (_url = "/post-comment"), //! store comment
        (_form = form_data),
        (response) => {
            commnent_area.value = "";
            comment_btn.disabled = false;
            const relatest_comment = response.relatest_comment[0];
            comment_box.insertResponseToNodeData(
                (_data_name = "data-post-id"),
                (_data_value = post_id),
                (_response = relatest_comment),
                (_html_content = createCommentHtml),
                (_position = "afterbegin")
            );
        }
    );
    comment_frame.contentWindow.location.reload();
    updateFrameHeight();
    return false;
});

// ! ------------------------------ Hiển thị bình luận ----------------------------------
const first_n_comments = new AJAX();
const list_comment_wrap = document.getElementById("postVw-comment-list");
const post_id = list_comment_wrap.getAttribute("data-post-id");
first_n_comments.createAjax(
    (_method = "GET"),
    (_path = `/post-comment/${post_id}/1`),
    (_form = undefined),
    (data_response) => {
        // console.log(data_response);
        const comments_data = data_response.relative_comments;
        first_n_comments.insertResponseToNodeId(
            (_node_id = "postVw-comment-list"),
            (_response = comments_data),
            (_createHtml = createCommentHtml)
        );
        // setBookmarkEvent();
        setReplyComment();
        createReplyBox();
        createExplainLabel();
    }
);
const all_comments_index = document.querySelectorAll(".index__questions");
all_comments_index.forEach((index) => {
    index.addEventListener("click", (e) => {
        const index_value = index.getAttribute("data-questions-index");
        console.log(index_value);
        list_comment_wrap.innerHTML = "";
        const n_comments = new AJAX();
        n_comments.createAjax(
            (_method = "GET"),
            (_path = `/post-comment/${post_id}/${index_value}`),
            (_form = undefined),
            (data_response) => {
                // console.log(data_response);
                const comments_data = data_response.relative_comments;
                n_comments.insertResponseToNodeId(
                    (_node_id = "postVw-comment-list"),
                    (_response = comments_data),
                    (_createHtml = createCommentHtml)
                );
                // setBookmarkEvent();
                setReplyComment();
                createReplyBox();
                createExplainLabel();
            }
        );
    });
});
function createCommentHtml() {
    return `
        <div class="postview__card--comment" data-comment-id="${this.comment_code}">
            <div class="postview__card--user-header">
                <img src="${this.avatar}" id="postview-card-comment-user-avatar" alt="" />
                <div class="projectview-card-comment-user-info">
                    <div class="postview__cardcomment--user-infor-header">
                        <a href="/profile/${this.author_id}" class="postVw__author--name">${this.name}</a>
                        <div class="postview__cardcomment--user-icon-list">
                            <img src="https://bit.ly/3pbRb8m" alt="" />
                            <img src="https://bit.ly/3pbRb8m" alt="" />
                            <img src="https://bit.ly/3pbRb8m" alt="" />
                            </div>
                            </div>
                            <div class="postview__cardcomment--user-infor-footer">
                                <div class="postview__cardcomment--user-commenttime">
                            ${this.created_at}
                        </div>
                    </div>
                </div>
            </div>
            <div class="postview__card--user-body">
            ${this.content}
            </div>
            <div class="postview__card--user-footer">
                <p class="postview_reply_comment">Tra loi</p>
                <p>Chia se</p>
                <p>
                <ion-icon name="alert-circle-outline"></ion-icon>
                </p>
            </div>
        </div>
    `;
}

// ! ------------------------------ Hiển thị phản hồi ----------------------------------
function setReplyComment() {
    const reply_comments = new AJAX();
    reply_comments.createAjax(
        (_method = "GET"),
        (_path = `/reply-post/${post_id}`),
        (_form = undefined),
        (response) => {
            const reply_data = response.relative_replies;
            reply_data.forEach((reply) => {
                reply_comments.insertResponseToNodeData(
                    (_data_name = "data-comment-id"),
                    (_data_value = reply.reply_for),
                    (_response = reply),
                    (_html_content = createCommentHtml),
                    (_position = "beforeend")
                );
            });
            createReplyBox();
        }
    );
}
// ! ------------------------------ Tạo hộp phản hồi ----------------------------------
const csrf_token = document.querySelector('[name="_token"]');
function createReplyBox() {
    const all_reply_button = document.querySelectorAll(
        ".postview_reply_comment"
    );
    all_reply_button.forEach((reply_btn) => {
        reply_btn.addEventListener("click", (e) => {
            e.stopImmediatePropagation();
            let other_reply_box = document.querySelector(
                ".postVw__reply--close"
            );
            if (other_reply_box) {
                other_reply_box.parentNode.parentNode.remove();
            }
            const comment_frame_lv1 = e.target.parentNode;
            const comment_frame_lv2 = comment_frame_lv1.parentNode;
            const reply_for = comment_frame_lv2.getAttribute("data-comment-id");
            const reply_box = `
                <form action="/reply-post" class="postVw__reply--form" method="POST">
                    <input name="post_id" type="hidden" value="${post_id}">
                    <input name="_token" type="hidden" value="${csrf_token.value}"> 
                    <input name="reply_for" type="hidden" value="${reply_for}">
                        <textarea name="reply_content" id="" class="reply__box--input" cols="30" rows="10"></textarea>
                        <div class="postVw__reply--option">
                            <button class="postVw__reply--close" type="button">Đóng</button>
                            <button class="postVw__reply--btn" type="submit">Bình luận</button>
                        </div>
                        
                </form>
            `;
            comment_frame_lv1.insertAdjacentHTML("afterend", reply_box);
            other_reply_box = document.querySelector(".postVw__reply--close");
            other_reply_box.addEventListener("click", (e) => {
                e.target.parentNode.parentNode.remove();
            });
            // ! ------------------------------ Hiển thị phản hồi mới nhất ----------------------------------
            const reply_form = document.querySelector(".postVw__reply--form");
            reply_form.addEventListener("submit", (e) => {
                e.preventDefault();
                const form_data = new FormData(reply_form);
                const reply_relatest = new AJAX();
                reply_relatest.createAjax(
                    (_method = "POST"),
                    (_path = "/reply-post"),
                    (_form = form_data),
                    (response) => {
                        const reply_data = response.relatest_reply[0];
                        reply_relatest.insertResponseToNodeData(
                            (_data_name = "data-comment-id"),
                            (_data_value = reply_for),
                            (_response = reply_data),
                            (_html_content = createCommentHtml),
                            (_position = "beforeend")
                        );
                        createReplyBox();
                    }
                );
            });
        });
    });
}
// todo: ------------------------------------------- follow -------------------------
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
// todo----------------------------- bookmark -----------------------------------
function setBookmarkEvent() {
    const bookmark_post = new AJAX();
    const bookmark_forms = document.querySelectorAll(".postPs__bookmark--form");
    bookmark_forms.forEach((form) => {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const form_data = new FormData(form);
            bookmark_post.createAjax(
                (_method = "POST"),
                (_path = "/bookmark"),
                (_form = form_data),
                (response) => {
                    // console.log(response.status);
                    form.style.display = "none";
                    const unfollow_form = form.parentNode.querySelector(
                        ".postPs__unbookmark--form"
                    );
                    unfollow_form.style.display = "block";
                }
            );
        });
    });

    const unbookmark_post = new AJAX();
    const unbookmark_form = document.querySelectorAll(
        ".postPs__unbookmark--form"
    );
    unbookmark_form.forEach((form) => {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const post_id = form.getAttribute("data-bookmark-id");
            const unbookmark_form_data = new FormData(form);
            unbookmark_post.createAjax(
                (_method = "POST"),
                (_path = `/bookmark/${post_id}`),
                (_form = unbookmark_form_data),
                (response) => {
                    // console.log(response.status);
                    form.style.display = "none";
                    const follow_form = form.parentNode.querySelector(
                        ".postPs__bookmark--form"
                    );
                    follow_form.style.display = "block";
                }
            );
        });
    });
}
setBookmarkEvent();

let post_id_of_comment = document.getElementById("post-id-of-comment");
let ajax = new XMLHttpRequest();
ajax.open(
    "GET",
    `http://127.0.0.1:8000/reply-post/${post_id_of_comment.value}`,
    true
);
ajax.send();

ajax.onreadystatechange = function () {
    let data;
    if (ajax.readyState == 4 && ajax.status == 200 && ajax.responseText) {
        data = JSON.parse(this.responseText);
        const list_comment = data.reply_information;
        list_comment.forEach((comment) => {
            const {
                reply_code,
                reply_for,
                avatar,
                name,
                created_at,
                reply_content,
            } = comment;
            const new_comment = createComment(
                reply_code,
                avatar,
                name,
                created_at,
                reply_content
            );
            const target_comment = document.querySelector(
                `[data-comment-id="${reply_for}"]`
            );
            target_comment.insertAdjacentHTML("beforeend", new_comment);
        });
    }
    let csrf_token = data.csrf;
    addEventReply(post_id_of_comment, csrf_token);
};
function createComment(
    _data_id,
    _user_avatar,
    _user_name,
    _created_at,
    _comment_content
) {
    return `
<div class="postview__card--comment" data-comment-id="${_data_id}">
    <div class="postview__card--user-header">
        <img src="${_user_avatar}" id="postview-card-comment-user-avatar" alt="" />
        <div class="projectview-card-comment-user-info">
            <div class="postview__cardcomment--user-infor-header">
                <a href="">${_user_name}</a>
                <div class="postview__cardcomment--user-icon-list">
                    <img src="./assets/avatar.png" alt="" />
                    <img src="./assets/avatar.png" alt="" />
                    <img src="./assets/avatar.png" alt="" />
                    </div>
                    </div>
                    <div class="postview__cardcomment--user-infor-footer">
                        <div class="postview__cardcomment--user-commenttime">
                    ${_created_at}
                </div>
            </div>
        </div>
    </div>
    <div class="postview__card--user-body">
    ${_comment_content}
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
function addEventReply(_post_id, _csrf_token) {
    const all_reply_button = document.querySelectorAll(
        ".postview_reply_comment"
    );
    all_reply_button.forEach((reply_btn) => {
        reply_btn.addEventListener("click", (selected_btn) => {
            const comment_frame = selected_btn.target.parentNode.parentNode;
            const reply_for = comment_frame.getAttribute("data-comment-id")
            const reply_box = `
                <form action="/reply-post" method="POST">
                    <input name="post_id" type="hidden" value="${_post_id.value}">
                    <input name="_token" type="hidden" value="${_csrf_token}">
                    <input name="reply_for" type="hidden" value="${reply_for}">
                        <textarea name="reply_content" id="" class="reply__box--input" cols="30" rows="10"></textarea>
                        <button type="submit">Bình luận</button>
                </form>
            `
            selected_btn.stopImmediatePropagation();
            comment_frame.insertAdjacentHTML("beforeend",reply_box);
        });
    });
}
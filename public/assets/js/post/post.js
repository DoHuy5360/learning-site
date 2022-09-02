// todo ---------------------------- Create posts --------------------------
const first_n_posts = new AJAX();
first_n_posts.createAjax(
    (_method = "GET"),
    (_path = "/post-list/1"),
    (_form = undefined),
    (data_response) => {
        // console.log(data_response);
        const posts_data = data_response.all_posts;
        first_n_posts.insertResponseToNodeId(
            (_node_id = "post-list-wrap"),
            (_response = posts_data),
            (_createHtml = createPostHtml)
        );
        setBookmarkEvent();
        createExplainLabel();
    }
);
let first_index_posts = document.querySelector(".index__questions");
first_index_posts.classList.add("active");
const list_index_posts = document.querySelectorAll(".index__questions");
list_index_posts.forEach((index) => {
    index.addEventListener("click", (e) => {
        first_index_posts.classList.remove("active");
        index.classList.add("active");
        first_index_posts = index;
        const list_posts = document.getElementById("post-list-wrap");
        list_posts.innerHTML = "";
        const data_post_id = index.getAttribute("data-questions-index");
        const n_posts = new AJAX();
        n_posts.createAjax(
            (_method = "GET"),
            (_path = `/post-list/${data_post_id}`),
            (_form = undefined),
            (data_response) => {
                const posts_data = data_response.all_posts;
                n_posts.insertResponseToNodeId(
                    (_node_id = "post-list-wrap"),
                    (_response = posts_data),
                    (_createHtml = createPostHtml)
                );
                setBookmarkEvent();
                createExplainLabel();
            }
        );
    });
});
function createPostHtml() {
    let bookmark_html;
    if (this.is_login) {
        bookmark_html = `
            <div class="postPs__bookmark--field">
                <form class="postPs__bookmark--form" style="display: ${
                    !this.bookmarked.length ? "block" : "none"
                };" data-explain-label="Nhấp chuột để lưu lại" method="POST">
                    <input type="hidden" name="content_id" value="${
                        this.post_id
                    }">
                    <input type="hidden" name="_token" value="${this.csrf}">
                    <input type="hidden" name="type" value="post">
                    <button class="postPs__bookmark--btn" type="submit">
                        <ion-icon name="bookmark-outline"></ion-icon>
                    </button>
                </form>
                <form class="postPs__unbookmark--form" style="display: ${
                    this.bookmarked.length ? "block" : "none"
                };" data-bookmark-id="${this.post_id}"
                    data-explain-label="Nhấp chuột để bỏ lưu" method="POST">
                    <input type="hidden" name="_token" value="${this.csrf}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="postPs__unbookmark--btn" type="submit">
                        <ion-icon name="bookmark"></ion-icon>
                    </button>
                </form>
            </div>
        `;
    }
    let wrap_tags;
    if (this.tags.length != 0) {
        wrap_tags = document.createElement("div");
        this.tags.forEach((tag) => {
            const tag_html = document.createElement("a");
            tag_html.setAttribute("class", "post__card--tag");
            tag_html.setAttribute("href", `/tag/${tag.id}`);
            tag_html.textContent = tag.name;
            wrap_tags.appendChild(tag_html);
        });
    } else {
        wrap_tags = "";
    }
    return `
    <div class="post__card--wrap">
        <div class="post__card--useravatar">
            <img src="${this.avatar}" alt="" />
        </div>
        <div class="post__card--wrapcontent">
            <div class="post__card--header">
                <a href="/profile/${this.author_id}" class="post__card--username"> ${this.name} </a>
                <div class="post__created--time">${this.created_at}</div>
                <div class="post-reading-time"><span>Đọc trong </span>${this.time}</div>
                <ion-icon name="link-outline"></ion-icon>
                ${bookmark_html}
            </div>
            <div class="post__card--body">
                <h2 class="post__card--title">
                    <a href="/post/${this.post_id}">${this.title}</a>
                </h2>
            </div>
            <div class="post__card--footer">${wrap_tags.innerHTML}</div>
        </div>
    </div>
    `;
}
// todo ------------------------------ Bookmark ----------------------------
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
// *-------------------------------- End bookmark --------------------------
createExplainLabel();

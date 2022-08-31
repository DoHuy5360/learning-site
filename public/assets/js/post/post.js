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
                console.log(response.status);
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
const unbookmark_form = document.querySelectorAll(".postPs__unbookmark--form");
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
                console.log(response.status);
                form.style.display = "none";
                const follow_form = form.parentNode.querySelector(
                    ".postPs__bookmark--form"
                );
                follow_form.style.display = "block";
            }
        );
    });
});

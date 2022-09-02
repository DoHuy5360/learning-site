const list_series = document.querySelectorAll(".profileVw__series--title");
let base_series_heigh = 40;
list_series.forEach((series) => {
    series.addEventListener("click", (e) => {
        const wrap_series = series.parentNode;
        const list_posts = wrap_series.querySelector(
            ".profileVw__series--posts"
        );
        const posts_height = list_posts.getBoundingClientRect().height;
        if (wrap_series.getAttribute("triger") != "true") {
            wrap_series.style = `
                height: ${posts_height + base_series_heigh}px;
                `;
            wrap_series.setAttribute("triger", "true");
        } else {
            wrap_series.style = `
                height: ${base_series_heigh}px;
            `;
            wrap_series.setAttribute("triger", "false");
        }
    });
});

// todo: Create a big letter
const big_letter = document.getElementById("tagVw-big-letters");
let paragraph = document.getElementById("tagVw-paragraph");
let paragraph_to_array = paragraph.innerText.split("");
const first_letter_paragraph = paragraph_to_array.shift();
paragraph.innerText = paragraph_to_array.join("", "");
big_letter.innerText = first_letter_paragraph;
// todo: Explain paragraph
const wrap_header = document.getElementById("tagVw-header-wrap");
const full_paragraph = document.getElementById('tagVw-tag-description')
let paragraph_unactive = true;
full_paragraph.addEventListener("click", (e) => {
    const paragraph_height = full_paragraph.getClientRects()[0].height;
    if (paragraph_unactive && paragraph_height > 70) {
        wrap_header.style = `
            overflow: visible;
            height: ${paragraph_height}px;
        `;
        paragraph_unactive = false;
    } else {
        wrap_header.style = `
            overflow: hidden;
            height: 70px;
        `;
        paragraph_unactive = true;
    }
});
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

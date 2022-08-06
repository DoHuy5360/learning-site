let ConvertStringToHTML = function(str) {
    let parser = new DOMParser();
    let doc = parser.parseFromString(str, 'text/html');
    return doc.body;
};
let post_content = document.getElementById('post-view-main-content-post');
let post_content_converted = ConvertStringToHTML(post_content.innerText)
post_content.innerHTML = post_content_converted.innerHTML
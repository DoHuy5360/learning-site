function setCopyUrl() {
    const copied_label = document.createElement("div");
    copied_label.setAttribute("class", "copy__alert");
    copied_label.textContent = "Đã sao chép";
    const all_link_url = document.querySelectorAll("[data-url]");
    all_link_url.forEach((node) => {
        node.addEventListener("click", (link) => {
            const url = node.getAttribute("data-url");
            navigator.clipboard.writeText(url);
            node.appendChild(copied_label);
            setTimeout(()=>{
                copied_label.remove()
            },1000)
        });
    });
}
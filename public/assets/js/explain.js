function createExplainLabel() {
    const objects_explain = document.querySelectorAll("[data-explain-label]");
    objects_explain.forEach((obj) => {
        obj.addEventListener("mouseover", (e) => {
            const is_exist_explain = obj.querySelector(".explain__box");
            if (!is_exist_explain) {
                const explain_content = obj.getAttribute("data-explain-label");
                const explain_label = `
                <div class="explain__box">
                    <div class="explain__content">${explain_content}</div>
                </div>
            `;
                obj.insertAdjacentHTML("afterbegin", explain_label);
            }
        });
        obj.addEventListener("mouseleave", (e) => {
            const explain_label = obj.querySelector(".explain__box");
            explain_label.style.animation = "disappear 1000ms linear";
            setTimeout(() => {
                obj.removeChild(explain_label);
            }, 1000);
        });
    });
}

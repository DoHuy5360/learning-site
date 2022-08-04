let header_user_avatar = document.getElementById("header-user-avatar"),
    user_management_list_wrap = document.getElementById(
        "user-management-list-wrap"
    );
header_user_avatar.addEventListener("click", (e) => {
    user_management_list_wrap.classList.add("active");
});
window.addEventListener("click", (e) => {
    if (e.target.id != "header-user-avatar") {
        user_management_list_wrap.classList.remove("active");
    }
});

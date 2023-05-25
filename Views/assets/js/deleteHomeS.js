document.addEventListener('DOMContentLoaded', function () {
    let confirm = document.querySelectorAll('.confirm');
    let del = document.querySelectorAll('.delete');

    for (let i = 0; i < del.length; i++) {

        confirm[i].style.display = "none";

        del[i].addEventListener("click", () => {
            confirm[i].style.display = "block";
        });
    };
})
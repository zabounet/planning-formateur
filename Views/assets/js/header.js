document.addEventListener('DOMContentLoaded', function () {
    const burger = document.querySelector('.burger-box');
    const dropnav = document.getElementById('dropnav');

    dropnav.style.display = "none";
    burger.addEventListener('click', function () {
        if (dropnav.style.display === "none") {
            burger.classList.add('active');
            dropnav.classList.add('active-nav')
            dropnav.style.display = "block";
            dropnav.style.opacity = 1;
        }
        else {
            burger.classList.remove('active');
            dropnav.classList.add('active-nav')
            dropnav.style.display = "none";
            dropnav.style.opacity = 0;
        }
    })
})
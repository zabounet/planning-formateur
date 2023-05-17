function spin(){
    setTimeout(function(){
        document.querySelector('.flower-img').classList.add('spin-flower')
    }, 100)
}

document.addEventListener('DOMContentLoaded', function () {
    const burger = document.querySelector('.burger-button');
    const bell = document.querySelector('.bell-button')
    const dropnav = document.getElementById('dropnav');
    const dropmenu = document.getElementById('dropmenu');

    const header = document.querySelector('.header-content');
    const form = document.querySelector('form');
    const part1 = document.getElementById('part1');
    const part2 = document.getElementById('part2');
    const debut = document.querySelector('#debut');
    const fin = document.querySelector('#fin');
    const btnSubmit = document.querySelector('#submit');

    // part2.style.display = "none";
    // btnSubmit.Style.display = "none";

    form.addEventListener("change", function(){
        if(debut.value && fin.value){
            part2.style.display = "block";
            header.classList.add('shadow');
        }
    })
    if(dropmenu){
        dropmenu.style.display = "none";
    }
    dropnav.style.display = "none";
    if(bell){
        bell.addEventListener('click', function () {
            if (dropmenu.style.display === "none") {
                bell.classList.add('active');
                dropmenu.classList.add('active-nav')
                dropmenu.style.display = "block";
                dropmenu.style.opacity = 1;
            }
            else {
                bell.classList.remove('active');
                dropmenu.classList.add('active-nav')
                dropmenu.style.display = "none";
                dropmenu.style.opacity = 0;
            }
        })
    }

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
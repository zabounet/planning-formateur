function spin() {
    setTimeout(function () {
        document.querySelector('.flower-img').classList.add('spin-flower')
    }, 100)
}

document.addEventListener('DOMContentLoaded', function () {
    const burger = document.querySelector('.burger-button');
    const bell = document.querySelector('.bell-button')
    const dropnav = document.getElementById('dropnav');
    const dropmenu = document.getElementById('dropmenu');

    const form = document.querySelector('#advanced');
    const part2 = document.getElementById('part2');

    if (part2) {
        part2.style.display = "none";
    }
    if (form) {
        form.addEventListener("click", function () {
            if (part2.style.display === "none") {
                part2.classList.remove('unactive-nav');
                part2.classList.add('active-nav');
                part2.style.display = "block";
            }
            else {
                part2.classList.remove('active-nav');
                part2.classList.add('unactive-nav')
                setTimeout(function () {
                    part2.style.display = "none";
                }, 450);

            }
        })

    }

    if (dropmenu) {
        dropmenu.style.display = "none";
    }
    dropnav.style.display = "none";
    if (bell) {
        bell.addEventListener('click', function () {
            if (dropmenu.style.display === "none") {
                bell.classList.add('active');
                dropmenu.classList.remove('unactive-nav');
                dropmenu.classList.add('active-nav')
                dropmenu.style.display = "block";
            }
            else {
                bell.classList.remove('active');
                dropmenu.classList.remove('active-nav')
                dropmenu.classList.add('unactive-nav');
                setTimeout(function () {
                    dropmenu.style.display = "none";
                }, 450);
            }
        })
    }

    burger.addEventListener('click', function () {
        if (dropnav.style.display === "none") {
            burger.classList.add('active');
            dropnav.classList.remove('unactive-nav');
            dropnav.classList.add('active-nav')
            dropnav.style.display = "block";
            dropnav.style.opacity = 1;
        }
        else {
            burger.classList.remove('active');
            dropnav.classList.remove('active-nav')
            dropnav.classList.add('unactive-nav');
            setTimeout(function () {
                dropnav.style.display = "none";
                dropnav.style.opacity = 0;
            }, 250);
        }
    })
})
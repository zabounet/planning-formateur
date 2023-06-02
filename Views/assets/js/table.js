document.addEventListener('DOMContentLoaded', function () {
var scrollables = document.getElementsByClassName('myTable');
var main = document.querySelector('main');

Array.from(scrollables).forEach(function(scrollable){
    scrollable.addEventListener("wheel", function (e) {
        if (e.deltaY < 0) {
            scrollable.scrollLeft -= 300;
        } else {
            scrollable.scrollLeft += 300;
        }
        main.style.overflow = "hidden";
    });

    scrollable.addEventListener("mouseleave", function () {
        main.style.overflow = "scroll";
    });
})



let trs = document.querySelectorAll("table tbody tr")
Array.from(trs).forEach(function(tr) {
    
    let node = tr.firstElementChild;
    
    let clone = node.cloneNode(true);
    clone.classList.add("cloneNomFormateur");
    tr.appendChild(clone);
})





})




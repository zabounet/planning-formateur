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
    var node = document.getElementById("nomFormateur");
var clone = node.cloneNode(true);

clone.classList.add("clonNomFormateur");
document.getElementById('listNomFormateur').appendChild(clone);
})




// var node = document.getElementById("nomFormateur");
// var clone = node.cloneNode(true);

// clone.classList.add("clonNomFormateur");
// document.getElementById('listNomFormateur').appendChild(clone);
// console.log("rr")


})




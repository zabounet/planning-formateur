document.addEventListener('DOMContentLoaded', function () {
var scrollables = document.getElementsByClassName('myTable');
var main = document.querySelector('main');

Array.from(scrollables).forEach(function(scrollable){
    scrollable.addEventListener("wheel", function (e) {
        if (e.deltaY < 0) {
            scrollable.scrollLeft -= /*150*/ 300;
        } else {
            scrollable.scrollLeft += /*150*/ 300;
        }
        main.style.overflow = "hidden";
    });

    scrollable.addEventListener("mouseleave", function () {
        main.style.overflow = "auto";
    });
})



// var myTable = document.getElementById('myTable');

// document.addEventListener('wheel', function(event) {
//   if (event.ctrlKey === true) {
//     if (event.deltaY < 0) {
//       myTable.style.fontSize = parseInt(getComputedStyle(myTable).fontSize) - 1 + 'px';
//     } else {
//       myTable.style.fontSize = parseInt(getComputedStyle(myTable).fontSize) + 1 + 'px';
//     }
//     event.preventDefault(); // Empêche le comportement par défaut de défilement de la page
//   }
// }, { passive: false });

})




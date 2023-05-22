
document.addEventListener('DOMContentLoaded', function () {
    const p = document.getElementById("pass")
    const eye = document.getElementById("eye")

    
    function hide() {
        p.setAttribute('type','password')
        eye.src="/planning/Views/assets/image/eye-open.svg";
    }

    function Show(){
        p.setAttribute('type','text');
        eye.src="/planning/Views/assets/image/eye-close.svg";
    }

    var passShow = 0;

    document.getElementById("eye").addEventListener("click" ,function pass() {
        if (passShow == 0){
            passShow = 1;
            Show();
        } else {
            passShow = 0;
            hide();
        }
    });
})
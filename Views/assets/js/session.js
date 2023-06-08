var timeoutInMinutes = 15;
var timeoutInMilliseconds = timeoutInMinutes * 60 * 1000;
var logoutTimer;

function startLogoutTimer() {
    logoutTimer = setTimeout(logoutUser, timeoutInMilliseconds);
}

function resetLogoutTimer() {
    clearTimeout(logoutTimer);
    startLogoutTimer();
}

function logoutUser() {
    alert("Votre session a expiré. Veuillez vous reconnecter.");
    window.location.href = '/planning/public/index.php?p=formateur/logout';
}
document.addEventListener('mousemove', resetLogoutTimer);
document.addEventListener('click', resetLogoutTimer);
document.addEventListener('keydown', resetLogoutTimer);

startLogoutTimer();
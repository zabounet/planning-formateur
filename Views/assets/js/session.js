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
    alert("Your session has timed out. Please log in again.");
    window.location.href = '/planning/public/index.php?p=formateur/logout';
}
document.addEventListener('mousemove', resetLogoutTimer);
document.addEventListener('click', resetLogoutTimer);

startLogoutTimer();
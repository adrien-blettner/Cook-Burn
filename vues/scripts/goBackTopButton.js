// https://www.w3schools.com/howto/howto_js_scroll_to_top.asp

// Quand l'utilisateur scroll on affiche le bouton.
window.onscroll = function() {showButton()};

function showButton() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("goBackTop").style.display = "block";
    } else {
        document.getElementById("goBackTop").style.display = "none";
    }
}

function topFunction() {
    document.body.scrollTop = 0; // Pour safari
    document.documentElement.scrollTop = 0; // Pour chrome, fireforx IE et opera
}
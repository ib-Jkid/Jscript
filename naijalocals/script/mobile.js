
var menuDisplay = false;
var menuDiv = document.getElementsByTagName("ul")[0];
var img = document.getElementById("menuImg");

function displayMenu() {
    if(menuDisplay) {
        img.setAttribute("src","images/logo/mobile-menu.png");
        menuDisplay = false;
        menuDiv.style.display = "none";
        
    }else {
        img.setAttribute("src","images/logo/mobile-close.png");
        menuDisplay = true;
        menuDiv.style.display = "block";
    }
}

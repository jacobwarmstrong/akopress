/*
Adds bootstrap class to navbar links
*/

var menu = document.getElementById('primary-menu');
var subMenu = document.getElementsByClassName('sub-menu');

function addClass(menu) {
    for(i = 0; i < menu.childElementCount; i++){
        menu.children.item(i).firstElementChild.className = 'nav-link';
    }
}

addClass(menu);

var menu = document.getElementById('footer-menu');

addClass(menu);




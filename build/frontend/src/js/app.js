require('../../../bootstrap');

let className = 'scrolled';
let offset = 0;

window.onscroll = function() {

    let top  = window.pageYOffset || document.documentElement.scrollTop;
    if (top > offset) {
        document.body.classList.add(className);
    } else {
        document.body.classList.remove(className);
    }
};

let top  = window.pageYOffset || document.documentElement.scrollTop;
if (top > offset) {
    document.body.classList.add(className);
}
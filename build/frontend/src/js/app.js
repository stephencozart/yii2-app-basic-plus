require('../../../bootstrap');

window.onscroll = function() {
    let className = 'scrolled';
    let offset = 0;
    let top  = window.pageYOffset || document.documentElement.scrollTop;
    if (top > offset) {
        document.body.classList.add(className);
    } else {
        document.body.classList.remove(className);
    }
};
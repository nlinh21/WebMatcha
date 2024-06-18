const header = document.querySelector('header');
function fixedNavbar() {
    header.classList.toggle('scroll', window.pageYOffset > 0)
}
fixedNavbar();
window.addEventListener('scroll', fixedNavbar);

let menu = document.querySelector('#menu-btn');
let userBtn  = document.querySelector('#user-btn');

menu.addEventListener('click', function()
{
    let nav  = document.querySelector('.navbar');
    nav.classList.toggle('active');
})
userBtn.addEventListener('click', function()
{
    let userBox = document.querySelector('.user-box');
    userBox.classList.toggle('active');
})

/* HOME PAGE SLIDER */
"use strict"
const leftArrow = document.querySelector('.left-arrow .bxs-left-arrow'),
        rightArrow = document.querySelector('.right-arrow .bxs-right-arrow'),
        slider = document.querySelector('.slider');
/* SCROLL TO RIGHT */
function scrollRight(){
    if (slider.scrollWidth - slider.clientWidth === slider.scrollLeft) {
            slider.scrollTo({
                left: 0, 
                behavior: "smooth"
            });
    }
    else {
        slider.scrollBy({
            left: window.innerWidth,
            behavior:"smooth"
        })
    }
}
/* SCROLL TO lefft */
function scrollLeft(){
    slider.scrollBy({
        left: -window.innerWidth,
        behavior: "smooth"
    })
}
let timeId = setInterval(scrollRight, 7000);

/* RESET TIME TO SCROLL RIGHT */

function resetTimer() {
    clearInterval(timeId);
    timeId = setInterval(scrollRight, 7000);
}

/* SCROLL EVENT */

slider.addEventListener('click', function(ev){
    if (ev.target === leftArrow) {
        scrollleft();
        resetTimer();
    }
});

slider.addEventListener('click', function(ev){
    if (ev.target === rightArrow) {
        scrollright();
        resetTimer();
    }
});
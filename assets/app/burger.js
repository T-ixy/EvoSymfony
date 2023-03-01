const burger = document.querySelector('.burger');

let isOpen = false;

burger.addEventListener('click', () => {
    if (!isOpen) {
        burger.classList.add('open')
        isOpen = true
    } else {
        burger.classList.remove('open')
        isOpen = false
    }
})
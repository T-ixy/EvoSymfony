const burger = document.querySelector('.burger');
const filter = document.querySelector('.filter');
const btn = document.querySelector('#filter');
const main = document.querySelector('.filter__main')

burger.addEventListener('click',()=>{
    filter.classList.toggle('filter--active')
});

btn.addEventListener('click', ()=>{
    filter.classList.toggle('filter--active')
})

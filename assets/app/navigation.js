const nav = document.querySelector('.navigation');
const content = `<div class="header__center__form navigation__form">
<form name="search" method="get">
				<div class="form">
					<input type="search" id="search_search" name="search[search]" required="required" Placeholder="Trouver une formation" />
					<button type="submit" class="form__button">
						<i class="fa-solid fa-magnifying-glass"></i>
					</button>
				</div>
				</form>
<a class="button button--yellow filter__nav" href="#filter-target" id="filter">Catégories</a>

</div>`;
const elem = document.createElement('div');
const menu = nav.querySelector('.navigation__menus');
const fixed = document.querySelector('.filter__fixed');
const filNav = document.querySelector('#filter');

const navfixed = function () {
    if (document.documentElement.scrollTop > 450) {
        elem.innerHTML=content;
        nav.insertBefore(elem, menu);
        nav.classList.add('navigation--fixed');

    } else {
        nav.classList.remove('navigation--fixed');
        nav.removeChild(elem)
    }
}

window.addEventListener('scroll', navfixed)




const observer = new ResizeObserver(entries => {
    let box = entries[0].target

    if (entries[0].contentRect.width < 1080) {
        window.removeEventListener('scroll', navfixed)
    }
})

observer.observe(document.querySelector('.navigation'))
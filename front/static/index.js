/*----------------------------
|    Header - JS
-----------------------------*/
const responsiveMenuBtn = document.querySelector('#responsive-menu-button');
const responsiveMenuLogInOut = document.querySelector('li.responsive__log-in-out');
const responsiveMenu = document.querySelector('#nav-container');
const responsiveMenuStatus = document.querySelector('.responsive__menu');

if (responsiveMenuBtn) {
	responsiveMenuBtn.addEventListener('click', () => {
		responsiveMenuStatus.classList.toggle('open');
		responsiveMenu.style.animation = responsiveMenuStatus.classList.contains('open')
			? 'openMenu 0.5s ease-in-out forwards'
			: 'closeMenu 0.5s ease-in-out forwards';
		if (responsiveMenu.style.display === 'block') {
			setTimeout(() => {
				responsiveMenu.style.display = 'none';
				// responsiveMenuLogInOut.style.display === 'none';
			}, 500);
		} else {
			responsiveMenu.style.display = 'block';
			// responsiveMenuLogInOut.style.display = 'flex';
		}
	});
}

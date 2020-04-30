const navSlide = () => {
	const lines = document.querySelector('.lines');
	const nav = document.querySelector('.nav-links');
	const navLinks = document.querySelectorAll('.nav-links li');


	lines.addEventListener('click',()=>{
		//toggle nav
		nav.classList.toggle('nav-active');
		//animation link

		navLinks.forEach((link ,index) => {
			if (link.style.animation){
				link.style.animation = '';
			}else{
				link.style.animation = 'navLinkFade 0.5s ease forwards ${index / 7 + 1.5}s';
			}
			
		});
	});	
}
navSlide();

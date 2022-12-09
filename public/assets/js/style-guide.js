jQuery(document).ready(function(){
	jQuery('a.cd-nav-trigger').click(function(){
        jQuery('.style-guide').toggleClass('header-activate');
        jQuery('.style-guide').removeClass('header-mobile-Close');
});
});
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
jQuery(document).ready(function(){
jQuery('.accordian-content-wrapper').hide();
jQuery('h4.Accordian-title').click(function(){
	jQuery(this).next().slideToggle();
});
});
jQuery('.cd-main-nav li').click(function(){
    jQuery('header.style-guide').addClass('header-mobile-Close');
});

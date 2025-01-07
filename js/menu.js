document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu-overlay');
    const menuClose = document.querySelector('.menu-close');

    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.add('active');
    });

    menuClose.addEventListener('click', () => {
        mobileMenu.classList.remove('active');
    });
});

document.addEventListener('DOMContentLoaded', function(e) {

    console.log('ouai')
    const menuToggle = document.getElementById('menu-toggle');
    const siteNavigation = document.getElementById('site-navigation');

    menuToggle.addEventListener('click', function() {
        console.log('ouai')
        // On ajoute/supprime la classe "open" sur le bouton et la nav
        menuToggle.classList.toggle('open');
        siteNavigation.classList.toggle('open');
    });
});

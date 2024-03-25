jQuery(document).ready(function($) {
    $('.menu-toggle').click(function() {
        $('.header-open-menu').toggleClass('open'); // Toggle la classe pour afficher ou cacher la copie du header
        var imgSrc = $('.menu-icon').attr('src');

        if(imgSrc === openIcon) {
            $('.menu-icon').attr('src', closeIcon);
        } else {
            $('.menu-icon').attr('src', openIcon);
        }
    });

    $('.close-icon').click(function() {
        $('.header-open-menu').removeClass('open'); // Fermer la copie du header
    })

    // Réinitialiser l'icône lorsque la modale de contact est ouverte
    $('.contact-link').click(function() {
        $('.header-open-menu').removeClass('open'); // Fermer la copie du header
    })

    // Ajouter une classe pour contrôler l'affichage du menu burger
    function toggleMenu() {
        var screenWidth = $(window).width();
        if (screenWidth <= 768) {
            $('.menu-header').show();
        } else {
            $('.menu-header').hide();
        }
    }

    // Exécuter la fonction au chargement de la page et lors du redimensionnement de la fenêtre
    toggleMenu();
    $(window).resize(toggleMenu);
});
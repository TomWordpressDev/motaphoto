 // JavaScript pour le menu burger (jQuery requis)
 jQuery(document).ready(function($) {
    // Définir une variable pour suivre l'état du menu
    var menuOpen = false;

    // Ouvrir ou fermer le menu burger lorsque le bouton est cliqué
    $('.menu-toggle').click(function() {
        if (menuOpen) {
            // Si le menu est ouvert, le fermer
            $('.burger-menu').slideUp();
            menuOpen = false;
        } else {
            // Si le menu est fermé, l'ouvrir
            $('.burger-menu').slideDown();
            menuOpen = true;
        }
    });

    // Ouvrir la modal lorsque le bouton est cliqué
    $('#openModalButton, #openModalLink').click(function(e) {
        e.preventDefault();
        $('#contactModal').fadeIn();
        console.log("La modal est ouverte.");
        // Fermer le menu burger si ouvert
        if (menuOpen) {
            $('.burger-menu').slideUp();
            menuOpen = false;
        }
    });

    // Fermer la modal lorsque l'utilisateur clique en dehors d'elle
    $(document).click(function(event) {
        if ($(event.target).closest('.modal-content').length === 0 && !$(event.target).is('#openModalButton, #openModalLink')) {
            $('#contactModal').fadeOut();
            console.log("La modal est fermée.");
        }
    });
});

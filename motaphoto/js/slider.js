jQuery(document).ready(function($) {
    // Initialisez le carousel dans votre script JavaScript
    var carousel = $('.carousel').slick({
        dots: false,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false // Désactiver les boutons par défaut
    });

    // Récupérer les flèches personnalisées
    var prevArrow = $('.slick-prev');
    var nextArrow = $('.slick-next');

    // Ajouter les événements de clic aux flèches personnalisées
    prevArrow.click(function() {
        carousel.slick('slickPrev');
    });

    nextArrow.click(function() {
        carousel.slick('slickNext');
    });
});
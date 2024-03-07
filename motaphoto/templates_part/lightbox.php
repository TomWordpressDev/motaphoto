<script>
    $(document).ready(function() {
    $('.full-view').fancybox({
        // General Options
        closeExisting: false,   // Close all existing fancybox instances when opening a new one
        loop: true,             // Enable looping through galleries
        gutter: 50,             // Space between slides in pixels
        keyboard: true,         // Enable keyboard navigation
        arrows: true,           // Display navigation arrows
        infobar: true,          // Display information bar
        smallBtn: false,        // Display small close button
        toolbar: true,          // Display toolbar
        buttons: ['thumbs', 'close'], // Customize toolbar buttons

        // Animation Options
        animationEffect: 'fade',        // Transition effect
        animationDuration: 500,         // Transition duration in milliseconds
        transitionEffect: 'fade',       // Transition effect between slides
        transitionDuration: 500,        // Transition duration between slides in milliseconds
        slideClass: 'fancybox-slide',   // Custom CSS class for slides
        baseClass: 'fancybox-container', // Custom CSS class for fancybox container

        // Thumbnail Options
        thumbs: {
            autoStart: true,   // Automatically start thumbnail display
            hideOnClose: true, // Hide thumbnails when closing fancybox
            axis: 'y'          // Thumbnail display direction ('x' for horizontal, 'y' for vertical)
        },

       
        btnTpl: {
            arrowLeft: '<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="{{PREV}}">' +
            '<div class="container-precedentes">'+
                '<img src="<?php echo get_stylesheet_directory_uri() . '/assets/fleche_gauche.png'; ?>" alt="flèche gauche">' +
                '<span class="custom-span">Précédentes</span>' +
            '</div>'+
                '</button>',
            arrowRight: '<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}">' +
            '<div class="container-suivantes">'+
            
                        '<span class="custom-span">Suivantes</span>' +
                   '<img src="<?php echo get_stylesheet_directory_uri() . '/assets/fleche_droite.png'; ?>" alt="flèche droite">' +     
                        '</div>'+
                        '</button>',
        },

        // Image Options
        protect: true,           // Prevent downloading images
        hideScrollbar: false,    // Hide vertical scrollbar
        clickContent: 'close',   // Action to perform on clicking content area ('close' or 'next')

        // Other Options
        autoFocus: true,         // Autofocus on first visible element when opening fancybox
        backFocus: true,         // Restore focus to the trigger element when closing fancybox
        trapFocus: true,         // Prevent tabbing out of fancybox
        touch: {
            vertical: false,     // Allow vertical swipe
            momentum: true       // Enable momentum scrolling
        },
        hash: false              // Enable URL hash navigation
    });
});
</script>
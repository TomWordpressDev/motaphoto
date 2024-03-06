<?php wp_footer(); ?>
<?php include get_template_directory() . '/templates_part/modal-contact.php'; ?>
  <footer class="footer">
        <nav class="footer__nav">   
            <ul>
                <?php    
                // Utilisation d'un menu déroulant simulant un menu burger
                    $menu_items = wp_get_nav_menu_items('footer-menu');
                    if ($menu_items) {
                        foreach ($menu_items as $item) {
                            echo '<li class="menu-item"><a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a></li>';
                        }
                    }
                ?> 
            </ul>
           
        </nav>
    </footer> 
    <script>
    // JavaScript pour le menu burger (jQuery requis)
    jQuery(document).ready(function($) {
        // Ouvrir la modal lorsque le bouton est cliqué
        $('#openModalButton, #openModalLink').click(function(e) {
            e.preventDefault();
            $('#contactModal').fadeIn();
            console.log("La modal est ouverte.");
            // Fermer le menu burger si ouvert
            $('.burger-menu').slideUp();
        });

        // JavaScript pour le menu burger (jQuery requis)
        $('.menu-toggle').click(function() {
            $('.burger-menu').slideToggle();
        });

        // Fermer la modal lorsque l'utilisateur clique en dehors d'elle
        $(document).click(function(event) {
            if ($(event.target).closest('.modal-content').length === 0 && !$(event.target).is('#openModalButton, #openModalLink')) {
                $('#contactModal').fadeOut();
                console.log("La modal est fermée.");
            }
        });

        // JavaScript pour le menu burger (jQuery requis)
        $('.menu-toggle').click(function() {
            $('.burger-menu').slideToggle();
        });
    });
</script>


</body>
</html>
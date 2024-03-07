<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <?php wp_head() ?>
    <title>Motaphoto</title>
   
</head>
<body>
    <header class="header">
        <nav>
            <div class="logo-menu">
                <img class="logo" src="<?php echo get_stylesheet_directory_uri() . '/assets/Logo.png'; ?>" alt="Logo">
            </div>
            <div class="menu-toggle">
                <i class="fas fa-bars menu-icon"></i> <!-- Ajout de la classe menu-icon -->
            </div>
            <ul id="menu-primary-menu" class="primary-menu">
                <?php    
                    // Utilisation d'un menu déroulant simulant un menu burger
                    $menu_items = wp_get_nav_menu_items('primary-menu');
                    if ($menu_items) {
                        foreach ($menu_items as $item) {
                            echo '<li class="menu-item"><a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a></li>';
                        }
                    }
                ?>
                <li class="menu-item"><a id="openModalLink" href="#" class="contact-link">Contact</a></li> <!-- lien qui ouvre la modale  -->
            </ul>
            <div class="burger-menu">
                <?php    
                    // Utilisation d'un menu déroulant simulant un menu burger
                    $menu_items = wp_get_nav_menu_items('primary-menu');
                    if ($menu_items) {
                        echo '<div class="menu-header">';
                        foreach ($menu_items as $item) {
                            echo '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
                        }
                               // Ajout du lien à la modal dans le menu burger
            echo '<a id="openModalLink" href="#" class="contact-link">Contact</a>';
                        echo '</div>';
                    }
                ?>
            </div>
        </nav>
    </header>

    <script>
        // JavaScript pour le menu burger (jQuery requis)
        jQuery(document).ready(function($) {
            $('.menu-toggle').click(function() {
                $('.burger-menu').slideToggle();
                $('.menu-icon').toggleClass('fa-bars fa-times'); // Changer l'icône du menu burger
            });

            // Réinitialiser l'icône lorsque la modale de contact est ouverte
            $('.contact-link').click(function() {
                $('.menu-icon').removeClass('fa-times').addClass('fa-bars');
            });

            // Ajouter une classe pour contrôler l'affichage du menu burger
            function toggleMenu() {
                var screenWidth = $(window).width();
                if (screenWidth <= 768) {
                    $('.burger-menu').hide();
                    $('.menu-header').show();
                } else {
                    $('.burger-menu').show();
                    $('.menu-header').hide();
                }
            }

            // Exécuter la fonction au chargement de la page et lors du redimensionnement de la fenêtre
            toggleMenu();
            $(window).resize(toggleMenu);
        });
    </script>

    <?php wp_footer(); ?>
</body>
</html>

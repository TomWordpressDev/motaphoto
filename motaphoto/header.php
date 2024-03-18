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
    <style>
        .copy-header {
            position: fixed;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-color: #fff; /* Vous pouvez ajuster la couleur de fond selon vos préférences */
            z-index: 9999;
            overflow-y: auto;
            transform: translateX(100%);
            transition: transform 0.8s ease-in-out;
        }

        .copy-header.open {
            transform: translateX(0);
            pointer-events: auto;
        }

        .close-icon {
            position: absolute;
            top: 40px; 
            right: 20px;
            cursor: pointer;
        }
        
    </style>
</head>
<body>
    <header class="header">
        <nav>
            <div class="logo-menu">
                <img class="logo" src="<?php echo get_stylesheet_directory_uri() . '/assets/Logo.png'; ?>" alt="Logo">
            </div>
            <div class="menu-toggle">
                <img class="menu-icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/icon_open.png'; ?>" alt="icon open">
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
           
        </nav>
    </header>

    <!-- Copie du header et du menu burger -->
    <div class="copy-header">
        <span class="close-icon menu-toggle">
            <img class="menu-icon" src="<?php echo get_stylesheet_directory_uri() . '/assets/icon_close.png'; ?>" alt="icon close">
        </span>
        <nav>
            <div class="logo-menu">
                <img class="logo" src="<?php echo get_stylesheet_directory_uri() . '/assets/Logo.png'; ?>" alt="Logo">
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
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('.menu-toggle').click(function() {
            $('.copy-header').toggleClass('open'); // Toggle la classe pour afficher ou cacher la copie du header
            var imgSrc = $('.menu-icon').attr('src');

            if(imgSrc === openIcon) {
                $('.menu-icon').attr('src', closeIcon);
            } else {
                $('.menu-icon').attr('src', openIcon);
            }
        });

        $('.close-icon').click(function() {
            $('.copy-header').removeClass('open'); // Fermer la copie du header
        })

        // Réinitialiser l'icône lorsque la modale de contact est ouverte
        $('.contact-link').click(function() {
            $('.copy-header').removeClass('open'); // Fermer la copie du header
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
</script>


    <?php wp_footer(); ?>
</body>
</html>

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
        /* Styles pour le menu principal */
        .header {
            height: 5rem;
            background: #fff;
            box-shadow: 0px 4px 14px 10px rgba(0, 0, 0, 0.03);
            position: relative;
        }

        #menu-primary-menu {
            display: flex;
            flex-direction: row;
            position: absolute;
            right: 6.19rem;
            gap: 2.81rem;
            list-style: none;
            justify-content: center;
            align-items: center;
            top: 10px;
        }

        #menu-primary-menu a {
            color: #000;
            font-family: "Space Mono";
            font-size: 1rem;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            text-transform: uppercase;
            text-decoration: none;
        }

        /* CSS pour le menu burger */
        .menu-toggle {
            display: none;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 20px;
            cursor: pointer;
        }

        .burger-menu {
            display: none; /* Masquer le menu burger par défaut */
        }

        @media screen and (max-width: 768px) {
            .logo {
                margin-left: -80px; /* Ajustez la valeur selon votre mise en page */
            }

            .menu-toggle {
                display: block; /* Afficher le menu burger lorsque la largeur de l'écran est inférieure à 768px */
            }

            .menu-toggle i {
                font-size: 1.71344rem; /* Ajustez la taille selon vos préférences */
            }

            #menu-primary-menu {
                display: none; /* Masquer le menu principal lorsque la largeur de l'écran est inférieure à 768px */
            }

            .burger-menu {
                display: block; /* Afficher le menu burger lorsque la largeur de l'écran est inférieure à 768px */
                position: absolute;
                top: 60px; /* Ajustez la position verticale selon votre mise en page */
                left: 0;
                background-color: #ffffff;
                width: 100%;
                box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
                z-index: 1;
            }

            .menu-header {
                background: #E00000;
                height: 45.75rem;
                padding-top: 18.19rem;
            }

            .burger-menu a {
                display: block;
                padding: 10px;
                text-decoration: none;
                color: #FFF;
                text-align: center;
                font-family: "Space Mono";
                font-size: 2.75rem;
                font-style: normal;
                font-weight: 400;
                line-height: normal;
                text-transform: uppercase;
                margin-bottom: 1.12rem;
            }

            .burger-menu a:hover {
                background-color: #f1f1f1;
            }

            /*filtres*/
            .filters-container select {
                width: 550px;
                height: 50px;
            }
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
                <i class="fas fa-bars"></i>
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
                <li class="menu-item"><a id="openModalLink" href="#">Contact</a></li> <!-- lien qui ouvre la modale  -->
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
            echo '<a id="openModalLink" href="#">Contact</a>';
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

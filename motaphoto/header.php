<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
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
    <div class="header-open-menu">
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
    <?php wp_footer(); ?>
</body>
</html>

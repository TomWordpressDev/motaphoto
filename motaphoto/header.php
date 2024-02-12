<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
  
    <?php wp_head() ?>
    <title>Motaphoto</title>
</head>
<body>
    <header>
        <nav>    
        
  
        <img class="logo" src=<?php echo get_stylesheet_directory_uri() . '/assets/Logo.png'; ?> >
 
        <?php    
            wp_nav_menu(array(
                'theme_location' => 'Menu', // Remplacez par le nom de votre menu
                'menu_class' => 'menu-header', // Ajoutez des classes au besoin
            ));
        ?>
        </nav>
    </header>

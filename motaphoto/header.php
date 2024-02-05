<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motaphoto</title>
</head>
<body>
    
<?php
// Afficher le menu principal
wp_nav_menu(array(
    'theme_location' => 'menu', // Remplacez par le nom de votre menu
    'menu_class' => 'menu-header', // Ajoutez des classes au besoin
));
?>

<?php
function theme_enqueue_styles() {
  // Ajout du style du thème parent
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

  // Ajout du style personnalisé généré à partir de Sass, dépendant du style du thème parent
  wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/styles.css', array('parent-style'), '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles'); 

function enqueue_custom_script() {
    // Enfilet le script personnalisé
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom-script.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script');

register_nav_menus(array('main'=>'menu'));
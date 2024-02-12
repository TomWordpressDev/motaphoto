<?php
function custom_theme_enqueue_scripts() {
    // Ajout du style du thème parent
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    // Ajout du style personnalisé généré à partir de Sass, dépendant du style du thème parent
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/styles.css', array('parent-style'), '1.0.0', 'all');

 
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/custom-script.js', array('jquery'), '1.0.0', true);
    
}
add_action('wp_enqueue_scripts', 'custom_theme_enqueue_scripts');

function theme_setup() {
    register_nav_menu('menu', __('Primary Menu', 'textdomain'));
}
add_action('after_setup_theme', 'theme_setup');

<?php
function enqueue_custom_styles() {
    wp_enqueue_style('custom-styles', get_template_directory_uri() . '/styles/style.css');
  }
  
  add_action('wp_enqueue_scripts', 'enqueue_custom_styles');
  

function enqueue_custom_script() {
    // Enfilet le script personnalisé
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom-script.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script');

register_nav_menus(array('main'=>'menu'));
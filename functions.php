<?php

function akopress_scripts() {
    wp_enqueue_script( 'navbar.js', get_stylesheet_directory_uri() . '/js/navbar.js', array('jquery'), '1.0.0', true);
    
    wp_enqueue_style( 'google-fonts-style', "https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@900&display=swap" );
}

add_action('wp_enqueue_scripts', 'akopress_scripts');

<?php

function akopress_scripts() {
    wp_enqueue_script( 'navbar.js', get_stylesheet_directory_uri() . '/js/navbar.js', array(jquery), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'akopress_scripts');

<?php

/* Ajout des fonctions au thème custom */

function mota_custom_support () {
add_theme_support('title-tag');
add_theme_support('custom-logo', array() );
add_theme_support('post-thumbnails');
}

/* Ajout des différents assets */

function mota_custom_assets () {
    wp_enqueue_style ('main_style', get_stylesheet_directory_uri() . './assets/css/main.css' );
    wp_enqueue_script ('custom_script', get_template_directory_uri() . './assets/script.js' );
    wp_enqueue_style('poppins-font', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', array(), false, 'all');
    wp_enqueue_style('poppins-font', 'https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), false, 'all');   
}

/* Installation des polices en local */

function mota_custom_fonts() {
    wp_enqueue_style('SpaceMono_Regular', get_template_directory_uri() . './assets/fonts/spacemono-regular.ttf');
    wp_enqueue_style('SpaceMono_Bold', get_template_directory_uri() . './assets/fonts/spacemono-bold.ttf');
    wp_enqueue_style('SpaceMono_Italic', get_template_directory_uri() . './assets/fonts/spacemono-italic.ttf');
    wp_enqueue_style('SpaceMono_BoldItalic', get_template_directory_uri() . './assets/fonts/spacemono-bolditalic.ttf');
}

/* Ajout de l'emplacement de menu du header */

function register_my_menu() {
    register_nav_menu( 'header-menu', __( 'Header', 'text-domain' ) );
    register_nav_menu( 'footer-menu', __( 'Footer', 'text-domain' ) );
}



/* ADD ACTION */

add_action('after_setup_theme', 'mota_custom_support');
add_action('wp_enqueue_scripts', 'mota_custom_assets');
add_action('wp_enqueue_scripts', 'mota_custom_fonts');
add_action( 'after_setup_theme', 'register_my_menu' );


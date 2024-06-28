<?php

// on ajoute le lien vers le formulaire de contact dans le menu principal
include 'functions_ajax.php';

/* Chargement des styles du parent. */
add_action( 'wp_enqueue_scripts', 'wpchild_enqueue_styles' );

function wpchild_enqueue_styles(){
    // chargement du theme enfant
    wp_enqueue_style( 'wpm-kadence-style', get_stylesheet_directory_uri() . '/style.css' );

    // style du header et du footer
    wp_enqueue_style( 'header-footer-style', get_stylesheet_directory_uri() . '/assets/css/header-footer-style.css');

    // script lightbox
    wp_enqueue_style( 'lightbox-style', get_stylesheet_directory_uri() . '/assets/css/lightbox-style.css');
    wp_enqueue_script('lightbox-script',  get_stylesheet_directory_uri().'/assets/js/lightbox-script.js', array(), '1.0.0', array('strategy'  => 'defer'));

    // style et script du formulaire de contact
    wp_enqueue_style( 'contact-style', get_stylesheet_directory_uri() . '/assets/css/contact-style.css');
    wp_enqueue_script('general-script',  get_stylesheet_directory_uri().'/assets/js/general-script.js', array(), '1.0.0', array('strategy'  => 'defer'));

    // style des miniatures des photos
    wp_enqueue_style( 'thumbnail-photo-style', get_stylesheet_directory_uri() . '/assets/css/thumbnail-photo-style.css');

    if(is_page('accueil')){
        wp_enqueue_style( 'home-style', get_stylesheet_directory_uri() . '/assets/css/home-style.css');
        wp_enqueue_script('home-script',  get_stylesheet_directory_uri().'/assets/js/home-script.js', array('jquery', 'general-script', 'lightbox-script'), '1.0.0', array('strategy'  => 'defer'));
    }

    if(is_singular('photo')){
      	wp_enqueue_style( 'post-photo-style', get_stylesheet_directory_uri() . '/assets/css/post-photo-style.css');
      	wp_enqueue_script('single-page-script',  get_stylesheet_directory_uri().'/assets/js/single-page-script.js', array('lightbox-script'), '1.0.0', array('strategy'  => 'defer'));
    }

}


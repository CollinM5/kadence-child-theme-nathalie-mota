<?php

// on ajoute le lien vers le formulaire de contact dans le menu principal

/* Chargement des styles du parent. */
add_action( 'wp_enqueue_scripts', 'wpchild_enqueue_styles' );

function wpchild_enqueue_styles(){
    // chargement du theme enfant
    wp_enqueue_style( 'wpm-kadence-style', get_stylesheet_directory_uri() . '/style.css' );

    // style du header
    wp_enqueue_style( 'header-style', get_stylesheet_directory_uri() . '/assets/css/header-style.css');

    // style et script du formulaire de contact
    wp_enqueue_style( 'contact-style', get_stylesheet_directory_uri() . '/assets/css/contact-style.css');
    wp_enqueue_script('general-script',  get_stylesheet_directory_uri().'/assets/js/general-script.js', array(), '1.0.0', array('strategy'  => 'defer'));

    // style des miniatures des photos
    wp_enqueue_style( 'thumbnail-photo-style', get_stylesheet_directory_uri() . '/assets/css/thumbnail-photo-style.css');

    if(is_singular('photo')){
      	wp_enqueue_style( 'post-photo-style', get_stylesheet_directory_uri() . '/assets/css/post-photo-style.css');
      	wp_enqueue_script('single-page-script',  get_stylesheet_directory_uri().'/assets/js/single-page-script.js', array(), '1.0.0', array('strategy'  => 'defer'));
    }

}


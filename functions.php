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
  wp_enqueue_script('contact-script',  get_stylesheet_directory_uri().'/assets/js/contact-modal-script.js', array(), '1.0.0', array('strategy'  => 'defer'));

}


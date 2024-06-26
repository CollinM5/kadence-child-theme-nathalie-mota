<?php

// on ajoute le lien vers le formulaire de contact dans le menu principal

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


function load_more_posts() {
    // Vérifie les paramètres nécessaires
    if (!isset($_POST['posts_per_page']) || !isset($_POST['offset'])) {
        wp_send_json_error('Missing parameters');
        wp_die();
    }

    // Vérification du nonce pour la sécurité
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_more_posts_nonce')) {
        wp_send_json_error('Invalid nonce');
        wp_die();
    }

    $posts_per_page = intval($_POST['posts_per_page']);
    $offset = intval($_POST['offset']);

    $args = array(
        'post_type' => 'photo', // Type de post personnalisé
        'posts_per_page' => $posts_per_page,
        'offset' => $offset,
        'order' => 'desc',
        'tax_query' => array(),
    );

    if(isset($_POST['categories'])){
        array_push($args['tax_query'], array( 'taxonomy' => 'categorie','field' => 'slug','terms' => $_POST['categories']));
    }

    if(isset($_POST['formats'])){
        array_push($args['tax_query'], array( 'taxonomy' => 'format','field' => 'slug','terms' => $_POST['formats']));  
    }

    if(isset($_POST['order'])){
        $args['order'] = $_POST['order'];
    }

    $query = new \WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('templates_part/template-image');
        }

        wp_reset_postdata();
        $content = ob_get_clean();

        if (empty($content)) {
            wp_send_json_error('Template part is empty');
        } else {
            wp_send_json_success($content);
        }
       

    } else {
        wp_send_json_success("");
    }

    exit;
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');


function sort_posts() {
    // Vérifie les paramètres nécessaires
    if (!isset($_POST['posts_per_page'])) {
        wp_send_json_error('Missing parameters');
        wp_die();
    }

    // Vérification du nonce pour la sécurité
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'sort_posts_nonce')) {
        wp_send_json_error('Invalid nonce');
        wp_die();
    }

    $posts_per_page = intval($_POST['posts_per_page']);

    $args = array(
        'post_type' => 'photo', // Type de post personnalisé
        'posts_per_page' => $posts_per_page,
        'order' => 'ASC',
        'tax_query' => array(),
    );

    if(isset($_POST['categories'])){
        array_push($args['tax_query'], array( 'taxonomy' => 'categorie','field' => 'slug','terms' => $_POST['categories']));
    }

    if(isset($_POST['formats'])){
        array_push($args['tax_query'], array( 'taxonomy' => 'format','field' => 'slug','terms' => $_POST['formats']));  
    }

    if(isset($_POST['order'])){
        $args['order'] = $_POST['order'];
    }

    $query = new \WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('templates_part/template-image');
        }

        wp_reset_postdata();
        $content = ob_get_clean();

        if (empty($content)) {
            wp_send_json_error('Template part is empty');
        } else {
            wp_send_json_success($content);
        }
       

    } else {
        wp_send_json_success("");
    }

    exit;
}
add_action('wp_ajax_sort_posts', 'sort_posts');
add_action('wp_ajax_nopriv_sort_posts', 'sort_posts');
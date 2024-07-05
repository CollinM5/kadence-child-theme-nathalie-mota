<?php

// CHARGER PLUS DE POST ---------------------------------------------
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
        'posts_per_page' => $posts_per_page + 1,
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

    $has_more = false;
    $post_count = $query->post_count;

    if ($query->have_posts()) {
        $counter = 0;
        while ($query->have_posts() && $counter < $posts_per_page) {
            $query->the_post();
            get_template_part('templates_part/template-image');
            $counter++;
        }

        if ($post_count > $posts_per_page) {
            $has_more = true;
        }

        wp_reset_postdata();
        $content = ob_get_clean();

        if (empty($content)) {
            wp_send_json_error('Template part is empty');
        } else {
            wp_send_json_success(array('content' => $content, 'has_more' => $has_more));
        }
       

    } else {
        wp_send_json_success("");
    }

    exit;
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');


// TRIER LES POSTS ---------------------------------------------
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
        'posts_per_page' => $posts_per_page  + 1,
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

    $has_more = false;
    $post_count = $query->post_count;

    if ($query->have_posts()) {
        $counter = 0;
        while ($query->have_posts() && $counter < $posts_per_page) {
            $query->the_post();
            get_template_part('templates_part/template-image');
            $counter++;
        }

        if ($post_count > $posts_per_page) {
            $has_more = true;
        }

        wp_reset_postdata();
        $content = ob_get_clean();

        if (empty($content)) {
            wp_send_json_error('Template part is empty');
        } else {
            wp_send_json_success(array('content' => $content, 'has_more' => $has_more));
        }
       

    } else {
        wp_send_json_success("");
    }

    exit;
}
add_action('wp_ajax_sort_posts', 'sort_posts');
add_action('wp_ajax_nopriv_sort_posts', 'sort_posts');
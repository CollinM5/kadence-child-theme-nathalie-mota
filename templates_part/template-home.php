<?php
// ----------------- selection d'une photo pour le hero

$image_url = "";

 // Arguments de la requête pour récupérer les images
$args = array(
	'post_type'      => 'attachment',
	'post_mime_type' => 'image',
	'post_status'    => 'inherit',
	'posts_per_page' => -1, // Récupère toutes les images
);

// Exécute la requête
$query = new \WP_Query( $args );

// Vérifie si des images ont été trouvées
if ( $query->have_posts() ) {
	// Récupère toutes les images
	$images = $query->posts;

	// Sélectionne une image aléatoire
	$random_image = $images[ array_rand( $images ) ];
	
	while ($random_image->guid === "http://nathalie-mota.local/wp-content/uploads/2024/06/Logo.svg"){
		$random_image = $images[ array_rand( $images ) ];
	}

	// Retourne l'URL de l'image
	$image_url = wp_get_attachment_url( $random_image->ID );
}

// ----------------- récupération des 8 premiers posts

$args = array(
	'post_type' => 'photo', // Assurez-vous de spécifier le type de contenu personnalisé
	'posts_per_page' => 8,
	'orderby' => 'desc',
);
	
$posts_query = new \WP_Query( $args );


// ----------------- taxonomie 

function display_taxonomie_select($taxonomy) {
    $terms = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
    ));

    $taxonomy_obj = get_taxonomy($taxonomy);
    $taxonomy_label = $taxonomy_obj->labels->singular_name;

    echo '<select class="sort-elements" name="' . esc_attr($taxonomy) . '">';
    echo '<option selected value="">' . esc_html($taxonomy_label) . '</option>';

    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
        }
    } else {
        echo '<option value="">Aucun terme trouvé</option>';
    }

    echo '</select>';
}


?>

<!-- hero de la page -->
<section id="hero" data-background="<?php echo $image_url; ?>">
	<h1>PHOTOGRAPHE EVENT</h1>
</section>

<section id="galerie-photo">
	<div id="filtres">
		<!-- formulaire pour trier les photos -->
		<form 
			action="<?php echo admin_url( 'admin-ajax.php' ); ?>" 
			method="post" 
			class="sort-posts"
			id="sort-posts-form"
		>
			
			<input 
				type="hidden" 
				name="posts_per_page" 
				value="8"
			>
			<input 
				type="hidden" 
				name="nonce" 
				value="<?php echo wp_create_nonce( 'sort_posts_nonce' ); ?>"
			> 
			<input
				type="hidden"
				name="action"   
				value="sort_posts"
			>

			<?php 

			display_taxonomie_select('categorie'); 
			display_taxonomie_select('format'); 

			?>
			
			<select class="sort-elements" name="order">
				<option selected value="">Trier par</option>
				<option value="ASC">à partir des plus anciennes</option>
				<option value="DESC"> à partir des plus récentes</option>
			</select>
		</form>
	</div>
	<div id="photos">
	<!-- la liste des photos -->
	<?php

		$posts = $posts_query->get_posts();
		foreach( $posts as $post ) {
			setup_postdata( $post );
			get_template_part( 'templates_part/template-image' );
			wp_reset_postdata();
		}
		
	?>
	</div>
	<!-- formulaire pour charger plus de photo -->
	<form 
        action="<?php echo admin_url( 'admin-ajax.php' ); ?>" 
        method="post" 
        class="js-load-posts display"
		id="js-load-posts-form"
    >
        <input 
            type="hidden" 
            name="order" 
            value="desc"
        >
		<input 
            type="hidden" 
            name="posts_per_page" 
            value="8"
        >
        <input 
            type="hidden" 
            name="nonce" 
            value="<?php echo wp_create_nonce( 'load_more_posts_nonce' ); ?>"
        > 
        <input
            type="hidden"
            name="action"   
            value="load_more_posts"
        >

        <button class="posts-load-button">Charger plus</button>
    </form>
</section>

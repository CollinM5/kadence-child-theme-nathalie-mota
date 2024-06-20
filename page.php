<?php
/**
 * The main single item template file.
 *
 * @package kadence
 */

namespace Kadence;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


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

	// Retourne l'URL de l'image
	$image_url = wp_get_attachment_url( $random_image->ID );
}

// ----------------- récupération des 8 premiers posts

$args = array(
	'post_type' => 'photo', // Assurez-vous de spécifier le type de contenu personnalisé
	'posts_per_page' => 8,
	'orderby' => 'asc',
);
	
$posts_query = new \WP_Query( $args );




get_header();


?>


<section id="hero" data-background="<?php echo $image_url; ?>">
	<h1>PHOTOGRAPHE EVENT</h1>
</section>

<section id="galerie-photo">
	<div id="filtres"></div>
	<div id="photos">
	<?php

		$posts = $posts_query->get_posts();
		foreach( $posts as $post ) {
			setup_postdata( $post );
			get_template_part( 'templates_part/template-image' );
			wp_reset_postdata();
		}
		
	?>
		
	</div>
</section>


<?php
get_footer();


?>
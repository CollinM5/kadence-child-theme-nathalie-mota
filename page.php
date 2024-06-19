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



get_header();


?>


<section id="hero" data-background="<?php echo $image_url; ?>">
	<h1>PHOTOGRAPHE EVENT</h1>
</section>


<?php
get_footer();


?>
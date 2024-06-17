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

get_header();

// récupération des données du type
$reference = get_post_meta( get_the_ID(), 'reference', true );
$type = get_post_meta( get_the_ID(), 'type', true );
$categorie = get_the_terms( get_the_ID(), 'categorie' )[0]->name ;
$format = get_the_terms( get_the_ID(), 'format' )[0]->name;
$year = get_the_date('Y');

// récupération du post précédent et suivant pour la navigation
$previous_post = get_adjacent_post( false, '', true );
$next_post = get_adjacent_post( false, '', false );

?>

<main id="main">

	<div id="post">
		<div id="post-info">
			<h1><?php echo get_the_title() ?></h1>
			<ul>
				<li>référence : <span id="image-ref"><?php echo esc_html( $reference ) ?></span></li>
				<li>catégorie : <?php echo esc_html( $categorie ) ?></li>
				<li>format : <?php echo esc_html( $format ) ?></li></li>
				<li>type : <?php echo esc_html( $type ) ?></li>
				<li>année : <?php echo esc_html( $year ) ?></li>
			</ul>
		</div>

		<div id="post-image">
			<?php echo get_the_post_thumbnail( get_the_ID(), 'full' ); ?>
		</div>
	</div>

	<div id="contact-and-navigation">
		<div id="contact">
			<p>Cette photo vous intéresse ?</p>
			<button id="btn-contact">Contact</button>
		</div>

		<div id="navigation">
			<div id="preview">
				<img src="" id="preview-image">
			</div>
			<div id="nav-arrow">
				<a href="<?php echo get_permalink( $previous_post->ID ); ?>">
					<img id="previous-post" class="arrow" data-image="<?php echo get_the_post_thumbnail_url( $previous_post->ID, 'thumbnail' ) ?>" src="<?php echo get_stylesheet_directory_uri().'/assets/images/arrowLeft.svg' ?>">
				</a>
				<a href="<?php echo get_permalink( $next_post->ID ); ?>">
					<img id="next-post" class="arrow" data-image="<?php echo get_the_post_thumbnail_url( $next_post->ID, 'thumbnail' ) ?>" src="<?php echo get_stylesheet_directory_uri().'/assets/images/arrowRight.svg' ?>">
				</a>
			</div>
			<div></div>
		</div>
	</div>
	

</main>

<?php get_footer(); ?>

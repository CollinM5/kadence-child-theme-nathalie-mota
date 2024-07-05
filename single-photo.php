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


// récupération de deux photos de la meme catégorie
$categories = get_the_terms( get_the_ID(), 'categorie' );

if ( $categories ) {
    $category_ids = array();
    foreach ( $categories as $category ) {
        $category_ids[] = $category->term_id;
    }

	$args = array(
		'post_type' => 'photo', // Assurez-vous de spécifier le type de contenu personnalisé
        'post__not_in' => array( get_the_ID() ), // Exclure l'article actuel
        'posts_per_page' => 2,
        'orderby' => 'rand',
        'tax_query' => array(
            array(
                'taxonomy' => 'categorie', // Nom de votre taxonomie personnalisée
                'field' => 'term_id',
                'terms' => $category_ids,
            ),
        ),
	);
	
	$related_posts_query = new \WP_Query( $args );
} 




?>

<main id="main">

	<section id="post">
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
			<a href="<?php echo get_the_post_thumbnail_url(get_the_ID()) ?>" target="_blank">
				<?php echo get_the_post_thumbnail( get_the_ID(), 'full' ); ?>
			</a>
		</div>
	</section>

	<section id="contact-and-navigation">
		<div id="contact">
			<p>Cette photo vous intéresse ?</p>
			<button id="btn-contact">Contact</button>
		</div>

		<div id="navigation">
			<div id="preview">
				<img src="" id="preview-image">
			</div>
			<div id="nav-arrow">
				<?php 
					if(isset($previous_post) && $previous_post != ""){
						echo '<a href="'.get_permalink( $previous_post->ID ).'">';
						echo '<img id="previous-post" class="arrow" data-image="'.get_the_post_thumbnail_url( $previous_post->ID, 'thumbnail' ) .'" src="'.get_stylesheet_directory_uri().'/assets/images/arrowLeft.svg">';
						echo '</a>';
					}else{
						echo '<div></div>';
					}
					
					if(isset($next_post) && $next_post != ""){
						echo '<a href="'.get_permalink( $next_post->ID ).'">';
						echo '<img id="next-post" class="arrow" data-image="'.get_the_post_thumbnail_url( $next_post->ID, 'thumbnail' ) .'" src="'.get_stylesheet_directory_uri().'/assets/images/arrowRight.svg">';
						echo '</a>';
					}
				?>
			</div>
			<div></div>
		</div>
	</section>
	
	<?php 
	if(isset($related_posts_query)){
		if( $related_posts_query->have_posts() ){
			echo '<section id="related-photos">';
			echo '<h2>Vous aimerez aussi</h2>';
			echo '<div class="post-thumbnail-row">';

			$posts = $related_posts_query->get_posts();

			foreach( $posts as $post ) {
				setup_postdata( $post );
				get_template_part( 'templates_part/template-image' );
				wp_reset_postdata();
			}

			echo '</div>';
			echo '</section>';
		}
	}
	?>
</main>

<?php get_footer(); ?>

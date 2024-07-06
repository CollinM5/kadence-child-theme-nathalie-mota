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

if(is_page('accueil')){

	get_template_part('templates_part/template-home');

}else{

	kadence()->print_styles( 'kadence-content' );
	/**
	 * Hook for everything, makes for better elementor theming support.
	 */
	do_action( 'kadence_single' );
	
}

get_footer();

?>
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
}

get_footer();

?>
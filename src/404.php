<?php
/**
 * The template for displaying the 404 template in the theme.
 *
 * @package Webpack + Typescript + Sass + Wordpress
 * @since 1.0.0
 */

get_header();

?>

<main class="main" id="site-content" role="main">
	
	<h1><?php _e( 'Page Not Found', 'wordpress-starter' ); ?></h1>

	<p><?php _e( 'The page you were looking for could not be found.', 'wordpress-starter' ); ?></p>

</main>

<?php 

get_footer();

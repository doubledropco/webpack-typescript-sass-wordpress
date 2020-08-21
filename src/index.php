<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Webpack + Typescript + Sass + WordPress
 * @since 1.0.0
 */

get_header();

?>

<main class="main" id="site-content" role="main">

	<?php if ( ! post_password_required() ) : ?>
		<?php

		if ( have_posts() ) {

			while ( have_posts() ) {
				the_post();

				the_content();
			}
		}

		?>
	<?php else : ?>
		<div class="container-fluid h-100 d-flex align-items-center justify-content-center">
			<div>
				<h3 class="mt-5"><?php echo __( 'Password required', 'wordpress-starter' ); ?></h3>
				<?php echo get_the_password_form(); ?>
			</div>
		</div>
	<?php endif; ?>

</main>

<?php

get_footer();


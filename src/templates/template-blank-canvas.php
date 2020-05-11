<?php
/**
 * Template Name: Blank Canvas
 *
 * @package Webpack + Typescript + Sass + Wordpress
 * @since 1.0.0
 */

get_header();

?>

<main class="main" id="site-content" role="main">

	<?php if ( !post_password_required() ): ?>
		<?php

			if (have_posts()) {

				while (have_posts()) {
					the_post();

					the_content();
				}
			}

		?>
	<?php else: ?>
		<div class="container-fluid h-100 d-flex align-items-center justify-content-center">
			<div>
				<h3 class="mt-5"><?php echo __('Password required', 'wordpress-starter'); ?></h3>
				<?php echo get_the_password_form(); ?>
			</div>
		</div>
	<?php endif; ?>

</main>

<?php 

get_footer();

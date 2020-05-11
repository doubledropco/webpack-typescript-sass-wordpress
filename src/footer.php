<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Webpack + Typescript + Sass + Wordpress
 * @since 1.0.0
 */

?>
		<footer class="footer <?php if (is_active_sidebar('widget-footer-5')): ?>footer--has-widget-5<?php endif; ?>" id="footer">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-md-3 mb-6 mb-md-0 text-center text-md-left">
						<?php if( is_active_sidebar('widget-footer-1') ) : ?>		
							<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-footer-1') ) : endif; ?>
						<?php endif;?>
					</div>

					<div class="col-12 col-md-3 mb-6 mb-md-0 text-center text-md-left">
						<?php if( is_active_sidebar('widget-footer-2') ) : ?>		
							<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-footer-2') ) : endif; ?>
						<?php endif;?>
					</div>

					<div class="col-12 col-md-3 mb-6 mb-md-0 text-center text-md-left">
						<?php if( is_active_sidebar('widget-footer-3') ) : ?>		
							<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-footer-3') ) : endif; ?>
						<?php endif;?>
					</div>

					<div class="col-12 col-md-3 mb-6 mb-md-0 text-center text-md-left">
						<?php if( is_active_sidebar('widget-footer-4') ) : ?>		
							<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-footer-4') ) : endif; ?>
						<?php endif;?>
					</div>
				</div>
			</div>

			<?php if( is_active_sidebar('widget-footer-5') ) : ?>		
				<div class="container-fluid">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-footer-5') ) : endif; ?>
				</div>
			<?php endif;?>
		</footer>

		<?php wp_footer(); ?>

	</body>
</html>

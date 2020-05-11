<?php
/**
 * The template for displaying the header
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Webpack + Typescript + Sass + Wordpress
 * @since 1.0.0
 */

?><!DOCTYPE html>

<?php

$site_name = get_bloginfo('name');
$site_url = get_site_url();
$logo = get_field('logo', 'option');
$google_tag_manager_key = get_field('google_tag_manager_key', 'option');
$google_maps_api_key = get_field('google_maps_api_key', 'option');
$header_menu_animation = get_field('header_menu_animation', 'option');

if ($logo):
	$logo_svg_inline = file_get_contents($logo);
endif;

?>

<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<?php if ($google_tag_manager_key): ?>
			<!-- Google Tag Manager -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-W9F8W7K');</script>
			<!-- End Google Tag Manager -->
		<?php endif; ?>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" >

		<?php if ($google_maps_api_key): ?>
			<script>
				window.gmak = '<?php echo $google_maps_api_key; ?>';
			</script>
		<?php endif; ?>

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>
		<?php if ($google_tag_manager_key): ?>
			<!-- Google Tag Manager (noscript) -->
			<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W9F8W7K"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			<!-- End Google Tag Manager (noscript) -->
		<?php endif; ?>

		<?php wp_body_open(); ?>

		<header class="header" id="header">

			<div class="container-fluid header__flex">

				<div class="header__logo">
					<a href="<?php echo $site_url ?>" title="<?php echo $site_name ?>">
						<?php echo $logo_svg_inline; ?>
					</a>
				</div>

				<?php

					if ( has_nav_menu( 'primary-desktop' ) ) {

						wp_nav_menu(
							array(
								'theme_location' => 'primary-desktop',
								'container' => 'div',
								'container_class'  => 'header__desktop-nav',
								'container_id'  => 'header__desktop-nav',
								'walker' => new Desktop_Nav_Walker,
							)
						);

					}

				?>

				<?php if ( has_nav_menu( 'primary-mobile' ) ): ?>

					<div id="header__mobile-nav" class="header__mobile-nav">
						<?php if( is_active_sidebar('doubledrop-widget-header-mobile') ) : ?>		
							<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('doubledrop-widget-header-mobile') ) : endif; ?>
						<?php endif;?>

						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'primary-mobile',
									'walker' => new Mobile_Nav_Walker,
								)
							);
						?>

					</div>	
				<?php endif; ?>

				<?php if ( has_nav_menu( 'primary-mobile' ) ): ?>
					<div class="header__menu-toggle">
						<button id="mobile-nav-toggle" class="hamburger <?php echo $header_menu_animation; ?>" type="button">
							<span class="hamburger-box">
								<span class="hamburger-inner"></span>
							</span>
						</button>
					</div>
				<?php endif; ?>
			</div>

		</header>

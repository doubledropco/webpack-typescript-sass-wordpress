<?php
/**
 * The template for displaying the header
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Webpack + Typescript + Sass + WordPress
 * @since 1.0.0
 */

?><!DOCTYPE html>

<?php

$site_name              = get_bloginfo( 'name' );
$site_url               = get_site_url();
$logo                   = get_field( 'logo', 'option' );
$google_tag_manager_key = get_field( 'google_tag_manager_key', 'option' );
$facebook_app_id        = get_field( 'facebook_app_id', 'option' );
$google_maps_api_key    = get_field( 'google_maps_api_key', 'option' );
$header_menu_animation  = get_field( 'header_menu_animation', 'option' );

if ( $logo ) :
	$logo_svg_inline = file_get_contents( ABSPATH . parse_url( $logo, PHP_URL_PATH ) );
endif;

?>

<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<?php if ( $google_tag_manager_key ) : ?>
			<!-- Google Tag Manager -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','<?php echo $google_tag_manager_key; ?>');</script>
			<!-- End Google Tag Manager -->
		<?php endif; ?>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" >

		<?php if ( $google_maps_api_key ) : ?>
			<script>
				window.gmak = '<?php echo $google_maps_api_key; ?>';
			</script>
		<?php endif; ?>

		<?php if ( $facebook_app_id ) : ?>
			<!-- Facebook Pixel Code -->
			<script>
			!function(f,b,e,v,n,t,s)
			{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};
			if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
			n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t,s)}(window, document,'script',
			'https://connect.facebook.net/en_US/fbevents.js');
			fbq('init', '<?php echo $facebook_app_id; ?>');
			fbq('track', 'PageView');
			</script>
			<noscript><img height="1" width="1" style="display:none"
			src="https://www.facebook.com/tr?id=<?php echo $facebook_app_id; ?>&ev=PageView&noscript=1"
			/></noscript>
			<!-- End Facebook Pixel Code -->
		<?php endif; ?>

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>
		<?php if ( $google_tag_manager_key ) : ?>
			<!-- Google Tag Manager (noscript) -->
			<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $google_tag_manager_key; ?>"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			<!-- End Google Tag Manager (noscript) -->
		<?php endif; ?>

		<?php wp_body_open(); ?>

		<header class="header" id="header">

			<div class="container-fluid header__container">

				<div class="header__logo">
					<a href="<?php echo $site_url; ?>" title="<?php echo $site_name; ?>">
						<?php echo $logo_svg_inline; ?>
					</a>
				</div>

				<?php

				if ( has_nav_menu( 'primary-desktop' ) ) {

					wp_nav_menu(
						array(
							'theme_location'  => 'primary-desktop',
							'container'       => 'div',
							'container_class' => 'header__desktop-nav',
							'container_id'    => 'header__desktop-nav',
							'walker'          => new Desktop_Nav_Walker,
						)
					);

				}

				?>

				<?php if ( is_active_sidebar( 'widget-header-navigation' ) ) : ?>		
					<?php
					if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'widget-header-navigation' ) ) :
endif;
					?>
				<?php endif; ?>

				<?php if ( has_nav_menu( 'primary-mobile' ) || is_active_sidebar( 'widget-mobile-menu-before' ) || is_active_sidebar( 'widget-mobile-menu-after' ) ) : ?>

					<div id="header__mobile-nav" class="header__mobile-nav">

						<?php if ( is_active_sidebar( 'widget-mobile-menu-before' ) ) : ?>		
							<?php
							if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'widget-mobile-menu-before' ) ) :
endif;
							?>
						<?php endif; ?>

						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'primary-mobile',
									'walker'         => new Mobile_Nav_Walker,
								)
							);
						?>

						<?php if ( is_active_sidebar( 'widget-mobile-menu-after' ) ) : ?>		
							<?php
							if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'widget-mobile-menu-after' ) ) :
endif;
							?>
						<?php endif; ?>

					</div>	

					<div class="header__menu-toggle">
						<button id="mobile-nav-toggle" class="hamburger <?php echo $header_menu_animation; ?>" type="button" aria-label="Toggle mobile menu">
							<span class="hamburger-box">
								<span class="hamburger-inner"></span>
							</span>
						</button>
					</div>
				<?php endif; ?>
			</div>

		</header>

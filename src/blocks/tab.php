<?php
/**
 * Functions to register client-side assets (scripts and stylesheets) for the
 * Gutenberg block.
 *
 * @package Webpack + Typescript + Sass + WordPress
 */

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function tab_block_init() {
	// Skip block registration if Gutenberg is not enabled/merged.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	wp_register_script(
		'tab-block-editor',
		get_template_directory_uri() . '/static/tab.js',
		array(
			'wp-blocks',
			'wp-block-editor',
			'wp-i18n',
			'wp-element',
		)
	);

	wp_register_style(
		'tab-block-editor',
		get_template_directory_uri() . '/static/tab.css'
	);

	register_block_type(
		'wordpress-starter/tab',
		array(
			'editor_script' => 'tab-block-editor',
			'editor_style'  => 'tab-block-editor',
		)
	);
}
add_action( 'init', 'tab_block_init' );

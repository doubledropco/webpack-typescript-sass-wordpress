<?php
/**
 * Custom template tags for this theme
 *
 * @package Webpack + Typescript + Sass + WordPress
 * @since 1.0.0
 */

if ( ! function_exists( 'related_post' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function related_post() {
		$related_posts = get_field( 'related_post' );

		if ( $related_posts ) {
			foreach ( $related_posts as $post ) {
				printf(
					/* translators: 1: Post author, only visible to screen readers. 2: Author link. */
					'<div class="mb-1"><span class="font-weight-bold text-secondary">%1$s</span>&nbsp;<a class="text-primary" href="%2$s">%3$s</a></div>',
					__( 'Related Post:', 'wp-starter' ),
					get_permalink( $post ),
					get_the_title( $post )
				);
			}
		}
	}
endif;

if ( ! function_exists( 'posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);

		return sprintf(
			'<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string
		);
	}
endif;

if ( ! function_exists( 'posted_by' ) ) :
	/**
	 * Prints HTML with meta information about theme author.
	 */
	function posted_by() {
		$author_id   = get_the_author_id();
		$first_name  = get_the_author_meta( 'first_name', $author_id );
		$last_name   = get_the_author_meta( 'last_name', $author_id );
		$author_name = get_the_author();
		if ( $first_name && $last_name ) {
			$author_name = "{$first_name} {$last_name}";
		}

		return sprintf(
			/* translators: 1: Post author, only visible to screen readers. 2: Author link. */
			'<span class="byline"><span class="sr-only">%1$s</span><span class="author font-weight-bold vcard"><a class="url fn n" href="%2$s">%3$s</a></span></span>',
			__( 'Posted by', 'wp-starter' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( $author_name )
		);
	}
endif;

if ( ! function_exists( 'categories' ) ) :
	/**
	 * Prints HTML with meta information about theme author.
	 */
	function categories( $sep = ', ' ) {
		$categories_list = get_the_category_list( $sep );
		if ( $categories_list ) {
			return sprintf(
				/* translators: 1: Posted in label, only visible to screen readers. 2: List of categories. */
				'<span class="cat-links"><span class="sr-only">%1$s</span>%2$s</span>',
				__( 'Posted in', 'wp-starter' ),
				$categories_list
			); // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'tags' ) ) :
	/**
	 * Prints HTML with meta information about theme author.
	 */
	function tags( $sep = ', ' ) {
		$tags_list = get_the_tag_list( '', $sep );
		if ( $tags_list ) {
			return sprintf(
				/* translators: 1: Posted in label, only visible to screen readers. 2: List of tags. */
				'<span class="tag-links"><span class="sr-only">%1$s </span>%2$s</span>',
				__( 'Tags:', 'wp-starter' ),
				$tags_list
			); // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'get_page_id' ) ) {
	/**
	 * Return the current page id
	 */
	function get_page_id() {
		global $post_id, $post, $wp_query;
		$page_id = get_the_ID();

		if ( is_archive() || is_home() ) {
			$page_id = get_option( 'page_for_posts' );
		}

		return $page_id;
	}
}

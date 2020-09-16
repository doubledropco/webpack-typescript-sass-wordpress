<?php

/**
 * Error logging helper to objects to the error log
 */
if ( ! function_exists( 'rlog' ) ) {
	function rlog( ...$args ) {
		foreach ( $args as $str ) {
			error_log( print_r( $str, true ) );
		}
	}
}

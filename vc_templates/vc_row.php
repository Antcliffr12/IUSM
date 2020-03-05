<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Bypass all wrapper markup and output the markup directly
echo wpb_js_remove_wpautop( $content );


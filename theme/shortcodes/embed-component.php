<?php
/**
 * Passthrough shortcode for direct component embed interface
 * @param $atts Shortcode attribute array
 * @return string The rendered output of the shortcode
 */
function sc_embed_component( $atts ) {
	extract( shortcode_atts( array(
		'id' => '',
	), $atts ));
	return render_component($id, $atts);
}
add_shortcode( 'embed_component', 'sc_embed_component' );

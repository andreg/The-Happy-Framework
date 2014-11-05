<?php

/**
 * Get contents from a template.
 *
 * @since 1.0.0
 * @param string $file The full path to the template file.
 * @param array $data The data array to be passed to the template.
 * @param boolean $echo True to echo the template part.
 * @return string
 */
function thb_template( $path, $data = array(), $echo = true ) {
	$path = thb_string_ensure_right( $path, '.php' );

	if ( file_exists( $path ) ) {
		extract( $data );

		ob_start();
		include $path;
		$content = ob_get_contents();
		ob_end_clean();

		if( ! $echo ) {
			return $content;
		}
		else {
			echo $content;
		}
	}

	return '';
}

/**
 * Get contents from a partial template. If we're in a child theme, the
 * function will attempt to look for the resource in the child theme directory
 * first.
 *
 * @since 1.0.0
 * @param string $file The template file.
 * @param array $data The data array to be passed to the template.
 * @param boolean $echo True to echo the template part.
 * @return string
 */
function thb_get_template_part( $file, $data = array(), $echo = true ) {
	$file = thb_string_ensure_right( $file, '.php' );

	// $path = locate_template( 'templates/' . $file );

	if ( empty( $path ) ) {
		$path = locate_template( $file );
	}

	return thb_template( $path, $data, $echo );
}
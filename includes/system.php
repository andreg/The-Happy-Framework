<?php

/**
 * Load the framework instance.
 *
 * @since 1.0.0
 * @return THB_Framework
 */
function thb_fw() {
	return THB_Framework::instance();
}

/**
 * Require a PHP file. Before loading the file, it will look for it in the child
 * theme directory, if a child theme is being used; if no file is found, it will
 * attempt to load the file looking in the parent theme.
 *
 * @since 1.0.0
 * @param string $file The file path relative to the currently active theme folder.
 * @return string The full path to the file loaded or an empty string if the file isn't found.
 */
function thb_require( $file ) {
	$path = '';

	if ( is_child_theme() && file_exists( THB_CHILD_THEME_FOLDER . $file ) ) {
		$path = THB_CHILD_THEME_FOLDER . $file;
	}
	elseif ( file_exists( THB_THEME_FOLDER . $file ) ) {
		$path = THB_THEME_FOLDER . $file;
	}

	if ( ! empty( $path ) ) {
		require_once( $path );
	}

	return $path;
}

/**
 * Return an array of defined field types.
 *
 * @return array
 */
function thb_field_types() {
	return apply_filters( 'thb_field_types', array() );
}
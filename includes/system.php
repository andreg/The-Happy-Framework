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
 * @since 1.0.0
 * @return array
 */
function thb_field_types() {
	return apply_filters( 'thb_field_types', array() );
}


/**
 * Determines whether or not the current user has the ability to save meta data
 * associated with this post.
 * Thanks to Tom McFarlin: https://gist.github.com/tommcfarlin/4468321
 *
 * @since 1.0.0
 * @param int $post_id The ID of the post being saved.
 * @param string $action The submitted nonce action.
 * @param string $nonce The submitted nonce key.
 * @return boolean Whether or not the user has the ability to save this post.
 */
function thb_user_can_save( $post_id, $action = '', $nonce = 'thb' ) {
	/* Verify the validity of the supplied nonce. */
	$is_valid_nonce = isset( $_POST[$nonce] ) && wp_verify_nonce( $_POST[$nonce], $action );

	/* Preventing to do anything when autosaving, editing a revision or performing an AJAX request. */
	$is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
	$is_ajax     = defined( 'DOING_AJAX' ) && DOING_AJAX;

	/* Check the user has the capability to edit posts. */
	$is_valid_cap 	= current_user_can( get_post_type_object( get_post_type( $post_id ) )->cap->edit_post, $post_id );

	/* Return true if the user is able to save; otherwise, false. */
    return ! ( $is_autosave || $is_revision || $is_ajax ) && $is_valid_nonce && $is_valid_cap;
}
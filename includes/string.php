<?php

/**
 * Check if a string ends with particular substring.
 *
 * @since 1.0.0
 * @param string $haystack The string to search in.
 * @param string $needle The substring to look for.
 * @return boolean
 */
function thb_string_ends_with( $haystack, $needle ) {
	$length = strlen( $needle );

	if ( $length === 0 ) {
		return true;
	}

	return ( substr( $haystack, -$length ) === $needle );
}

/**
 * Check if a string ends with particular substring.
 *
 * @since 1.0.0
 * @param string $haystack The string to search in.
 * @param string $needle The substring to look for.
 * @return boolean
 */
function thb_string_starts_with( $haystack, $needle ) {
	$length = strlen( $needle );
	return ( substr( $haystack, 0, $length ) === $needle );
}

/**
 * Ensure that a string starts with a particular substring.
 *
 * @since 1.0.0
 * @param string $haystack The string to search in.
 * @param string $needle The substring to look for.
 * @return string The modified string, if needed.
 */
function thb_string_ensure_left( $haystack, $needle ) {
	if ( ! thb_string_starts_with( $haystack, $needle ) ) {
		return $needle . $haystack;
	}

	return $haystack;
}

/**
 * Ensure that a string starts with a particular substring.
 *
 * @since 1.0.0
 * @param string $haystack The string to search in.
 * @param string $needle The substring to look for.
 * @return string The modified string, if needed.
 */
function thb_string_ensure_right( $haystack, $needle ) {
	if ( ! thb_string_ends_with( $haystack, $needle ) ) {
		return $haystack . $needle;
	}

	return $haystack;
}
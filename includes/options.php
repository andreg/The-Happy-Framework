<?php

/**
 * Get an option value.
 *
 * @since 1.0.0
 * @param string $name The option name.
 * @return string|boolean
 */
function thb_get_option( $name ) {
    $options = get_option( 'thb_options' );

    if ( ! $options || ! isset( $options[$name] ) ) {
        return false;
    }

    return $options[$name];
}

/**
 * Save an option value.
 *
 * @since 1.0.0
 * @param string $name The option name.
 * @param string|mixed $value The option value.
 */
function thb_save_option( $name, $value ) {
    $options = get_option( 'thb_options' );
    $options[$name] = $value;

    update_option( 'thb_options', $options );
}
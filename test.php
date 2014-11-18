<?php

class THB_TextField extends THB_Field {
	public function __construct( $data )
	{
		parent::__construct( $data );
	}
}

$structure = array(
	'type'   => 'group',
	'handle' => 'options',
	'label'  => 'A group of fields',
	'fields' => array(
		array(
			'type'       => 'text',
			'handle'     => 'test_2',
			'label'      => 'A text field #2',
			'help'       => 'Etiam porta sem malesuada magna mollis euismod.',
		),
	)
);

$thb_meta_box = thb_fw()->admin()->add_meta_box( 'asd', 'Asd', array( 'post', 'page' ), array(
	$structure
) );

add_filter( 'thb_field_types', function( $types ) {
	$types['text'] = 'THB_TextField';
	return $types;
} );
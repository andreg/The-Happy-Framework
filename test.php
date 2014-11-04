<?php

class THB_TextField extends THB_Field {
	public function __construct( $handle )
	{
		parent::__construct( $handle, 'text' );
	}
}

$thb_meta_box = thb_fw()->admin()->add_meta_box( 'asd', 'Asd', array( 'post', 'page' ), array(
	array(
		'type'   => 'text',
		'handle' => 'test',
		'label'  => 'A text field'
	),
	array(
		'type'   => 'group',
		'handle' => 'options',
		'label'  => 'A group of fields',
		'fields' => array(
			array(
				'type'   => 'text',
				'handle' => 'test_2',
				'label'  => 'A text field #2'
			),
			array(
				'type'   => 'text',
				'handle' => 'test_3',
				'label'  => 'A text field #3'
			)
		)
	)
) );

// add_filter( 'thb[post_type:page][metabox:asd]', function( $fields ) {
// 	$fields[] = array(
// 		'type'   => 'text',
// 		'handle' => 'prova',
// 		'label'  => 'Un campo di prova'
// 	);

// 	return $fields;
// } );

add_filter( 'thb_field_types', function( $types ) {
	$types['text'] = 'THB_TextField';
	return $types;
} );
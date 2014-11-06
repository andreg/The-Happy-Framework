<?php

class THB_TextField extends THB_Field {
	public function __construct( $data )
	{
		parent::__construct( $data );
	}
}

class THB_BundleField extends THB_Field {
	public function __construct( $data )
	{
		parent::__construct( $data );

		if ( isset( $data['fields'] ) && is_array( $data['fields'] ) ) {
			$this->_fields = $data['fields'];
		}
	}

	public function render_inner()
	{
		$field_types = thb_field_types();

		foreach ( $this->_fields as $field ) {
			$field_class = $field_types[$field['type']];
			$thb_field = new $field_class( $field );
			$thb_field->render();
		}
	}
}

$thb_meta_box = thb_fw()->admin()->add_meta_box( 'asd', 'Asd', array( 'post', 'page' ), array(
	// array(
	// 	'type'   => 'text',
	// 	'handle' => 'test',
	// 	'label'  => 'A text field'
	// ),
	array(
		'type'   => 'group',
		'handle' => 'options',
		'label'  => 'A group of fields',
		'fields' => array(
			array(
				'type'   => 'text',
				'handle' => 'test_2',
				'label'  => 'A text field #2',
				'help' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
				'default' => 'Bon Jovi'
			),
			array(
				'type'   => 'bundle',
				'handle' => 'test_bundle',
				'label'  => 'A bundle field',
				'fields' => array(
					array(
						'type'   => 'text',
						'handle' => 'test_2',
						'label'  => 'A text field #2',
						'help' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
						'default' => 'Bon Jovi'
					),
					array(
						'type'   => 'text',
						'handle' => 'test_3',
						'label'  => 'A text field #3',
						'default' => 'Stratocaster'
					)
				)
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
	$types['bundle'] = 'THB_BundleField';
	return $types;
} );
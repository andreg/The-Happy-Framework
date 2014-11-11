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
			$field['bundle'] = $this->handle();

			$field_class = $field_types[$field['type']];
			$thb_field = new $field_class( $field );
			$thb_field->render();
		}
	}
}

$structure = array(
	'type'   => 'group',
	'handle' => 'options',
	'label'  => 'A group of fields',
	'fields' => array(
		array(
			'type'   => 'text',
			'handle' => 'test_2',
			'label'  => 'A text field #2',
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
				),
				array(
					'type'   => 'bundle',
					'handle' => 'test_bundle_2',
					'label'  => 'A bundle field',
					'fields' => array(
						array(
							'type'   => 'text',
							'handle' => 'test_4',
							'label'  => 'A text field #2',
						),
						array(
							'type'   => 'text',
							'handle' => 'test_5',
							'label'  => 'A text field #3',
						)
					)
				)
			)
		)
	)
);

$thb_meta_box = thb_fw()->admin()->add_meta_box( 'asd', 'Asd', array( 'post', 'page' ), array(
	$structure
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


// echo "<pre>" . print_r( get_post_meta( 2, 'test_bundle', true ), true ) . "</pre>";

// function thb_sanitize_add( $value ) {
// 	return $value .= '_asd';
// }
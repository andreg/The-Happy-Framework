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
			'type'       => 'text',
			'handle'     => 'test_2',
			'label'      => 'A text field #2',
			'help'       => 'Etiam porta sem malesuada magna mollis euismod.',
			// 'repeatable' => true
		),
		// array(
		// 	'type'   => 'bundle',
		// 	'handle' => 'test_bundle',
		// 	'label'  => 'A bundle field',
		// 	'fields' => array(
		// 		array(
		// 			'type'   => 'text',
		// 			'handle' => 'test_2',
		// 			'label'  => 'A text field #2',
		// 		),
		// 		array(
		// 			'type'   => 'bundle',
		// 			'handle' => 'test_bundle_2',
		// 			'label'  => 'A bundle field',
		// 			'fields' => array(
		// 				array(
		// 					'type'   => 'text',
		// 					'handle' => 'test_4',
		// 					'label'  => 'A text field #2',
		// 				),
		// 				array(
		// 					'type'   => 'text',
		// 					'handle' => 'test_5',
		// 					'label'  => 'A text field #3',
		// 				)
		// 			)
		// 		)
		// 	)
		// )
	)
);

$thb_meta_box = thb_fw()->admin()->add_meta_box( 'asd', 'Asd', array( 'post', 'page' ), array(
	$structure
) );

thb_fw()->admin()->add_script( "thb-admin", THB_FRAMEWORK_URI . 'assets/js/min/admin.min.js' );
thb_fw()->admin()->add_style( "thb-admin", THB_FRAMEWORK_URI . 'assets/css/admin.css' );

add_filter( 'thb_field_types', function( $types ) {
	$types['text'] = 'THB_TextField';
	$types['bundle'] = 'THB_BundleField';
	return $types;
} );
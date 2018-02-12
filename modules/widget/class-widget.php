<?php

/**
 * @class BBSFTemplate
 */
class BBSFTemplate extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct( array(
			'name'            => __( 'S&F Widget', 'sfbb' ),
			'description'     => __( 'Module to display a earch & Filter Widget.', 'sfbb' ),
			'category'        => __( 'SFBB Modules', 'sfbb' ),
			'partial_refresh' => true,
		) );
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module( 'BBSFTemplate', array(
	'general' => array(
		'title'    => __( 'S&F Widget', 'fl-builder' ),
		'sections' => array(
			'general' => array(
				'title'  => '',
				'fields' => array(
					'widget' => array(
						'type'        => 'select',
						'label'       => __( 'Widget', 'sfbb' ),
						'placeholder' => __( 'Select a Widget', 'sfbb' ),
						'options' => load_sf_widgets(),
						'preview'     => array(
							'type' => 'refresh',
						),
					),
					'CSS' => array(
						'type'        => 'code',
						'editor'      => 'CSS',
						'label'       => __( 'CSS', 'sfbb' ),
						'placeholder' => __( 'Enter CSSS', 'sfbb' ),
						'preview'     => array(
							'type' => 'refresh',
						),
					),
				),
			),
		),
	),
) );

function load_sf_widgets() {

	$bbsf = new SFBB_Integration();
	$templates = $bbsf->get_sf_widgets();
	$options   = array(
		0 => '',
	);
	foreach ( $templates as $template ) {
		//$options[ $template['id'] ] = $template['title'].'('. $template['id'].')';
		$options[ $template['id'] ] = $template['title'];
	}

	return $options;
}

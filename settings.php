<?php
//*****************************//
// AMP TEASER settings Start here //
//*****************************//
if ( ! function_exists( 'ampforwp_teaser_settings' ) ) {
	function ampforwp_teaser_settings($sections){

			$sections[] = array(
			      'title'      => __( 'AMP Teaser', 'amp-teaser' ),
			      'icon' => 'el el-view-mode',
						'id'	=> 'ampforwp-teaser-subsection',
			      'desc'  => " ",
						);

			$sections[] = array(
				      		'title'     => __( 'Settings', 'amp-teaser' ),
		 					'id'				=> 'ampforwp-teaser-power',
				      		'subsection'=> true,
				      		'fields'	=>array(
				      			array(
					                    'id'        => 'ampforwp-enable-teaser',
					                    'type'      => 'switch',
					                    'title'     => 'Teaser',
					                    'default'   =>  0,
					                    ),
				      			array(
										'id'       => 'ampforwp-teaser-for',
										'type'     => 'select',
										'title'    => __('Display on Post Types', 'redux-framework-demo'),
										'multi'		=> true,
										'data'		=> 'post_type',
										'required' => array('ampforwp-enable-teaser', '=' , '1'),
										),
				      			array(
				      					'id'        => 'ampforwp-teaser-position',
					                    'type'      => 'select',
					                    'title'     => 'Position',
					                    'options'	=> array(
									                    	'1'		=> '25%',
									                    	'2'		=> '50%',
									                    	'3'		=> '75%',
									                    	'4'		=> '100%'
									                    ),
					                    'default'	=> '1',
					                    'required'  => array('ampforwp-enable-teaser', '=' , '1'),
                                        'desc' => '50% means it will cut the content by 50%'
					                	),
				      			array(
				      					'id'        => 'ampforwp-teaser-button-name',
					                    'type'      => 'text',
					                    'title'     => 'Teaser Button Name',
					                    'required' 	=> array('ampforwp-enable-teaser', '=' , '1'),
					                	),
										
				      		)
			      	);

			return $sections;
	}
}
add_filter("redux/options/redux_builder_amp/sections", 'ampforwp_teaser_settings');


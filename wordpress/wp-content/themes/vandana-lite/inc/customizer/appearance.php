<?php
/**
 * Vandana Lite Appearance Settings
 *
 * @package Vandana_Lite
 */

function vandana_lite_customize_register_appearance( $wp_customize ) {
    
    /** Appearance Settings */
    $wp_customize->add_panel( 
        'appearance_settings',
         array(
            'priority'    => 30,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Appearance Settings', 'vandana-lite' ),
            'description' => __( 'Customize Typography, Background Image & Color.', 'vandana-lite' ),
        ) 
    );
    
    /** Typography */
    $wp_customize->add_section(
        'typography_settings',
        array(
            'title'    => __( 'Typography', 'vandana-lite' ),
            'priority' => 20,
            'panel'    => 'appearance_settings',
        )
    );
    
    /** Primary Font */
    $wp_customize->add_setting(
		'primary_font',
		array(
			'default'			=> 'Nunito Sans',
			'sanitize_callback' => 'vandana_lite_sanitize_select'
		)
	);

	$wp_customize->add_control(
		new Vandana_Lite_Select_Control(
    		$wp_customize,
    		'primary_font',
    		array(
                'label'	      => __( 'Primary Font', 'vandana-lite' ),
                'description' => __( 'Primary font of the site.', 'vandana-lite' ),
    			'section'     => 'typography_settings',
    			'choices'     => vandana_lite_get_all_fonts(),	
     		)
		)
	);
    
    /** Secondary Font */
    $wp_customize->add_setting(
		'secondary_font',
		array(
			'default'			=> 'Halant',
			'sanitize_callback' => 'vandana_lite_sanitize_select'
		)
	);

	$wp_customize->add_control(
		new Vandana_Lite_Select_Control(
    		$wp_customize,
    		'secondary_font',
    		array(
                'label'	      => __( 'Secondary Font', 'vandana-lite' ),
                'description' => __( 'Secondary font of the site.', 'vandana-lite' ),
    			'section'     => 'typography_settings',
    			'choices'     => vandana_lite_get_all_fonts(),	
     		)
		)
	);

    /** Font Size*/
    $wp_customize->add_setting( 
        'font_size', 
        array(
            'default'           => 18,
            'sanitize_callback' => 'vandana_lite_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
        new Vandana_Lite_Slider_Control( 
            $wp_customize,
            'font_size',
            array(
                'section'     => 'typography_settings',
                'label'       => __( 'Font Size', 'vandana-lite' ),
                'description' => __( 'Change the font size of your site.', 'vandana-lite' ),
                'choices'     => array(
                    'min'   => 10,
                    'max'   => 50,
                    'step'  => 1,
                )                 
            )
        )
    );
    
    /** Move Background Image section to appearance panel */
    $wp_customize->get_section( 'colors' )->panel              = 'appearance_settings';
    $wp_customize->get_section( 'colors' )->priority           = 10;
    $wp_customize->get_section( 'background_image' )->panel    = 'appearance_settings';
    $wp_customize->get_section( 'background_image' )->priority = 15;
    
}
add_action( 'customize_register', 'vandana_lite_customize_register_appearance' );
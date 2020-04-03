<?php
/**
 * Customizer settings for Additional Settings
 *
 * @package Mystery Themes
 * @subpackage Editorial
 * @since 1.0.0
 */

add_action( 'customize_register', 'editorial_additional_settings_register' );

function editorial_additional_settings_register( $wp_customize ) {

	/**
     * Add Additional Settings Panel 
     */
    $wp_customize->add_panel( 
        'editorial_additional_settings_panel', 
        array(
            'priority'       => 7,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => __( 'Additional Settings', 'editorial' ),
        ) 
    );
/*--------------------------------------------------------------------------------------------*/
	// Category Color Section
    $wp_customize->add_section(
        'editorial_categories_color_section',
        array(
            'title'         => __( 'Categories Color', 'editorial' ),
            'priority'      => 5,
            'panel'         => 'editorial_additional_settings_panel',
        )
    );

	$priority = 3;
	$categories = get_terms( 'category' ); // Get all Categories
	$wp_category_list = array();

	foreach ( $categories as $category_list ) {

		$wp_customize->add_setting( 
			'editorial_category_color_'.esc_html( strtolower( $category_list->name ) ),
			array(
				'default'              => '#00a9e0',
				'capability'           => 'edit_theme_options',
				'sanitize_callback'    => 'sanitize_hex_color'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 
				'editorial_category_color_'.esc_html( strtolower($category_list->name) ),
				array(
					'label'    => sprintf( esc_html__( ' %s', 'editorial' ), esc_html( $category_list->name ) ),
					'section'  => 'editorial_categories_color_section',
					'priority' => $priority
				)
			)
		);
		$priority++;
	}
/*--------------------------------------------------------------------------------------------*/
	//Social icons
	$wp_customize->add_section(
        'editorial_social_media_section',
        array(
            'title'         => __( 'Social Media', 'editorial' ),
            'priority'      => 10,
            'panel'         => 'editorial_additional_settings_panel',
        )
    );

	//Add Facebook Link
    $wp_customize->add_setting(
        'social_fb_link',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        'social_fb_link',
        array(
            'type' => 'text',
            'priority' => 5,
            'label' => __( 'Facebook', 'editorial' ),
            'description' => __( 'Your Facebook Account URL', 'editorial' ),
            'section' => 'editorial_social_media_section'
        )
    );
    
    //Add twitter Link
    $wp_customize->add_setting(
        'social_tw_link',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        'social_tw_link',
        array(
            'type' => 'text',
            'priority' => 6,
            'label' => __( 'Twitter', 'editorial' ),
            'description' => __( 'Your Twitter Account URL', 'editorial' ),
            'section' => 'editorial_social_media_section'
       )
    );
    
    //Add Google plus Link
    $wp_customize->add_setting(
        'social_gp_link',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        'social_gp_link',
        array(
            'type' => 'text',
            'priority' => 7,
            'label' => __( 'Google Plus', 'editorial' ),
            'description' => __( 'Your Google Plus Account URL', 'editorial' ),
            'section' => 'editorial_social_media_section'
        )
    );
    
    //Add LinkedIn Link
    $wp_customize->add_setting(
        'social_lnk_link',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        'social_lnk_link',
        array(
            'type' => 'text',
            'priority' => 8,
            'label' => __( 'LinkedIn', 'editorial' ),
            'description' => __( 'Your LinkedIn Account URL', 'editorial' ),
            'section' => 'editorial_social_media_section'
        )
    );
    
    //Add youtube Link
    $wp_customize->add_setting(
        'social_yt_link',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        'social_yt_link',
        array(
            'type' => 'text',
            'priority' => 9,
            'label' => __( 'YouTube', 'editorial' ),
            'description' => __( 'Your YouTube Account URL', 'editorial' ),
            'section' => 'editorial_social_media_section'
        )
    );
    
    //Add vimeo Link
    $wp_customize->add_setting(
        'social_vm_link',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        'social_vm_link',
        array(
            'type' => 'text',
            'priority' => 10,
            'label' => __( 'Vimeo', 'editorial' ),
            'description' => __( 'Your Vimeo Account URL', 'editorial' ),
            'section' => 'editorial_social_media_section'
        )
    );

    //Add Pinterest link
    $wp_customize->add_setting(
        'social_pin_link',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        'social_pin_link',
        array(
            'type' => 'text',
            'priority' => 11,
            'label' => __( 'Pinterest', 'editorial' ),
            'description' => __( 'Your Pinterest Account URL', 'editorial' ),
            'section' => 'editorial_social_media_section'
        )
    );

    //Add Instagram link
    $wp_customize->add_setting(
        'social_insta_link',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        'social_insta_link',
        array(
            'type' => 'text',
            'priority' => 12,
            'label' => __( 'Instagram', 'editorial' ),
            'description' => __( 'Your Instagram Account URL', 'editorial' ),
            'section' => 'editorial_social_media_section'
        )
    );

}
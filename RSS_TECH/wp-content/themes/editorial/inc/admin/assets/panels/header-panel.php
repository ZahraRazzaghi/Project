<?php
/**
 * Customizer option for Header sections
 *
 * @package Mystery Themes
 * @subpackage Editorial
 * @since 1.0.0
 */

add_action( 'customize_register', 'editorial_header_settings_register' );

function editorial_header_settings_register( $wp_customize ) {
    $wp_customize->remove_section( 'header_image' );
	/**
	 * Add header panels
	 */
	$wp_customize->add_panel(
	    'editorial_header_settings_panel', 
	    array(
	        'priority'       => 4,
	        'capability'     => 'edit_theme_options',
	        'theme_supports' => '',
	        'title'          => __( 'Header Settings', 'editorial' ),
	    ) 
    );
/*----------------------------------------------------------------------------------------------------*/
    /**
     * Top Header Section
     */
    $wp_customize->add_section(
        'editorial_top_header_section',
        array(
            'title'         => __( 'Top Header Section', 'editorial' ),
            'priority'      => 5,
            'panel'         => 'editorial_header_settings_panel'
        )
    );

    // Display Current Date
    $wp_customize->add_setting(
        'editorial_header_date', 
        array(
			'default' => 'enable',
			'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
			'sanitize_callback' => 'editorial_enable_switch_sanitize'
        )
    );
    $wp_customize->add_control( new Editorial_Customize_Switch_Control(
        $wp_customize,
            'editorial_header_date', 
            array(
    			'type' => 'switch',
    			'label' => __( 'Current Date Option', 'editorial' ),
    			'description' => __( 'Enable/disable current date from top header.', 'editorial' ),
                'priority'      => 4,
    			'section' => 'editorial_top_header_section',
                'choices' => array(
                    'enable' => __( 'Enable', 'editorial' ),
                    'disable' => __( 'Disable', 'editorial' )
                )
    		)
        )
    );

    // Option about top header social icons
    $wp_customize->add_setting(
        'editorial_header_social_option', 
        array(
            'default' => 'enable',
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => 'editorial_enable_switch_sanitize'
        )
    );
    $wp_customize->add_control( new Editorial_Customize_Switch_Control(
        $wp_customize,
            'editorial_header_social_option', 
            array(
                'type' => 'switch',
                'label' => __( 'Social Icon Option', 'editorial' ),
                'description' => __( 'Enable/disable social icons from top header (right).', 'editorial' ),
                'priority'      => 5,
                'section' => 'editorial_top_header_section',
                'choices' => array(
                    'enable' => __( 'Enable', 'editorial' ),
                    'disable' => __( 'Disable', 'editorial' )
                )
            )
        )
    );
/*----------------------------------------------------------------------------------------------------*/
    /**
     * Sticky Header
     */
    $wp_customize->add_section(
        'editorial_sticky_header_section',
        array(
            'title'         => __( 'Sticky Menu', 'editorial' ),
            'priority'      => 10,
            'panel'         => 'editorial_header_settings_panel'
        )
    );

    //Sticky header option
    $wp_customize->add_setting(
        'editorial_sticky_option', 
        array(
            'default' => 'enable',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'editorial_enable_switch_sanitize'
        )
    );
    $wp_customize->add_control( new Editorial_Customize_Switch_Control(
        $wp_customize,
            'editorial_sticky_option', 
            array(
                'type' => 'switch',
                'label' => __( 'Menu Sticky', 'editorial' ),
                'description' => __( 'Enable/disable option for Menu Sticky', 'editorial' ),
                'priority'      => 4,
                'section' => 'editorial_sticky_header_section',
                'choices' => array(
                    'enable' => __( 'Enable', 'editorial' ),
                    'disable' => __( 'Disable', 'editorial' )
                )
            )
        )
    );

/*----------------------------------------------------------------------------------------------------*/
    /**
     * News Ticker section
     */
    $wp_customize->add_section(
        'editorial_news_ticker_section',
        array(
            'title'         => __( 'News Ticker Section', 'editorial' ),
            'priority'      => 15,
            'panel'         => 'editorial_header_settings_panel'
        )
    );

    //Ticker display option
    $wp_customize->add_setting(
        'editorial_ticker_option', 
        array(
            'default' => 'enable',
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => 'editorial_enable_switch_sanitize'
        )
    );
    $wp_customize->add_control( new Editorial_Customize_Switch_Control(
        $wp_customize,
            'editorial_ticker_option', 
            array(
                'type' => 'switch',
                'label' => __( 'News Ticker Option', 'editorial' ),
                'description' => __( 'Enable/disable news ticker at header.', 'editorial' ),
                'priority'      => 4,
                'section' => 'editorial_news_ticker_section',
                'choices' => array(
                    'enable' => __( 'Enable', 'editorial' ),
                    'disable' => __( 'Disable', 'editorial' )
                )
            )
        )
    );

    //Ticker Caption
    $wp_customize->add_setting(
        'editorial_ticker_caption', 
        array(
              'default' => __( 'Latest', 'editorial' ),
              'capability' => 'edit_theme_options',
              'transport'=> 'postMessage',
              'sanitize_callback' => 'editorial_sanitize_text',
            )
    );
    $wp_customize->add_control(
        'editorial_ticker_caption', 
        array(
              'type' => 'text',
              'label' => __( 'News Ticker Caption', 'editorial' ),
              'section' => 'editorial_news_ticker_section',
              'priority' => 5
            )
    );
}
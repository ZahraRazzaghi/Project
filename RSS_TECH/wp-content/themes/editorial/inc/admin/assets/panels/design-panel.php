<?php
/**
 * Customizer option for Design Settings
 *
 * @package Mystery Themes
 * @subpackage Editorial
 * @since 1.0.0
 */

add_action( 'customize_register', 'editorial_design_settings_register' );

function editorial_design_settings_register( $wp_customize ) {

    /**
     * Add Design Panel
     */
    $wp_customize->add_panel(
	    'editorial_design_settings_panel', 
	    array(
	        'priority'       => 6,
	        'capability'     => 'edit_theme_options',
	        'theme_supports' => '',
	        'title'          => __( 'Design Settings', 'editorial' ),
	    ) 
    );

/*--------------------------------------------------------------------------------*/
	/**
	 * Archive page Settings
	 */
	$wp_customize->add_section(
        'editorial_archive_section',
        array(
            'title'         => __( 'Archive Settings', 'editorial' ),
            'priority'      => 10,
            'panel'         => 'editorial_design_settings_panel'
        )
    );

    // Archive page sidebar
    $wp_customize->add_setting(
        'editorial_archive_sidebar',
        array(
            'default' =>'right_sidebar',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'editorial_page_layout_sanitize',
        )
    );

    $wp_customize->add_control( new Editorial_Image_Radio_Control(
        $wp_customize, 
        'editorial_archive_sidebar', 
        array(
            'type'          => 'radio',
            'label'         => __( 'Available Sidebars', 'editorial' ),
            'description'   => __( 'Select sidebar for whole site archives, categories, search page etc.', 'editorial' ),
            'section'       => 'editorial_archive_section',
            'priority'      => 4,
            'choices'       => array(
                    'right_sidebar' => get_template_directory_uri() . '/inc/admin/assets/images/right-sidebar.png',
                    'left_sidebar' => get_template_directory_uri() . '/inc/admin/assets/images/left-sidebar.png',
                    'no_sidebar' => get_template_directory_uri() . '/inc/admin/assets/images/no-sidebar.png',
                    'no_sidebar_center' => get_template_directory_uri() . '/inc/admin/assets/images/no-sidebar-center.png'
                )
           )
        )
    );

    //Archive page layouts
    $wp_customize->add_setting(
        'editorial_archive_layout',
        array(
            'default'           => 'classic',
            'sanitize_callback' => 'editorial_sanitize_archive_layout',
        )
    );
    $wp_customize->add_control(
        'editorial_archive_layout',
        array(
            'type'        => 'radio',
            'label'       => __( 'Archive Page Layout', 'editorial' ),
            'description' => __( 'Choose available layout for all archive pages.', 'editorial' ),
            'section'     => 'editorial_archive_section',            
            'choices' => array(
                'classic'   => __( 'Classic Layout', 'editorial' ),
                'columns'   => __( 'Columns Layout', 'editorial' )
            ),
            'priority'  => 5
        )
    );

/*--------------------------------------------------------------------------------*/
    /**
     * Single post Settings
     */
    $wp_customize->add_section(
        'editorial_single_post_section',
        array(
            'title'         => __( 'Post Settings', 'editorial' ),
            'priority'      => 15,
            'panel'         => 'editorial_design_settings_panel'
        )
    );

    // Archive page sidebar
    $wp_customize->add_setting(
        'editorial_default_post_sidebar',
        array(
            'default' =>'right_sidebar',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'editorial_page_layout_sanitize',
        )
    );

    $wp_customize->add_control( new Editorial_Image_Radio_Control(
        $wp_customize, 
        'editorial_default_post_sidebar', 
        array(
            'type'          => 'radio',
            'label'         => __( 'Available Sidebars', 'editorial' ),
            'description'   => __( 'Select sidebar for whole single post page.', 'editorial' ),
            'section'       => 'editorial_single_post_section',
            'priority'      => 4,
            'choices'       => array(
                    'right_sidebar' => get_template_directory_uri() . '/inc/admin/assets/images/right-sidebar.png',
                    'left_sidebar' => get_template_directory_uri() . '/inc/admin/assets/images/left-sidebar.png',
                    'no_sidebar' => get_template_directory_uri() . '/inc/admin/assets/images/no-sidebar.png',
                    'no_sidebar_center' => get_template_directory_uri() . '/inc/admin/assets/images/no-sidebar-center.png'
                )
           )
        )
    );

    //Author box
    $wp_customize->add_setting(
        'editorial_author_box_option', 
        array(
            'default' => 'show',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'editorial_show_switch_sanitize'
        )
    );
    $wp_customize->add_control( new Editorial_Customize_Switch_Control(
        $wp_customize,
            'editorial_author_box_option', 
            array(
                'type' => 'switch',
                'label' => __( 'Author Option', 'editorial' ),
                'description' => __( 'Enable/disable author information at single post page.', 'editorial' ),
                'priority'      => 5,
                'section' => 'editorial_single_post_section',
                'choices' => array(
                    'show' => __( 'Show', 'editorial' ),
                    'hide' => __( 'Hide', 'editorial' )
                )
            )
        )
    );

    //Related Articles
    $wp_customize->add_setting(
        'editorial_related_articles_option', 
        array(
            'default' => 'enable',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'editorial_enable_switch_sanitize'
        )
    );
    $wp_customize->add_control( new Editorial_Customize_Switch_Control(
        $wp_customize,
            'editorial_related_articles_option', 
            array(
                'type' => 'switch',
                'label' => __( 'Related Articles Option', 'editorial' ),
                'description' => __( 'Enable/disable related articles section at single post page.', 'editorial' ),
                'priority'      => 7,
                'section' => 'editorial_single_post_section',
                'choices' => array(
                    'enable' => __( 'Enable', 'editorial' ),
                    'disable' => __( 'Disable', 'editorial' )
                )
            )
        )
    );

    //Related articles section title
    $wp_customize->add_setting(
        'editorial_related_articles_title', 
        array(
              'default' => __( 'Related Articles', 'editorial' ),
              'capability' => 'edit_theme_options',
              'transport'=> 'postMessage',
              'sanitize_callback' => 'editorial_sanitize_text',
            )
    );
    $wp_customize->add_control(
        'editorial_related_articles_title', 
        array(
              'type' => 'text',
              'label' => __( 'Section Title', 'editorial' ),
              'section' => 'editorial_single_post_section',
              'active_callback'   => 'editorial_related_articles_option_callback',
              'priority' => 8
            )
    );

    // Types of Related articles
    $wp_customize->add_setting(
        'editorial_related_articles_type',
        array(
            'default'           => 'category',
            'sanitize_callback' => 'editorial_sanitize_related_type',
        )
    );
    $wp_customize->add_control(
        'editorial_related_articles_type',
        array(
            'type'        => 'radio',
            'label'       => __( 'Types of Related Articles', 'editorial' ),
            'description' => __( 'Option to display related articles from category/tags.', 'editorial' ),
            'section'     => 'editorial_single_post_section',            
            'choices' => array(
                'category'   => __( 'by Category', 'editorial' ),
                'tag'   => __( 'by Tags', 'editorial' )
            ),
            'active_callback'   => 'editorial_related_articles_option_callback',
            'priority'  => 9
        )
    );
/*--------------------------------------------------------------------------------*/
    /**
     * Single page Settings
     */
    $wp_customize->add_section(
        'editorial_single_page_section',
        array(
            'title'         => __( 'Page Settings', 'editorial' ),
            'priority'      => 20,
            'panel'         => 'editorial_design_settings_panel'
        )
    );

    // Archive page sidebar
    $wp_customize->add_setting(
        'editorial_default_page_sidebar',
        array(
            'default' =>'right_sidebar',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'editorial_page_layout_sanitize',
        )
    );

    $wp_customize->add_control( new Editorial_Image_Radio_Control(
        $wp_customize, 
        'editorial_default_page_sidebar', 
        array(
            'type'          => 'radio',
            'label'         => __( 'Available Sidebars', 'editorial' ),
            'description'   => __( 'Select sidebar for whole single page.', 'editorial' ),
            'section'       => 'editorial_single_page_section',
            'priority'      => 4,
            'choices'       => array(
                    'right_sidebar' => get_template_directory_uri() . '/inc/admin/assets/images/right-sidebar.png',
                    'left_sidebar' => get_template_directory_uri() . '/inc/admin/assets/images/left-sidebar.png',
                    'no_sidebar' => get_template_directory_uri() . '/inc/admin/assets/images/no-sidebar.png',
                    'no_sidebar_center' => get_template_directory_uri() . '/inc/admin/assets/images/no-sidebar-center.png'
                )
           )
        )
    );

/*--------------------------------------------------------------------------------------------------------*/
    /**
     * Footer widget area
     */
    $wp_customize->add_section(
        'editorial_footer_widget_section',
        array(
            'title'         => __( 'Footer Settings', 'editorial' ),
            'priority'      => 25,
            'panel'         => 'editorial_design_settings_panel'
        )
    );
    // Footer widget area
    $wp_customize->add_setting(
        'footer_widget_option',
        array(
            'default' =>'column3',
            'sanitize_callback' => 'editorial_footer_widget_sanitize',
        )
    );
    $wp_customize->add_control(
        'footer_widget_option',
        array(
            'type' => 'radio',
            'priority'    => 4,
            'label' => __( 'Footer Widget Area', 'editorial' ),
            'description' => __( 'Choose option to display number of columns in footer area.', 'editorial' ),
            'section' => 'editorial_footer_widget_section',
            'choices' => array(
                'column1'   => __( 'One Column', 'editorial' ),
                'column2'   => __( 'Two Columns', 'editorial' ),
                'column3'   => __( 'Three Columns', 'editorial' ),
                'column4'   => __( 'Four Columns', 'editorial' ),
            ),
        )
    );

    //Copyright text
    $wp_customize->add_setting(
        'editorial_copyright_text', 
        array(
              'default' => __( '2016 editorial', 'editorial' ),
              'capability' => 'edit_theme_options',
              'transport'=> 'postMessage',
              'sanitize_callback' => 'editorial_sanitize_text',
            )
    );
    $wp_customize->add_control(
        'editorial_copyright_text',
        array(
              'type' => 'text',
              'label' => __( 'Copyright Info', 'editorial' ),
              'section' => 'editorial_footer_widget_section',
              'priority' => 5
            )
    );

}
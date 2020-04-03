<?php
/**
 * Editorial functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Mystery Themes
 * @subpackage Editorial
 * @since 1.0.0
 */

if ( ! function_exists( 'editorial_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function editorial_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Editorial, use a find and replace
	 * to change 'editorial' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'editorial', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for custom logo.
	 */
	add_image_size( 'editorial-site-logo', 400, 175 );
	add_theme_support( 'custom-logo', array( 'size' => 'editorial-site-logo' ) );

	add_image_size( 'editorial-slider-large', 1020, 731, true );
	add_image_size( 'editorial-featured-medium', 420, 307, true );
	add_image_size( 'editorial-featured-long', 427, 631, true );
	add_image_size( 'editorial-block-medium', 464, 290, true );
	add_image_size( 'editorial-block-thumb', 322, 230, true );
	add_image_size( 'editorial-single-large', 1210, 642, true );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'editorial' ),
		'top-header' => esc_html__( 'Top Header Menu', 'editorial' ),
		'footer' => esc_html__( 'Footer Menu', 'editorial' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'editorial_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'editorial_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function editorial_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'editorial_content_width', 640 );

	/**
	 * define theme version variable
	 * @since 1.1.3
	 */
	$editorial_theme_info = wp_get_theme();
	$GLOBALS['editorial_version'] = $editorial_theme_info->get( 'Version' );
}
add_action( 'after_setup_theme', 'editorial_content_width', 0 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Editorial custom functions
 */
require get_template_directory() . '/inc/editorial-functions.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Editorial widgets
 */
require get_template_directory() . '/inc/widgets/editorial-widgets-area.php';
require get_template_directory() . '/inc/widgets/editorial-widget-fields.php';
require get_template_directory() . '/inc/widgets/editorial-featured-slider.php';
require get_template_directory() . '/inc/widgets/editorial-block-grid.php';
require get_template_directory() . '/inc/widgets/editorial-block-column.php';
require get_template_directory() . '/inc/widgets/editorial-ads-banner.php';
require get_template_directory() . '/inc/widgets/editorial-block-layout.php';
require get_template_directory() . '/inc/widgets/editorial-posts-list.php';
require get_template_directory() . '/inc/widgets/editorial-block-list.php';

/**
 * Load metabox
 */
require get_template_directory() . '/inc/admin/assets/metaboxes/editorial-post-metabox.php';

/**
 * Load customizer custom classes
 */
require get_template_directory() . '/inc/admin/assets/editorial-custom-classes.php'; //custom classes

/**
 * Load customizer sanitize
 */
require get_template_directory() . '/inc/admin/assets/editorial-sanitize.php'; //custom classes

/**
 * Load customizer panels
 */
require get_template_directory() . '/inc/admin/assets/panels/general-panel.php'; //General settings panel
require get_template_directory() . '/inc/admin/assets/panels/header-panel.php'; //header settings panel
require get_template_directory() . '/inc/admin/assets/panels/design-panel.php'; //Design Settings panel
require get_template_directory() . '/inc/admin/assets/panels/additional-panel.php'; //Additional settings panel
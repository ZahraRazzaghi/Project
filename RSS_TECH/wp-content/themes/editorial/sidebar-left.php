<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mystery Themes
 * @subpackage Editorial
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'editorial_left_sidebar' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php do_action( 'editorial_before_sidebar' ); ?>
	<?php dynamic_sidebar( 'editorial_left_sidebar' ); ?>
	<?php do_action( 'editorial_after_sidebar' ); ?>
</aside><!-- #secondary -->

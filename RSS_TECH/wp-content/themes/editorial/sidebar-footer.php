<?php
/**
 * The Sidebar containing the footer widget areas.
 *
 * @package Mystery Themes
 * @subpackage Editorial
 * @since 1.0.0
 */

/**
 * The footer widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
 
if( !is_active_sidebar( 'editorial_footer_one' ) &&
	!is_active_sidebar( 'editorial_footer_two' ) &&
    !is_active_sidebar( 'editorial_footer_three' ) &&
    !is_active_sidebar( 'editorial_footer_four' ) ) {
	return;
}
$editorial_footer_layout = get_theme_mod( 'footer_widget_option', 'column3' );
?>
<div id="top-footer" class="footer-widgets-wrapper clearfix  <?php echo esc_attr( $editorial_footer_layout ); ?>">
	<div class="mt-container">
		<div class="footer-widgets-area clearfix">
            <div class="mt-footer-widget-wrapper clearfix">
            		<div class="mt-first-footer-widget mt-footer-widget">
            			<?php
                			if ( !dynamic_sidebar( 'editorial_footer_one' ) ):
                			endif;
            			?>
            		</div>
        		<?php if( $editorial_footer_layout != 'column1' ){ ?>
                    <div class="mt-second-footer-widget mt-footer-widget">
            			<?php
                			if ( !dynamic_sidebar( 'editorial_footer_two' ) ):
                			endif;
            			?>
            		</div>
                <?php } ?>
                <?php if( $editorial_footer_layout == 'column3' || $editorial_footer_layout == 'column4' ){ ?>
                    <div class="mt-third-footer-widget mt-footer-widget">
                       <?php
                           if ( !dynamic_sidebar( 'editorial_footer_three' ) ):
                           endif;
                       ?>
                    </div>
                <?php } ?>
                <?php if( $editorial_footer_layout == 'column4' ){ ?>
                    <div class="mt-fourth-footer-widget mt-footer-widget">
                       <?php
                           if ( !dynamic_sidebar( 'editorial_footer_four' ) ):
                           endif;
                       ?>
                    </div>
                <?php } ?>
            </div><!-- .mt-footer-widget-wrapper -->
		</div><!-- .footer-widgets-area -->
	</div><!-- .nt-container -->
</div><!-- #top-footer -->
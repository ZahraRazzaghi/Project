<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mystery Themes
 * @subpackage Editorial
 * @since 1.0.0
 */

?>
		</div><!--.mt-container-->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
			<?php get_sidebar( 'footer' ); ?>
			<div id="bottom-footer" class="sub-footer-wrapper clearfix">
				<div class="mt-container">
					<div class="site-info">
						<span class="copy-info"><?php echo esc_html( get_theme_mod( 'editorial_copyright_text', __( '2016 editorial', 'editorial' ) ) ); ?></span>
						<span class="sep"> | </span>
						<?php 
							$editorial_theme_author = esc_url( 'wpnovin.com/' );
							printf( esc_html__( 'Editorial by %1$s.', 'editorial' ), '<a href="'.$editorial_theme_author.'" rel="designer">نوین وردپرس</a>' ); 
						?>
					</div><!-- .site-info -->
					<nav id="footer-navigation" class="sub-footer-navigation" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container_class' => 'footer-menu', 'fallback_cb' => false, 'items_wrap' => '<ul>%3$s</ul>' ) ); ?>
					</nav>
				</div>
			</div><!-- .sub-footer-wrapper -->
	</footer><!-- #colophon -->
	<div id="mt-scrollup" class="animated arrow-hide"><i class="fa fa-chevron-up"></i></div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

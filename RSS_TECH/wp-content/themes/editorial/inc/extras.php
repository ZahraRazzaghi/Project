<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Mystery Themes
 * @subpackage Editorial
 * @since 1.0.0
 */

/**
 * Adds custom contain in head sections
 */
if( ! function_exists( 'editorial_categories_color' ) ):
    function editorial_categories_color() {

        $mt_theme_color = esc_attr( get_theme_mod( 'editorial_theme_color', '#f54337' ) );
        $get_categories = get_terms( 'category', array( 'hide_empty' => false ) );
        $cat_color_css = '';

        foreach( $get_categories as $category ){

            $cat_color = esc_attr( get_theme_mod( 'editorial_category_color_'.strtolower( $category->name ), $mt_theme_color ) );
            $cat_hover_color = esc_attr( editorial_hover_color( $cat_color, '-50' ) );
            $cat_id = esc_attr( $category->term_id );
            
            if( !empty( $cat_color ) ) {
                $cat_color_css .= ".category-button.mt-cat-".$cat_id." a { background: ". $cat_color ."}\n";

                $cat_color_css .= ".category-button.mt-cat-".$cat_id." a:hover { background: ". $cat_hover_color ."}\n";

                $cat_color_css .= ".block-header.mt-cat-".$cat_id." { border-left: 2px solid ".$cat_color." }\n";
                 
                $cat_color_css .= ".archive .page-header.mt-cat-".$cat_id." { border-left: 4px solid ".$cat_color." }\n";

                $cat_color_css .= "#site-navigation ul li.mt-cat-".$cat_id." { border-bottom-color: ".$cat_color." }\n";
            }
        }

        $mt_dynamic_css = '';

        $mt_dynamic_css .= ".navigation .nav-links a,.bttn,button,input[type='button'],input[type='reset'],input[type='submit'],.navigation .nav-links a:hover,.bttn:hover,button,input[type='button']:hover,input[type='reset']:hover,input[type='submit']:hover,.edit-link .post-edit-link ,.reply .comment-reply-link,.home-icon,.search-main,.header-search-wrapper .search-form-main .search-submit,.mt-slider-section .bx-controls a:hover,.widget_search .search-submit,.error404 .page-title,.archive.archive-classic .entry-title a:after,#mt-scrollup,.widget_tag_cloud .tagcloud a:hover,.sub-toggle,#site-navigation ul > li:hover > .sub-toggle, #site-navigation ul > li.current-menu-item .sub-toggle, #site-navigation ul > li.current-menu-ancestor .sub-toggle{ background:". $mt_theme_color ."}\n";

        $mt_dynamic_css .= ".navigation .nav-links a,.bttn,button,input[type='button'],input[type='reset'],input[type='submit'],.widget_search .search-submit,.widget_tag_cloud .tagcloud a:hover{ border-color:". $mt_theme_color ."}\n";

        $mt_dynamic_css .= ".comment-list .comment-body ,.header-search-wrapper .search-form-main{ border-top-color:". $mt_theme_color ."}\n";

        $mt_dynamic_css .= "#site-navigation ul li,.header-search-wrapper .search-form-main:before{ border-bottom-color:". $mt_theme_color ."}\n";

        $mt_dynamic_css .= ".archive .page-header,.block-header, .widget .widget-title-wrapper, .related-articles-wrapper .widget-title-wrapper{ border-left-color:". $mt_theme_color ."}\n";

        $mt_dynamic_css .= "a,a:hover,a:focus,a:active,.entry-footer a:hover,.comment-author .fn .url:hover,#cancel-comment-reply-link,#cancel-comment-reply-link:before, .logged-in-as a,.top-menu ul li a:hover,#footer-navigation ul li a:hover,#site-navigation ul li a:hover,#site-navigation ul li.current-menu-item a,.mt-slider-section .slide-title a:hover,.featured-post-wrapper .featured-title a:hover,.editorial_block_grid .post-title a:hover,.slider-meta-wrapper span:hover,.slider-meta-wrapper a:hover,.featured-meta-wrapper span:hover,.featured-meta-wrapper a:hover,.post-meta-wrapper > span:hover,.post-meta-wrapper span > a:hover ,.grid-posts-block .post-title a:hover,.list-posts-block .single-post-wrapper .post-content-wrapper .post-title a:hover,.column-posts-block .single-post-wrapper.secondary-post .post-content-wrapper .post-title a:hover,.widget a:hover,.widget a:hover::before,.widget li:hover::before,.entry-title a:hover,.entry-meta span a:hover,.post-readmore a:hover,.archive-classic .entry-title a:hover,
            .archive-columns .entry-title a:hover,.related-posts-wrapper .post-title a:hover,.block-header .block-title a:hover,.widget .widget-title a:hover,.related-articles-wrapper .related-title a:hover { color:". $mt_theme_color ."}\n";
?>
            <style type="text/css">
                <?php 
                    if( !empty( $cat_color_css ) ) {
                        echo $cat_color_css;
                    }

                    if( !empty( $mt_dynamic_css ) ) {
                        echo $mt_dynamic_css;
                    }
                ?>
            </style>
<?php
        }
endif;
add_action( 'wp_head', 'editorial_categories_color' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function editorial_body_classes( $classes ) {

    global $post;
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	/**
     * option for web site layout 
     */
    $editorial_website_layout = esc_attr( get_theme_mod( 'site_layout_option', 'fullwidth_layout' ) );
    
    if( !empty( $editorial_website_layout ) ) {
        $classes[] = $editorial_website_layout;
    }

    /**
     * sidebar option for post/page/archive 
     */
    if( is_single() || is_page() ) {
        $sidebar_meta_option = esc_attr( get_post_meta( $post->ID, 'editorial_sidebar_location', true ) );
    }
     
    if( is_home() ) {
        $set_id = esc_attr( get_option( 'page_for_posts' ) );
		$sidebar_meta_option = esc_attr( get_post_meta( $set_id, 'editorial_sidebar_location', true ) );
    }
    
    if( empty( $sidebar_meta_option ) || is_archive() || is_search() ) {
        $sidebar_meta_option = 'default_sidebar';
    }
    $editorial_archive_sidebar = esc_attr( get_theme_mod( 'editorial_archive_sidebar', 'right_sidebar' ) );
    $editorial_post_default_sidebar = esc_attr( get_theme_mod( 'editorial_default_post_sidebar', 'right_sidebar' ) );        
    $editorial_page_default_sidebar = esc_attr( get_theme_mod( 'editorial_default_page_sidebar', 'right_sidebar' ) );
    
    if( $sidebar_meta_option == 'default_sidebar' ) {
        if( is_single() ) {
            if( $editorial_post_default_sidebar == 'right_sidebar' ) {
                $classes[] = 'right-sidebar';
            } elseif( $editorial_post_default_sidebar == 'left_sidebar' ) {
                $classes[] = 'left-sidebar';
            } elseif( $editorial_post_default_sidebar == 'no_sidebar' ) {
                $classes[] = 'no-sidebar';
            } elseif( $editorial_post_default_sidebar == 'no_sidebar_center' ) {
                $classes[] = 'no-sidebar-center';
            }
        } elseif( is_page() ) {
            if( $editorial_page_default_sidebar == 'right_sidebar' ) {
                $classes[] = 'right-sidebar';
            } elseif( $editorial_page_default_sidebar == 'left_sidebar' ) {
                $classes[] = 'left-sidebar';
            } elseif( $editorial_page_default_sidebar == 'no_sidebar' ) {
                $classes[] = 'no-sidebar';
            } elseif( $editorial_page_default_sidebar == 'no_sidebar_center' ) {
                $classes[] = 'no-sidebar-center';
            }
        } elseif( $editorial_archive_sidebar == 'right_sidebar' ) {
            $classes[] = 'right-sidebar';
        } elseif( $editorial_archive_sidebar == 'left_sidebar' ) {
            $classes[] = 'left-sidebar';
        } elseif( $editorial_archive_sidebar == 'no_sidebar' ) {
            $classes[] = 'no-sidebar';
        } elseif( $editorial_archive_sidebar == 'no_sidebar_center' ) {
            $classes[] = 'no-sidebar-center';
        }
    } elseif( $sidebar_meta_option == 'right_sidebar' ) {
        $classes[] = 'right-sidebar';
    } elseif( $sidebar_meta_option == 'left_sidebar' ) {
        $classes[] = 'left-sidebar';
    } elseif( $sidebar_meta_option == 'no_sidebar' ) {
        $classes[] = 'no-sidebar';
    } elseif( $sidebar_meta_option == 'no_sidebar_center' ) {
        $classes[] = 'no-sidebar-center';
    }

    $editorial_archive_layout = get_theme_mod( 'editorial_archive_layout', 'classic' );
    if( !empty( $editorial_archive_layout ) ) {
        $classes[] = 'archive-'.$editorial_archive_layout;
    }

	return $classes;
}
add_filter( 'body_class', 'editorial_body_classes' );

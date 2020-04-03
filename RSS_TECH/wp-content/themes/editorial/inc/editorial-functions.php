<?php
/**
 *  Define extra or custom functions
 *
 * @package Mystery Themes
 * @subpackage Editorial
 * @since 1.0.0
 */

/**
 * Enqueue Scripts and styles for admin
 */
function editorial_admin_scripts_style( $hook ) {

	global $editorial_version;

	if ( 'widgets.php' != $hook && 'customize.php' != $hook ) {
        return;
    }

	if ( function_exists( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
	}

    wp_register_script( 'editorial-media-uploader', get_template_directory_uri() . '/inc/admin/js/media-uploader.js', array('jquery'), 1.70 );
    wp_enqueue_script( 'editorial-media-uploader' );
    wp_localize_script( 'editorial-media-uploader', 'editorial_l10n', array(
        'upload' => __( 'Upload', 'editorial' ),
        'remove' => __( 'Remove', 'editorial' )
    ));

	wp_enqueue_script( 'editorial-admin-script', get_template_directory_uri() .'/inc/admin/js/admin-script.js', array('jquery'), esc_attr( $editorial_version ), true );

	wp_enqueue_style( 'editorial-admin-style', get_template_directory_uri() .'/inc/admin/css/admin-style.css', array(), esc_attr( $editorial_version ) );
}
add_action( 'admin_enqueue_scripts', 'editorial_admin_scripts_style' );

/**
 * Enqueue scripts and styles.
 */
function editorial_scripts() {

	global $editorial_version;

	$query_args = array(
            'family' => 'Titillium+Web:400,600,700,300&subset=latin,latin-ext',
        );

	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/assets/library/font-awesome/css/font-awesome.min.css', array(), '4.5.0' );

	wp_enqueue_style( 'editorial-google-font', add_query_arg( $query_args, "//fonts.googleapis.com/css" ) );

	wp_enqueue_style( 'editorial-style', get_stylesheet_uri(), array(), esc_attr( $editorial_version ) );
    
    wp_enqueue_style( 'editorial-responsive', get_template_directory_uri().'/assets/css/editorial-responsive.css', array(), esc_attr( $editorial_version ) );

	wp_enqueue_script( 'jquery-bxslider', get_template_directory_uri() . '/assets/library/bxslider/jquery.bxslider.min.js', array( 'jquery' ), '4.1.2', true );

	$menu_sticky_option = get_theme_mod( 'editorial_sticky_option', 'enable' );
	if ( $menu_sticky_option != 'disable' ) {
          wp_enqueue_script( 'jquery-sticky', get_template_directory_uri(). '/assets/library/sticky/jquery.sticky.js', array( 'jquery' ), '20150416', true );
    
          wp_enqueue_script( 'editorial-sticky-menu-setting', get_template_directory_uri(). '/assets/library/sticky/sticky-setting.js', array( 'jquery-sticky' ), '20150309', true );
    }

	wp_enqueue_script( 'editorial-custom-script', get_template_directory_uri() . '/assets/js/custom-script.js', array( 'jquery-bxslider' ), esc_attr( $editorial_version ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'editorial_scripts' );

/*------------------------------------------------------------------------------------------------*/
/**
 * Current date at top header
 */
add_action( 'editorial_current_date', 'editorial_current_date_hook' );
if( ! function_exists( 'editorial_current_date_hook' ) ):
	function editorial_current_date_hook() {
		$date_option = get_theme_mod( 'editorial_header_date', 'enable' );
		if( $date_option != 'disable' ) {
?>
			<div class="date-section">
				<?php echo esc_html( date('l, F d, Y') ); ?>
			</div>
<?php
		}
	}
endif;

/*------------------------------------------------------------------------------------------------*/
/**
 * News Ticker
 */
add_action( 'editorial_news_ticker', 'editorial_news_ticker_hook' );
if( ! function_exists( 'editorial_news_ticker_hook' ) ):
	function editorial_news_ticker_hook() {
		$editorial_ticker_option = get_theme_mod( 'editorial_ticker_option', 'enable' );
		if( $editorial_ticker_option != 'disable' && is_front_page() ) {
			$editorial_ticker_caption = get_theme_mod( 'editorial_ticker_caption', __( 'Latest', 'editorial' ) );
?>
			<div class="editorial-ticker-wrapper">
				<div class="mt-container">
					<span class="ticker-caption"><?php echo esc_html( $editorial_ticker_caption ); ?></span>
					<div class="ticker-content-wrapper">
						<?php
							$ticker_args = editorial_query_args( $cat_id = null, 5 );
							$ticker_query = new WP_Query( $ticker_args );
							if( $ticker_query->have_posts() ) {
								echo '<ul id="mt-newsTicker" class="cS-hidden">';
								while( $ticker_query->have_posts() ) {
									$ticker_query->the_post();
						?>			
									<li>
										<div class="news-post"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></div>
									</li>
						<?php
								}
								echo '</ul>';
							}
						?>
					</div>
				</div><!-- .mt-container -->
			</div><!-- .editorial-ticker-wrapper-->
<?php
		}
	}
endif;

/*------------------------------------------------------------------------------------------------*/
/**
 * Define categories lists in array
 */
$editorial_categories = get_categories( array( 'hide_empty' => 0 ) );
foreach ( $editorial_categories as $editorial_category ) {
	$editorial_category_array[$editorial_category->term_id] = $editorial_category->cat_name;
}

//categories in dropdown
$editorial_category_dropdown['0'] = __( 'Select Category', 'editorial' );
foreach ( $editorial_categories as $editorial_category ) {
	$editorial_category_dropdown[$editorial_category->term_id] = $editorial_category->cat_name;
}

//no of columns
$editorial_grid_columns = array(
						''	=> __( 'Select No.of Column', 'editorial' ),
						'2' => __( '2 Columns', 'editorial' ),
						'3'	=> __( '3 Columns', 'editorial' ),
						'4'	=> __( '4 Columns', 'editorial' )
					);

/*------------------------------------------------------------------------------------------------*/
/**
 * Custom function for wp_query args 
 */
if( ! function_exists( 'editorial_query_args' ) ):
	function editorial_query_args( $cat_id, $post_count = null ) {
		if( !empty( $cat_id ) ) {
			$editorial_args = array(
						'post_type' 	=> 'post',
						'category__in'	=> $cat_id,
						'posts_per_page'=> $post_count
					);
		} else {
			$editorial_args = array(
						'post_type'		=> 'post',						
						'posts_per_page'=> $post_count,
						'ignore_sticky_posts' => 1
					);
		}
		return $editorial_args;
	}
endif;

/*------------------------------------------------------------------------------------------------*/
/**
 * block widget title
 */
if( ! function_exists( 'editorial_block_title' ) ):
	function editorial_block_title( $block_title, $block_cat_id ) {
		$block_cat_name = get_cat_name( $block_cat_id );
		$cat_id_class = '';
		if( !empty( $block_cat_id ) ) {
			$cat_id_class = 'mt-cat-'. $block_cat_id;
			$cat_link = get_category_link( $block_cat_id );
		}
		if( !empty( $block_title ) ) {
			$mt_widget_title = $block_title;
		} elseif( !empty( $block_cat_name ) ) {
			$mt_widget_title = $block_cat_name;			
		} else {
			$mt_widget_title = '';
		}
?>
		<div class="block-header <?php echo esc_attr( $cat_id_class ); ?>">
			<h3 class="block-title">
				<?php 
					if( !empty( $block_cat_id ) ) {
				?>
						<a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $mt_widget_title ); ?></a>
				<?php
					} else {
						echo esc_html( $mt_widget_title );
					}
				?>
			</h3>
		</div>
<?php
	}
endif;

/*------------------------------------------------------------------------------------------------*/
/**
 * Posts Categories with dynamic colors
 */
add_action( 'editorial_post_categories', 'editorial_post_categories_hook' );
if( ! function_exists( 'editorial_post_categories_hook' ) ):
	function editorial_post_categories_hook() {
		global $post;
		$post_id = $post->ID;
		$categories_list = get_the_category($post_id);
		if( !empty( $categories_list ) ) {
?>
		<div class="post-cat-list">
			<?php 
				foreach ( $categories_list as $cat_data ) {
					$cat_name = $cat_data->name;
					$cat_id = $cat_data->term_id;
					$cat_link = get_category_link( $cat_id );
			?>
				<span class="category-button mt-cat-<?php echo esc_attr( $cat_id ); ?>"><a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $cat_name ); ?></a></span>
			<?php 
				}
			?>
		</div>
<?php
		}
	}
endif;

/*------------------------------------------------------------------------------------------------*/
/**
 * widget posts excerpt in words
 */
if( ! function_exists( 'editorial_post_excerpt' ) ):
    function editorial_post_excerpt( $content, $word_limit ) {
        $get_content = strip_tags( $content );
        $strip_content = strip_shortcodes( $get_content );
        $excerpt_words = explode( ' ', $strip_content );    
        return implode( ' ', array_slice( $excerpt_words, 0, $word_limit ) );
    }
endif;

/*------------------------------------------------------------------------------------------------*/
/**
 * Define function to show the social media icons
 */
if( ! function_exists( 'editorial_social_icons' ) ):
	function editorial_social_icons() {
		$social_fb_link = get_theme_mod( 'social_fb_link', 'https://facebook.com/' );
        $social_tw_link = get_theme_mod( 'social_tw_link', 'https://twitter.com/' );
        $social_gp_link = get_theme_mod( 'social_gp_link', 'https://plus.google.com/' );
        $social_lnk_link = get_theme_mod( 'social_lnk_link', 'https://linkedin.com/' );
        $social_yt_link = get_theme_mod( 'social_yt_link', 'https://youtube.com/' );
        $social_vm_link = get_theme_mod( 'social_vm_link', 'https://vimeo.com/' );
        $social_pin_link = get_theme_mod( 'social_pin_link', 'https://www.pinterest.com/' );
        $social_insta_link = get_theme_mod( 'social_insta_link', 'https://www.instagram.com/' );

        $social_fb_icon	= 'fa-facebook';
        $social_fb_icon	= apply_filters( 'social_fb_icon', $social_fb_icon );
        
        $social_tw_icon	= 'fa-twitter';
        $social_tw_icon	= apply_filters( 'social_tw_icon', $social_tw_icon );

        $social_gp_icon	= 'fa-google-plus';
        $social_gp_icon	= apply_filters( 'social_gp_icon', $social_gp_icon );

        $social_lnk_icon	= 'fa-linkedin';
        $social_lnk_icon	= apply_filters( 'social_lnk_icon', $social_lnk_icon );

        $social_yt_icon	= 'fa-youtube';
        $social_yt_icon	= apply_filters( 'social_yt_icon', $social_yt_icon );

        $social_vm_icon	= 'fa-vimeo';
        $social_vm_icon	= apply_filters( 'social_vm_icon', $social_vm_icon );

        $social_pin_icon	= 'fa-pinterest';
        $social_pin_icon	= apply_filters( 'social_pin_icon', $social_pin_icon );

        $social_insta_icon	= 'fa-instagram';
        $social_insta_icon = apply_filters( 'social_insta_icon', $social_insta_icon );

        if( !empty( $social_fb_link ) ) {
        	echo '<span class="social-link"><a href="'. esc_url( $social_fb_link ) .'" target="_blank"><i class="fa '. esc_attr( $social_fb_icon ) .'"></i></a></span>';
        }
        if( !empty( $social_tw_link ) ) {
        	echo '<span class="social-link"><a href="'. esc_url( $social_tw_link ) .'" target="_blank"><i class="fa '. esc_attr( $social_tw_icon ) .'"></i></a></span>';
        }
        if( !empty( $social_gp_link ) ) {
        	echo '<span class="social-link"><a href="'. esc_url( $social_gp_link ) .'" target="_blank"><i class="fa '. esc_attr( $social_gp_icon ) .'"></i></a></span>';
        }
        if( !empty( $social_lnk_link ) ) {
        	echo '<span class="social-link"><a href="'. esc_url( $social_lnk_link ) .'" target="_blank"><i class="fa '. esc_attr( $social_lnk_icon ) .'"></i></a></span>';
        }
        if( !empty( $social_yt_link ) ) {
        	echo '<span class="social-link"><a href="'. esc_url( $social_yt_link ) .'" target="_blank"><i class="fa '. esc_attr( $social_yt_icon ) .'"></i></a></span>';
        }
        if( !empty( $social_vm_link ) ) {
        	echo '<span class="social-link"><a href="'. esc_url( $social_vm_link ) .'" target="_blank"><i class="fa '. esc_attr( $social_vm_icon ) .'"></i></a></span>';
        }
        if( !empty( $social_pin_link ) ) {
        	echo '<span class="social-link"><a href="'. esc_url( $social_pin_link ) .'" target="_blank"><i class="fa '. esc_attr( $social_pin_icon ) .'"></i></a></span>';
        }
        if( !empty( $social_insta_link ) ) {
        	echo '<span class="social-link"><a href="'. esc_url( $social_insta_link ) .'" target="_blank"><i class="fa '. esc_attr( $social_insta_icon ) .'"></i></a></span>';
        }
	}
endif;

/*------------------------------------------------------------------------------------------------*/
/**
 * Top header social icon section
 */
add_action( 'editorial_top_social_icons', 'editorial_top_social_icons_hook' );
if( ! function_exists('editorial_top_social_icons_hook'  ) ):
	function editorial_top_social_icons_hook() {
		$top_social_icons = get_theme_mod( 'editorial_header_social_option', 'enable' );
		if( $top_social_icons != 'disable' ) {
?>
			<div class="top-social-wrapper">
				<?php editorial_social_icons(); ?>
			</div><!-- .top-social-wrapper -->
<?php
		}
	}
endif;

/*------------------------------------------------------------------------------------------------*/
/**
 * Add cat id in menu class
 */
function editorial_category_nav_class( $classes, $item ){
    if( 'category' == $item->object ){
        $category = get_category( $item->object_id );
        $classes[] = 'mt-cat-' . $category->term_id;
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'editorial_category_nav_class', 10, 2 );

/*------------------------------------------------------------------------------------------------*/
if( ! function_exists( 'editorial_hover_color' ) ) :
/**
 * Generate darker color
 * Source: http://stackoverflow.com/questions/3512311/how-to-generate-lighter-darker-color-with-php
 */
function editorial_hover_color( $hex, $steps ) {
	// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max( -255, min( 255, $steps ) );

	// Normalize into a six character long hex string
	$hex = str_replace( '#', '', $hex );
	if ( strlen( $hex ) == 3) {
		$hex = str_repeat( substr( $hex,0,1 ), 2 ).str_repeat( substr( $hex, 1, 1 ), 2 ).str_repeat( substr( $hex,2,1 ), 2 );
	}

	// Split into three parts: R, G and B
	$color_parts = str_split( $hex, 2 );
	$return = '#';

	foreach ( $color_parts as $color ) {
		$color   = hexdec( $color ); // Convert to decimal
		$color   = max( 0, min( 255, $color + $steps ) ); // Adjust color
		$return .= str_pad( dechex( $color ), 2, '0', STR_PAD_LEFT ); // Make two char hex code
	}

	return $return;
}
endif;

/*------------------------------------------------------------------------------------------------*/
/**
 * Function define about page/post/archive sidebar
 */
if( ! function_exists( 'editorial_sidebar' ) ):
function editorial_sidebar() {
    global $post;
    if( is_single() || is_page() ) {
        $sidebar_meta_option = get_post_meta( $post->ID, 'editorial_sidebar_location', true );
    }
     
    if( is_home() ) {
        $set_id = get_option( 'page_for_posts' );
		$sidebar_meta_option = get_post_meta( $set_id, 'editorial_sidebar_location', true );
    }
    
    if( empty( $sidebar_meta_option ) || is_archive() || is_search() ) {
        $sidebar_meta_option = 'default_sidebar';
    }
    
    $editorial_archive_sidebar = get_theme_mod( 'editorial_archive_sidebar', 'right_sidebar' );
    $editorial_post_default_sidebar = get_theme_mod( 'editorial_default_post_sidebar', 'right_sidebar' );
    $editorial_page_default_sidebar = get_theme_mod( 'editorial_default_page_sidebar', 'right_sidebar' );
    
    if( $sidebar_meta_option == 'default_sidebar' ) {
        if( is_single() ) {
            if( $editorial_post_default_sidebar == 'right_sidebar' ) {
                get_sidebar();
            } elseif( $editorial_post_default_sidebar == 'left_sidebar' ) {
                get_sidebar( 'left' );
            }
        } elseif( is_page() ) {
            if( $editorial_page_default_sidebar == 'right_sidebar' ) {
                get_sidebar();
            } elseif( $editorial_page_default_sidebar == 'left_sidebar' ) {
                get_sidebar( 'left' );
            }
        } elseif( $editorial_archive_sidebar == 'right_sidebar' ) {
            get_sidebar();
        } elseif( $editorial_archive_sidebar == 'left_sidebar' ) {
            get_sidebar( 'left' );
        }
    } elseif( $sidebar_meta_option == 'right_sidebar' ) {
        get_sidebar();
    } elseif( $sidebar_meta_option == 'left_sidebar' ) {
        get_sidebar( 'left' );
    }
}
endif;

/*------------------------------------------------------------------------------------------------*/
/**
 * Get author info
 */
add_action( 'editorial_author_box', 'editorial_author_box_hook' );
if( ! function_exists('editorial_author_box_hook') ):
	function editorial_author_box_hook() {
		global $post;
        $author_id = $post->post_author;
        $author_avatar = get_avatar( $author_id, '132' );
        $author_nickname = get_the_author_meta( 'display_name' );
        $editorial_author_option = get_theme_mod( 'editorial_author_box_option', 'show' );
        if( $editorial_author_option != 'hide' ) {
?>
            <div class="editorial-author-wrapper clearfix">
                <div class="author-avatar">
                    <a class="author-image" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>"><?php echo $author_avatar; ?></a>
                </div><!-- .author-avatar -->
                <div class="author-desc-wrapper">                
                    <a class="author-title" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>"><?php echo esc_html( $author_nickname ); ?></a>
                    <div class="author-description"><?php echo get_the_author_meta('description');?></div>
                    <a href="<?php echo esc_url( get_the_author_meta( 'user_url' ) );?>" target="_blank"><?php echo esc_url( get_the_author_meta( 'user_url' ) );?></a>
                </div><!-- .author-desc-wrapper-->
            </div><!--editorial-author-wrapper-->
<?php
        }
	}
endif;

/*------------------------------------------------------------------------------------------------*/
/**
 * Related articles
 */
add_action( 'editoral_related_articles', 'editoral_related_articles_hook' );
if( ! function_exists( 'editoral_related_articles_hook' ) ):
	function editoral_related_articles_hook() {
		$editorial_related_option = esc_attr( get_theme_mod( 'editorial_related_articles_option', 'enable' ) );
		$editorial_related_title = get_theme_mod( 'editorial_related_articles_title', __( 'Related Articles', 'editorial' ) );
		if( $editorial_related_option != 'disable' ) {
	?>
			<div class="related-articles-wrapper">
				<h2 class="related-title"><?php echo esc_html( $editorial_related_title ); ?></h2>
				<?php
					global $post;
	                if( empty( $post ) ) {
	                    $post_id = '';
	                } else {
	                    $post_id = $post->ID;
	                }

	                $editorial_related_type = get_theme_mod( 'editorial_related_articles_type', 'category' );
	                $related_post_count = 3;
	                $related_post_count = apply_filters( 'related_posts_count', $related_post_count );

	                // Define related post arguments
	                $related_args = array(
	                    'no_found_rows'            => true,
	                    'update_post_meta_cache'   => false,
	                    'update_post_term_cache'   => false,
	                    'ignore_sticky_posts'      => 1,
	                    'orderby'                  => 'rand',
	                    'post__not_in'             => array( $post_id ),
	                    'posts_per_page'           => $related_post_count
	                );

	                
	                if ( $editorial_related_type == 'tag' ) {
	                    $tags = wp_get_post_tags( $post_id );
	                    if ( $tags ) {
	                        $tag_ids = array();
	                        foreach( $tags as $tag_ed ) {
	                        	$tag_ids[] = $tag_ed->term_id;
	                        }
	                        $related_args['tag__in'] = $tag_ids;
	                    }
	                } else {
	                    $categories = get_the_category( $post_id );
	                    if ( $categories ) {
	                        $category_ids = array();
	                        foreach( $categories as $category_ed ) {
	                            $category_ids[] = $category_ed->term_id;
	                        }
	                        $related_args['category__in'] = $category_ids;
	                    }
	                }

	                $related_query = new WP_Query( $related_args );
	                if( $related_query->have_posts() ) {
	                    echo '<div class="related-posts-wrapper clearfix">';
	                    while( $related_query->have_posts() ) {
	                        $related_query->the_post();
				?>
							<div class="single-post-wrap">
	                            <div class="post-thumb-wrapper">
                                    <a href="<?php the_permalink();?>" title="<?php the_title();?>">
                                        <figure><?php the_post_thumbnail( 'editorial-block-medium' ); ?></figure>
                                    </a>
                                </div><!-- .post-thumb-wrapper -->
                                <div class="related-content-wrapper">
                                    <?php do_action( 'editorial_post_categories' ); ?>
                                    <h3 class="post-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
                                    <div class="post-meta-wrapper">
                                    	<?php editorial_posted_on(); ?>
                                    </div>
                                    <?php the_excerpt(); ?>
                                </div><!-- related-content-wrapper -->
	                        </div><!--. single-post-wrap -->
	            <?php
                    	}
                    	echo '</div>';
                	}
                	wp_reset_postdata();
        		?>
			</div><!-- .related-articles-wrapper -->
	<?php
		}
	}
endif;

/*------------------------------------------------------------------------------------------------*/
/**
 * Filter the category title
 */
add_filter( 'get_the_archive_title', function ( $title ) {
    if( is_category() ) {
        $title = single_cat_title( '', false );
    }
    return $title;
});
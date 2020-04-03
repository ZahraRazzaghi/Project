<?php
/**
 * Editorial: Posts List
 *
 * Widget show latest or random posts in list view
 *
 * @package Mystery Themes
 * @subpackage Editorial
 * @since 1.0.0
 */

add_action( 'widgets_init', 'editorial_register_posts_list_widget' );

function editorial_register_posts_list_widget() {
	register_widget( 'editorial_posts_list' );
}

class Editorial_Posts_List extends WP_widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'editorial_posts_list',
            'description' => __( 'Display latest or random posts in list view.', 'editorial' )
        );
        parent::__construct( 'editorial_posts_list', __( 'Editorial: Posts Lists', 'editorial' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {

    	$editorial_post_list_option = array(
    					'latest' => __( 'Latest Posts', 'editorial' ),
    					'random' => __( 'Random Posts', 'editorial' )
    					);
        
        $fields = array(

            'editorial_block_title' => array(
                'editorial_widgets_name'         => 'editorial_block_title',
                'editorial_widgets_title'        => __( 'Widget Title', 'editorial' ),
                'editorial_widgets_field_type'   => 'text'
            ),

            'editorial_block_posts_count' => array(
                'editorial_widgets_name'         => 'editorial_block_posts_count',
                'editorial_widgets_title'        => __( 'No. of Posts', 'editorial' ),
                'editorial_widgets_default'      => 4,
                'editorial_widgets_field_type'   => 'number'
            ),

            'editorial_block_posts_type' => array(
                'editorial_widgets_name'         => 'editorial_block_posts_type',
                'editorial_widgets_title'        => __( 'Posts Type', 'editorial' ),
                'editorial_widgets_default'		 => 'latest',
                'editorial_widgets_field_options'=> $editorial_post_list_option,
                'editorial_widgets_field_type'   => 'radio'
            ),

        );
        return $fields;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        if( empty( $instance ) ) {
            return ;
        }

        $editorial_block_title      	= empty( $instance['editorial_block_title'] ) ? '' : $instance['editorial_block_title'];
        $editorial_block_posts_count    = intval( empty( $instance['editorial_block_posts_count'] ) ? 4 : $instance['editorial_block_posts_count'] );
        $editorial_block_posts_type     = empty( $instance['editorial_block_posts_type'] ) ? '' : $instance['editorial_block_posts_type'];
        echo $before_widget;
?>
			<div class="widget-block-wrapper">
				<div class="block-header">
	                <h3 class="block-title"><?php echo esc_html( $editorial_block_title ); ?></h3>
	            </div><!-- .block-header -->
	            <div class="posts-list-wrapper list-posts-block">
	            	<?php
	            		$posts_list_args = editorial_query_args( $cat_id = null, $editorial_block_posts_count );
	            		if( $editorial_block_posts_type == 'random' ) {
	            			$posts_list_args['orderby'] = 'rand';
	            		}
	            		$posts_list_query = new WP_Query( $posts_list_args );
	            		if( $posts_list_query->have_posts() ) {
	            			while( $posts_list_query->have_posts() ) {
	            				$posts_list_query->the_post();
	                ?>
	                			<div class="single-post-wrapper clearfix">
                                    <div class="post-thumb-wrapper">
    	                                <a href="<?php the_permalink();?>" title="<?php the_title();?>">
    	                                    <figure><?php the_post_thumbnail( 'editorial-block-thumb' ); ?></figure>
    	                                </a>
                                    </div>
                                    <div class="post-content-wrapper">
                                        <h3 class="post-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
    	                                <div class="post-meta-wrapper">
    	                                    <?php editorial_posted_on(); ?>
    	                                </div><!-- .post-meta-wrapper -->
                                    </div>
	                            </div><!-- .single-post-wrapper -->
	                <?php
	            			}
	            		}
	            		
	            	?>
	            </div><!-- .posts-list-wrapper -->
			</div><!-- .widget-block-wrapper -->
<?php
		echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param   array   $new_instance   Values just sent to be saved.
     * @param   array   $old_instance   Previously saved values from database.
     *
     * @uses    editorial_widgets_updated_field_value()     defined in editorial-widget-fields.php
     *
     * @return  array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            extract( $widget_field );

            // Use helper function to get updated field values
            $instance[$editorial_widgets_name] = editorial_widgets_updated_field_value( $widget_field, $new_instance[$editorial_widgets_name] );
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param   array $instance Previously saved values from database.
     *
     * @uses    editorial_widgets_show_widget_field()       defined in widget-fields.php
     */
    public function form( $instance ) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            // Make array elements available as variables
            extract( $widget_field );
            $editorial_widgets_field_value = !empty( $instance[$editorial_widgets_name]) ? esc_attr($instance[$editorial_widgets_name] ) : '';
            editorial_widgets_show_widget_field( $this, $widget_field, $editorial_widgets_field_value );
        }
    }
}
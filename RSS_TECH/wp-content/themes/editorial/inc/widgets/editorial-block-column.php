<?php
/**
 * Editorial: Block Posts (Column)
 *
 * Widget show block posts as column
 *
 * @package Mystery Themes
 * @subpackage Editorial
 * @since 1.0.0
 */

add_action( 'widgets_init', 'editorial_register_block_column_widget' );

function editorial_register_block_column_widget() {
    register_widget( 'editorial_block_column' );
}

class Editorial_Block_Column extends WP_Widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'editorial_block_column',
            'description' => __( 'Display block posts as Column layout.', 'editorial' )
        );
        parent::__construct( 'editorial_block_column', __( 'Editorial: Block Posts (Column)', 'editorial' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
    
    global $editorial_category_dropdown;

        $fields = array(

            'editorial_block_title' => array(
                'editorial_widgets_name'         => 'editorial_block_title',
                'editorial_widgets_title'        => __( 'Block Title', 'editorial' ),
                'editorial_widgets_field_type'   => 'text'
            ),

            'editorial_block_cat_id' => array(
                'editorial_widgets_name' => 'editorial_block_cat_id',
                'editorial_widgets_title' => __( 'Category for Block Post', 'editorial' ),
                'editorial_widgets_default'      => 0,
                'editorial_widgets_field_type' => 'select',
                'editorial_widgets_field_options' => $editorial_category_dropdown
            ),

            'editorial_block_posts_count' => array(
                'editorial_widgets_name'         => 'editorial_block_posts_count',
                'editorial_widgets_title'        => __( 'No. of Posts', 'editorial' ),
                'editorial_widgets_default'      => 4,
                'editorial_widgets_field_type'   => 'number'
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

        $editorial_block_title      = empty( $instance['editorial_block_title'] ) ? '' : $instance['editorial_block_title'];
        $editorial_block_cat_id     = intval( empty( $instance['editorial_block_cat_id'] ) ? '' : $instance['editorial_block_cat_id'] );
        $editorial_block_posts_count    = intval ( empty( $instance['editorial_block_posts_count'] ) ? 4 : $instance['editorial_block_posts_count'] );
        echo $before_widget;
    ?>
    	<div class="block-column-wrapper">
    		
            <?php editorial_block_title( $editorial_block_title, $editorial_block_cat_id ); ?>
            
            <div class="block-posts-wrapper column-posts-block">
                <?php
                    $block_column_args = editorial_query_args( $editorial_block_cat_id, $editorial_block_posts_count );
                    $block_column_query = new WP_Query( $block_column_args );
                    $post_count = 0;
                    if( $block_column_query->have_posts() ) {
                        while ( $block_column_query->have_posts() ) {
                            $block_column_query->the_post();
                            $post_count++;
                            $post_id = get_the_ID();
                            if( $post_count == 1 ) {
                                $post_class = 'primary-post';
                                $image_path = get_the_post_thumbnail( $post_id, 'editorial-block-medium' );
                            } else {
                                $post_class = 'secondary-post';
                                $image_path = get_the_post_thumbnail( $post_id, 'editorial-block-thumb' );
                            }
                ?>
                			<div class="single-post-wrapper <?php echo esc_attr( $post_class ); ?> clearfix">
                                <div class="post-thumb-wrapper">
                                    <a href="<?php the_permalink();?>" title="<?php the_title();?>">
                                        <figure><?php echo $image_path; ?></figure>
                                    </a>
                                </div><!-- .post-thumb-wrapper -->
                                <div class="post-content-wrapper">
                                    <?php if( $post_count == 1 ) { do_action( 'editorial_post_categories' ); } ?>
                                    <h3 class="post-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
                                    <div class="post-meta-wrapper">
                                        <?php editorial_posted_on(); ?>
                                        <?php editorial_post_comment(); ?>
                                    </div>
                                    <?php  if( $post_count == 1 ) { the_excerpt(); } ?>
                                </div><!-- .post-meta-wrapper -->
                            </div><!-- .single-post-wrapper -->
                <?php
                		}
                	}
                	wp_reset_postdata();
                ?>
    	</div><!-- .block-column-wrapper -->
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
<?php
/**
 * Editorial: Block Posts (List)
 *
 * Widget shows the posts in list view
 *
 * @package Mystery Themes
 * @subpackage Editorial
 * @since 1.0.0
 */

add_action( 'widgets_init', 'editorial_register_block_list_widget' );

function editorial_register_block_list_widget() {
	register_widget( 'editorial_block_list' );
}

class Editorial_Block_List extends WP_widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'editorial_block_list',
            'description' => __( 'Display posts in block list layout', 'editorial' )
        );
        parent::__construct( 'editorial_block_list', __( 'Editorial: Block Posts (List)', 'editorial' ), $widget_ops );
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
                'editorial_widgets_title' => __( 'Category for Block Layout', 'editorial' ),
                'editorial_widgets_default'      => 0,
                'editorial_widgets_field_type' => 'select',
                'editorial_widgets_field_options' => $editorial_category_dropdown
            ),

            'editorial_block_posts_count' => array(
                'editorial_widgets_name'         => 'editorial_block_posts_count',
                'editorial_widgets_title'        => __( 'No. of Posts', 'editorial' ),
                'editorial_widgets_default'      => 5,
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

        $editorial_block_title          = empty( $instance['editorial_block_title'] ) ? '' : $instance['editorial_block_title'];
        $editorial_block_cat_id         = intval( empty( $instance['editorial_block_cat_id'] ) ? '' : $instance['editorial_block_cat_id'] );
        $editorial_block_posts_count    = intval( empty( $instance['editorial_block_posts_count'] ) ? 4 : $instance['editorial_block_posts_count'] );
        echo $before_widget;
    ?>
            <div class="block-list-wrapper">
                
                <?php editorial_block_title( $editorial_block_title, $editorial_block_cat_id ); ?>

                <div class="posts-list-wrapper clearfix column-posts-block">
                    <?php
                        $block_list_args = editorial_query_args( $editorial_block_cat_id, $editorial_block_posts_count );
                        $block_list_query = new WP_Query( $block_list_args );
                        if( $block_list_query->have_posts() ) {
                            while ( $block_list_query->have_posts() ) {
                                $block_list_query->the_post();
                    ?>
                                <div class="single-post-wrapper clearfix">
                                    <div class="post-thumb-wrapper">
                                        <a href="<?php the_permalink();?>" title="<?php the_title();?>">
                                            <figure><?php the_post_thumbnail( 'editorial-block-medium' ); ?></figure>
                                        </a>
                                    </div>
                                    <div class="post-content-wrapper">
                                        <?php do_action( 'editorial_post_categories' ); ?>
                                        <h3 class="post-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
                                        <div class="post-meta-wrapper">
                                            <?php editorial_posted_on(); ?>
                                        </div><!-- .post-meta-wrapper -->
                                        <div class="post-content">
                                            <?php the_excerpt(); ?>
                                        </div><!-- .post-content -->
                                    </div><!-- .post-content-wrapper -->
                                </div><!-- .single-post-wrapper -->
                    <?php 
                            }
                        }
                        wp_reset_postdata();
                    ?>
                </div><!-- .posts-list-wrapper-->
            </div><!-- .block-list-wrapper -->
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
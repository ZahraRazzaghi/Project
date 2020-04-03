<?php
/**
 * Editorial: Banner Ads 
 *
 * Widget show the banner ads size of 728x90 (leaderboard) or large size of (300x250)
 *
 * @package Mystery Themes
 * @subpackage Editorial
 * @since 1.0.0
 */

add_action( 'widgets_init', 'editorial_register_ads_banner_widget' );

function editorial_register_ads_banner_widget() {
	register_widget( 'editorial_ads_banner' );
}

class Editorial_Ads_Banner extends WP_widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'editorial_ads_banner',
            'description' => __( 'You can place banner as advertisement with links.', 'editorial' )
        );
        parent::__construct( 'editorial_ads_banner', __( 'Editorial: Ads Banner', 'editorial' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        
        $ads_size = array(
                    'leaderboard'   => __( 'Leaderboard (728x90)', 'editorial' ),
                    'large'         => __( 'Large (300x250)', 'editorial' )
                    );
        $fields = array(

            'banner_title' => array(
                'editorial_widgets_name'         => 'banner_title',
                'editorial_widgets_title'        => __( 'Title', 'editorial' ),
                'editorial_widgets_field_type'   => 'text'
            ),

            'banner_size' => array(
                'editorial_widgets_name' => 'banner_size',
                'editorial_widgets_title' => __( 'Ads Size', 'editorial' ),
                'editorial_widgets_default' => 'leaderboard',
                'editorial_widgets_field_type' => 'radio',
                'editorial_widgets_field_options' => $ads_size
            ),

            'banner_image' => array(
                'editorial_widgets_name' => 'banner_image',
                'editorial_widgets_title' => __( 'Add Image', 'editorial' ),
                'editorial_widgets_field_type' => 'upload',
            ),

            'banner_url' => array(
                'editorial_widgets_name'         => 'banner_url',
                'editorial_widgets_title'        => __( 'Add Url', 'editorial' ),
                'editorial_widgets_field_type'   => 'url'
            ),

        );
        return $fields;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        if( empty( $instance ) ) {
            return ;
        }

        $editorial_banner_title = empty( $instance['banner_title'] ) ? '' : $instance['banner_title'];
        $editorial_banner_size = empty( $instance['banner_size'] ) ? 'leaderboard' : $instance['banner_size'];
        $editorial_banner_image   = empty( $instance['banner_image'] ) ? '' : $instance['banner_image'];
        $editorial_banner_url   = empty( $instance['banner_url'] ) ? '' : $instance['banner_url'];
        echo $before_widget;
        if( !empty( $editorial_banner_image ) ) {
    ?>
            <div class="ads-wrapper <?php echo esc_attr( $editorial_banner_size ); ?>">
                <?php if( !empty( $editorial_banner_title ) ) { ?>
                    <h4 class="widget-title"><?php echo esc_html( $editorial_banner_title ); ?></h4>
                <?php } ?>
                <?php
                    if( !empty( $editorial_banner_url ) ) {
                ?>
                    <a href="<?php echo esc_url( $editorial_banner_url );?>"><img src="<?php echo esc_url( $editorial_banner_image ); ?>" /></a>
                <?php
                    } else {
                ?>
                    <img src="<?php echo esc_url( $editorial_banner_image ); ?>" />
                <?php
                    }
                ?>
            </div>  
    <?php
        }
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

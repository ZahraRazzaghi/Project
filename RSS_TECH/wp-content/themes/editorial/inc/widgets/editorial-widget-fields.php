<?php
/**
 * Define custom fields for widgets
 * 
 * @package Mystery Themes
 * @subpackage Editorial
 * @since 1.0.0
 */

function editorial_widgets_show_widget_field( $instance = '', $widget_field = '', $athm_field_value = '' ) {
    
    extract( $widget_field );

    switch ( $editorial_widgets_field_type ) {

    	// Standard text field
        case 'text' :
        ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $editorial_widgets_name ) ); ?>"><?php echo esc_html( $editorial_widgets_title ); ?>:</label>
                <input class="widefat" id="<?php echo esc_attr ( $instance->get_field_id( $editorial_widgets_name ) ); ?>" name="<?php echo esc_attr ( $instance->get_field_name( $editorial_widgets_name ) ); ?>" type="text" value="<?php echo esc_html( $athm_field_value ); ?>" />

                <?php if ( isset( $editorial_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $editorial_widgets_description ); ?></small>
                <?php } ?>
            </p>
        <?php
            break;

        // Standard url field
        case 'url' :
        ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $editorial_widgets_name ) ); ?>"><?php echo esc_html( $editorial_widgets_title ); ?>:</label>
                <input class="widefat" id="<?php echo esc_attr ( $instance->get_field_id( $editorial_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $editorial_widgets_name ) ); ?>" type="text" value="<?php echo esc_html( $athm_field_value ); ?>" />

                <?php if ( isset( $editorial_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $editorial_widgets_description ); ?></small>
                <?php } ?>
            </p>
        <?php
            break;

        // Textarea field
        case 'textarea' :
        ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $editorial_widgets_name ) ); ?>"><?php echo esc_html( $editorial_widgets_title ); ?>:</label>
                <textarea class="widefat" rows="<?php echo intval( $editorial_widgets_row ); ?>" id="<?php echo esc_attr( $instance->get_field_id( $editorial_widgets_name ) ); ?>" name="<?php echo esc_attr ( $instance->get_field_name( $editorial_widgets_name ) ); ?>"><?php echo esc_html( $athm_field_value ); ?></textarea>
            </p>
        <?php
            break;

        // Radio fields
        case 'radio' :
        	if( empty( $athm_field_value ) ) {
        		$athm_field_value = $editorial_widgets_default;
        	}
        ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $editorial_widgets_name ) ); ?>"><?php echo esc_html( $editorial_widgets_title ); ?>:</label>
                <div class="radio-wrapper">
                    <?php
                        foreach ( $editorial_widgets_field_options as $athm_option_name => $athm_option_title ) {
                    ?>
                        <input id="<?php echo esc_attr( $instance->get_field_id( $athm_option_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $editorial_widgets_name ) ); ?>" type="radio" value="<?php echo esc_html( $athm_option_name ); ?>" <?php checked( $athm_option_name, $athm_field_value ); ?> />
                        <label for="<?php echo esc_attr( $instance->get_field_id( $athm_option_name ) ); ?>"><?php echo esc_html( $athm_option_title ); ?>:</label>
                    <?php } ?>
                </div>

                <?php if ( isset( $editorial_widgets_description ) ) { ?>
                    <small><?php echo esc_html( $editorial_widgets_description ); ?></small>
                <?php } ?>
            </p>
        <?php
            break;

        // Select field
        case 'select' :
            if( empty( $athm_field_value ) ) {
                $athm_field_value = $editorial_widgets_default;
            }
        ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $editorial_widgets_name ) ); ?>"><?php echo esc_html( $editorial_widgets_title ); ?>:</label>
                <select name="<?php echo esc_attr( $instance->get_field_name( $editorial_widgets_name ) ); ?>" id="<?php echo esc_attr( $instance->get_field_id( $editorial_widgets_name ) ); ?>" class="widefat">
                    <?php foreach ( $editorial_widgets_field_options as $athm_option_name => $athm_option_title ) { ?>
                        <option value="<?php echo esc_attr( $athm_option_name ); ?>" id="<?php echo esc_attr( $instance->get_field_id($athm_option_name) ); ?>" <?php selected( $athm_option_name, $athm_field_value ); ?>><?php echo esc_html( $athm_option_title ); ?></option>
                    <?php } ?>
                </select>

                <?php if ( isset( $editorial_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $editorial_widgets_description ); ?></small>
                <?php } ?>
            </p>
        <?php
            break;

        case 'number' :
        	if( empty( $athm_field_value ) ) {
        		$athm_field_value = $editorial_widgets_default;
        	}
        ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $editorial_widgets_name ) ); ?>"><?php echo esc_html( $editorial_widgets_title ); ?>:</label><br />
                <input name="<?php echo esc_attr( $instance->get_field_name( $editorial_widgets_name ) ); ?>" type="number" step="1" min="1" id="<?php echo esc_attr( $instance->get_field_id( $editorial_widgets_name ) ); ?>" value="<?php echo esc_html( $athm_field_value ); ?>" />

                <?php if ( isset( $editorial_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $editorial_widgets_description ); ?></small>
                <?php } ?>
            </p>
       	<?php
            break;

        case 'widget_section_header':
        ?>
        	<span class="section-header"><?php echo esc_html( $editorial_widgets_title ); ?></span>
        <?php
        	break;

        case 'widget_layout_image':
        ?>
            <div class="layout-image-wrapper">
                <span class="image-title"><?php echo esc_html( $editorial_widgets_title ); ?></span>
                <img src="<?php echo esc_url( $editorial_widgets_layout_img ); ?>" title="<?php echo esc_attr( 'Widget Layout', 'editorial' ); ?>" />
            </div>
        <?php
            break;

        case 'upload' :

            $output = '';
            $id = esc_attr( $instance->get_field_id( $editorial_widgets_name ) );
            $class = '';
            $int = '';
            $value = $athm_field_value;
            $name = esc_attr( $instance->get_field_name( $editorial_widgets_name ) );

            if ( $value ) {
                $class = ' has-file';
                $value = explode( 'wp-content', $value );
                $value = content_url().$value[1];
            }
            $output .= '<div class="sub-option widget-upload">';
            $output .= '<label for="' . esc_attr( $instance->get_field_id( $editorial_widgets_name ) ) . '">' . esc_html( $editorial_widgets_title ) . '</label><br/>';
            $output .= '<input id="' . $id . '" class="upload' . $class . '" type="text" name="' . $name . '" value="' . $value . '" placeholder="' . __( 'No file chosen', 'editorial' ) . '" />' . "\n";
            if ( function_exists( 'wp_enqueue_media' ) ) {
                if ( ( $value == '') ) {
                    $output .= '<input id="upload-' . $id . '" class="wid-upload-button button" type="button" value="' . __( 'Upload', 'editorial' ) . '" />' . "\n";
                } else {
                    $output .= '<input id="remove-' . $id . '" class="wid-remove-file button" type="button" value="' . __( 'Remove', 'editorial' ) . '" />' . "\n";
                }
            } else {
                $output .= '<p><i>' . __( 'Upgrade your version of WordPress for full media support.', 'editorial' ) . '</i></p>';
            }

            $output .= '<div class="screenshot upload-thumb" id="' . $id . '-image">' . "\n";

            if ( $value != '' ) {
                $remove = '<a class="remove-image">'. __( 'Remove', 'editorial' ).'</a>';
                $image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );
                if ( $image ) {
                    $output .= '<img src="' . $value . '" alt="'.__( 'Upload image', 'editorial' ).'" />';
                } else {
                    $parts = explode( "/", $value );
                    for ( $i = 0; $i < sizeof( $parts ); ++$i ) {
                        $title = $parts[$i];
                    }

                    // No output preview if it's not an image.
                    $output .= '';

                    // Standard generic output if it's not an image.
                    $title = __( 'View File', 'editorial' );
                    $output .= '<div class="no-image"><span class="file_link"><a href="' . $value . '" target="_blank" rel="external">' . $title . '</a></span></div>';
                }
            }
            $output .= '</div></div>' . "\n";
            echo $output;
            break;
    }
}

function editorial_widgets_updated_field_value( $widget_field, $new_field_value ) {

    extract( $widget_field );

    // Allow only integers in number fields
    if ( $editorial_widgets_field_type == 'number') {
        return editorial_sanitize_number( $new_field_value );

        // Allow some tags in textareas
    } elseif ( $editorial_widgets_field_type == 'textarea' ) {
        // Check if field array specified allowed tags
        if ( !isset( $editorial_widgets_allowed_tags ) ) {
            // If not, fallback to default tags
            $editorial_widgets_allowed_tags = '<p><strong><em><a>';
        }
        return strip_tags( $new_field_value, $editorial_widgets_allowed_tags );

        // No allowed tags for all other fields
    } elseif ( $editorial_widgets_field_type == 'url' ) {
        return esc_url( $new_field_value );
    } else {
        return strip_tags( $new_field_value );
    }
}
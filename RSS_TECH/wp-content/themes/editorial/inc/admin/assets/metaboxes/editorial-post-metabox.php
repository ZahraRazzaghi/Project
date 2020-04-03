<?php
/**
 * Functions for rendering meta boxes in post area
 * 
 * @package Mystery Themes
 * @subpackage Editorial
 * @since 1.0.0
 */

add_action( 'add_meta_boxes', 'editorial_metaboxes', 10, 2 );
function editorial_metaboxes( $type, $post ) {
    add_meta_box(
        'editorial_post_sidebar',
        __( 'Sidebar Position', 'editorial' ),
        'editorial_sidebar_callback',
        'post',
        'side',
        'default'
    );
    add_meta_box(
        'editorial_post_sidebar',
        __( 'Sidebar Position', 'editorial' ),
        'editorial_sidebar_callback',
        'page',
        'side',
        'default'
    );
}

function editorial_sidebar_callback( $post ) {

    // Setup our options.
    $editorial_page_sidebar_option = array(
    'default-sidebar' => array(
        'id'        => 'default-sidebar',
        'value'     => 'default_sidebar',
        'label'     => __( 'Default Layout', 'editorial' ),
        ),
    'right-sidebar' => array(
        'id'        => 'rigth-sidebar',
        'value'     => 'right_sidebar',
        'label'     => __( 'Right Sidebar', 'editorial' ),
        ),
    'left-sidebar' => array(
        'id'        => 'left-sidebar',
        'value'     => 'left_sidebar',
        'label'     => __( 'Left Sidebar', 'editorial' ),
        ),
    'no-sidebar-full-width' => array(
        'id'        => 'no-sidebar',
        'value'     => 'no_sidebar',
        'label'     => __( 'No Sidebar Full Width', 'editorial' ),
        ),
    'no-sidebar-content-centered' => array(
        'id'        => 'no-sidebar-center',
        'value'     => 'no_sidebar_center',
        'label'     => __( 'No Sidebar Content Centered', 'editorial' ),
        ),
    );

    // Check for previously set.
    $location = get_post_meta( $post->ID, 'editorial_sidebar_location', true );
    // If it is then we use it otherwise set to default.
    $location = ( $location ) ? $location : 'default_sidebar';

    // Create our nonce field.
    wp_nonce_field( 'editorial_nonce_' . basename( __FILE__ ) , 'editorial_sidebar_location_nonce' );
    foreach ( $editorial_page_sidebar_option as $field ) {
    ?>
        <div class="meta-radio-wrap">
            <input id="<?php echo esc_attr( $field['id'] ); ?>" type="radio" name="editorial_sidebar_location" value="<?php echo esc_attr( $field['value'] ); ?>" <?php checked( $field['value'], $location ); ?>/>
            <label for="<?php echo esc_attr( $field['id'] ); ?>"><?php echo esc_html( $field['label'] ); ?></label>
        </div>
    <?php
    }
}

add_action( 'save_post', 'editorial_save_post_meta' );
function editorial_save_post_meta( $post_id ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST['editorial_sidebar_location_nonce'] ) && wp_verify_nonce( $_POST['editorial_sidebar_location_nonce'], 'editorial_nonce_' . basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
        return;
    }

    // Check for out input value.
    if ( isset( $_POST['editorial_sidebar_location'] ) ) {
        // We validate making sure that the option is something we can expect.
        $value = in_array( $_POST['editorial_sidebar_location'], array( 'no_sidebar', 'left_sidebar', 'right_sidebar', 'no_sidebar_center', 'default_sidebar' ) ) ? $_POST['editorial_sidebar_location'] : 'default_sidebar';
        // We update our post meta.
        update_post_meta( $post_id, 'editorial_sidebar_location', $value );
    }
}
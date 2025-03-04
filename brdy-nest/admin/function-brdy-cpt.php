<?php

function brdy_register_custom_post_type() {
    $labels = array(
        'name'                  => _x('Brdies', 'Post type general name', 'brdy-plugin'),
        'singular_name'         => _x('Brdy', 'Post type singular name', 'brdy-plugin'),
        'menu_name'             => _x('Brdies', 'Admin Menu text', 'brdy-plugin'),
        'name_admin_bar'        => _x('Brdy', 'Add New on Toolbar', 'brdy-plugin'),
        'add_new'               => __('Add New', 'brdy-plugin'),
        'add_new_item'          => __('Add New Brdy', 'brdy-plugin'),
        'new_item'              => __('New Brdy', 'brdy-plugin'),
        'edit_item'             => __('Edit Brdy', 'brdy-plugin'),
        'view_item'             => __('View Brdy', 'brdy-plugin'),
        'all_items'             => __('All Brdies', 'brdy-plugin'),
        'search_items'          => __('Search Brdies', 'brdy-plugin'),
        'not_found'             => __('No Brdies found.', 'brdy-plugin'),
        'not_found_in_trash'    => __('No Brdies found in Trash.', 'brdy-plugin'),
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'brdy'),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-admin-post',
        'supports'              => array(
            'title',           // Title support
            'editor',          // Content support
            'excerpt',         // Description support
            'thumbnail',       // Images support
            'custom-fields'    // For location, budget, wallet_address, and link
        ),
        'taxonomies'            => array('category', 'post_tag'),
        'show_in_rest'          => true, // Enable Gutenberg editor
    );

    register_post_type('brdy', $args);
}
add_action('init', 'brdy_register_custom_post_type');

// Optional: Add meta boxes for custom fields
function brdy_register_meta_boxes() {
    add_meta_box(
        'brdy_meta_box',
        __('Brdy Details', 'brdy-plugin'),
        'brdy_meta_box_callback',
        'brdy',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'brdy_register_meta_boxes');

function brdy_meta_box_callback($post) {
    wp_nonce_field('brdy_save_meta_box_data', 'brdy_meta_box_nonce');
    
    $location = get_post_meta($post->ID, '_brdy_location', true);
    $budget = get_post_meta($post->ID, '_brdy_budget', true);
    $wallet_address = get_post_meta($post->ID, '_brdy_wallet_address', true);
    $link = get_post_meta($post->ID, '_brdy_link', true);
    ?>
    <p>
        <label for="brdy_location"><?php _e('Location:', 'brdy-plugin'); ?></label><br>
        <input type="text" id="brdy_location" name="brdy_location" value="<?php echo esc_attr($location); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="brdy_budget"><?php _e('Budget:', 'brdy-plugin'); ?></label><br>
        <input type="text" id="brdy_budget" name="brdy_budget" value="<?php echo esc_attr($budget); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="brdy_wallet_address"><?php _e('Wallet Address:', 'brdy-plugin'); ?></label><br>
        <input type="text" id="brdy_wallet_address" name="brdy_wallet_address" value="<?php echo esc_attr($wallet_address); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="brdy_link"><?php _e('Link:', 'brdy-plugin'); ?></label><br>
        <input type="url" id="brdy_link" name="brdy_link" value="<?php echo esc_attr($link); ?>" style="width: 100%;">
    </p>
    <?php
}

// Save meta box data
function brdy_save_meta_box_data($post_id) {
    if (!isset($_POST['brdy_meta_box_nonce']) || !wp_verify_nonce($_POST['brdy_meta_box_nonce'], 'brdy_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array('brdy_location', 'brdy_budget', 'brdy_wallet_address', 'brdy_link');
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $value = sanitize_text_field($_POST[$field]);
            update_post_meta($post_id, '_' . $field, $value);
        }
    }
}
add_action('save_post', 'brdy_save_meta_box_data');
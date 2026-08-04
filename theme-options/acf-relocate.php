<?php
// Automatically create the acf-json directory ( custom fields inside custom theme )
add_action('after_setup_theme', 'create_acf_json_dir');
function create_acf_json_dir() {
    $dir = get_template_directory() . '/acf-json';
    if (!is_dir($dir)) {
        wp_mkdir_p($dir);
    }
}

// Export ACF settings to a JSON file
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
function my_acf_json_save_point( $path ) {
    // update path
    $path = get_template_directory() . '/acf-json';
    
    // return
    return $path;
}

// Load ACF settings from a JSON file
add_filter('acf/settings/load_json', 'my_acf_json_load_point');
function my_acf_json_load_point( $paths ) {
    // remove original path (optional)
    unset($paths[0]);
    // append path
    $paths[] = get_template_directory() . '/acf-json';
    // return
    return $paths;
}

// These field groups are meant to be managed only from their JSON file in acf-json/ — never
// from wp-admin. If they're ever saved via the Field Groups screen, ACF gives them a database
// copy, and from then on that DB copy (not the JSON) becomes the source of truth until manually
// synced — which is exactly the confusion/data-loss this is meant to prevent. Editing/viewing the
// screen is still fine; only the actual save is blocked, before anything is written.
add_filter('wp_insert_post_data', 'base_theme_lock_json_only_field_groups', 10, 2);
function base_theme_lock_json_only_field_groups($data, $postarr) {
    if (($data['post_type'] ?? '') !== 'acf-field-group') {
        return $data;
    }

    $json_only_keys = array(
        'group_690b1a2c3d4e6', // Hero Override
        'group_68cf25c9be351', // Category/Taxonomy Hero
        'group_683b303a36178', // Menu Icon/Image
    );

    $post_id = $postarr['ID'] ?? 0;
    $existing_slug = $post_id ? get_post_field('post_name', $post_id) : '';
    $incoming_slug = $data['post_name'] ?? '';

    if (in_array($existing_slug, $json_only_keys, true) || in_array($incoming_slug, $json_only_keys, true)) {
        wp_die(
            esc_html__('This field group is managed only from its JSON file in acf-json/ and cannot be saved from wp-admin. Edit the theme file directly instead.', 'base-theme'),
            esc_html__('Field Group Locked', 'base-theme'),
            array('back_link' => true, 'response' => 403)
        );
    }

    return $data;
}

// Hide the same JSON-only field groups from the Field Groups list screen entirely — purely a
// display change on that one admin screen. Their location rules (which is what actually assigns
// them to post types) are untouched and still evaluated normally everywhere else.
add_action('admin_head-edit.php', 'base_theme_hide_json_only_field_groups_from_list');
function base_theme_hide_json_only_field_groups_from_list() {
    $screen = get_current_screen();
    if (!$screen || $screen->post_type !== 'acf-field-group') {
        return;
    }
    $titles = array('Hero Override', 'Category/Taxonomy Hero', 'Menu Icon/Image');
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var titles = <?php echo wp_json_encode($titles); ?>;
        document.querySelectorAll('#the-list tr').forEach(function (row) {
            var titleLink = row.querySelector('.row-title');
            if (titleLink && titles.indexOf(titleLink.textContent.trim()) !== -1) {
                row.remove();
            }
        });
    });
    </script>
    <?php
}
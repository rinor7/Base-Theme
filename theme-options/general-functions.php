<?php
// Warn admins on every wp-admin screen if the site is currently blocked from
// search engines, so it can't be forgotten silently at launch like a code
// comment can. Search-engine visibility itself is controlled the standard
// WordPress way: Settings > Reading > "Discourage search engines from
// indexing this site" (core already emits the noindex tag for us via
// wp_no_robots() when that box is checked).
function base_theme_noindex_admin_notice() {
    if (!current_user_can('manage_options') || get_option('blog_public')) {
        return;
    }
    echo '<div class="notice notice-warning"><p><strong>Search engines are currently blocked from indexing this site.</strong> If this site is live, go to <a href="' . esc_url(admin_url('options-reading.php')) . '">Settings &rarr; Reading</a> and uncheck "Discourage search engines from indexing this site".</p></div>';
}
add_action('admin_notices', 'base_theme_noindex_admin_notice');

//Remove Comments Option from Admin Menu
function df_disable_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'df_disable_comments_admin_menu');
// Remove comments from the admin bar
function df_remove_comments_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', 'df_remove_comments_admin_bar');
// Remove comments and trackbacks support from post types
function df_remove_comment_support() {
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('init', 'df_remove_comment_support', 100);
// Redirect any user trying to access comments page
function df_redirect_comments_page() {
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }
}
add_action('admin_init', 'df_redirect_comments_page');
// Close comments on the front-end
function df_disable_comments_status() {
    return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);
// Hide existing comments
function df_hide_existing_comments($comments) {
    $comments = array();
    return $comments;
}
add_filter('comments_array', 'df_hide_existing_comments', 10, 2);
//Function for rendering section headers
function strip_outer_p_tags($content) {
    // Remove outer <p> tags if they exist, but keep inner tags
    if (preg_match('#^<p>(.*)</p>$#is', trim($content), $matches)) {
        return $matches[1];
    }
    return $content;
}
// Returns a 1-based counter per $key, incrementing on each call within the same request
function get_next_instance_index($key) {
    static $counts = array();
    if (!isset($counts[$key])) {
        $counts[$key] = 0;
    }
    $counts[$key]++;
    return $counts[$key];
}
function render_section_header($input, $post_id = null) {

    // If string → fetch fields
    if (is_string($input)) {
        $fields = get_field($input, $post_id ?: get_the_ID());
    } else {
        $fields = $input;
    }

    if (!is_array($fields) || empty($fields)) return;

    $title    = $fields['title_section'] ?? '';
    $subtitle = $fields['subtitle_section'] ?? '';

    if (!$title && !$subtitle) return;

    $margin_desktop = !empty($fields['margin_bottom_desktop']) 
        ? (int)$fields['margin_bottom_desktop'] . 'px' 
        : '6px';

    $margin_mobile = !empty($fields['margin_bottom_mobile']) 
        ? (int)$fields['margin_bottom_mobile'] . 'px' 
        : $margin_desktop;

    echo '<div class="section-header" style="--mb-desktop:' . esc_attr($margin_desktop) . ';--mb-mobile:' . esc_attr($margin_mobile) . ';">';

        if ($title) {
            echo '<div class="section-header-title">' . wp_kses_post(strip_outer_p_tags($title)) . '</div>';
        }

        if ($subtitle) {
            echo '<div class="section-header-subtitle">' . wp_kses_post(strip_outer_p_tags($subtitle)) . '</div>';
        }

    echo '</div>';
}

// Shorten the WYSIWYG editor height for short title/subtitle fields (full height isn't needed, they just need bold/basic formatting)
// Targets by field NAME (not key) so every flexible layout using this same title_section/subtitle_section
// convention (counter-repeater, four-boxes, posts-grid, posts-slider, and any future one) is covered automatically.
add_action('acf/input/admin_head', 'base_theme_shorten_wysiwyg_fields');
function base_theme_shorten_wysiwyg_fields() {
    $field_names = array(
        'title_section',
        'subtitle_section',
    );
    $selectors = array();
    foreach ($field_names as $name) {
        $selectors[] = '.acf-field[data-name="' . $name . '"] .wp-editor-area';
        $selectors[] = '.acf-field[data-name="' . $name . '"] iframe';
    }
    ?>
    <style>
        <?php echo implode(",\n", $selectors); ?> {
            height: 100px !important;
            min-height: 100px !important;
        }
    </style>
    <?php
}

// Populate the "Post Type" select on Posts Grid/Slider with the site's actual registered public post types,
// instead of relying on an admin typing the slug by hand (typos silently returned zero results).
add_filter('acf/load_field/key=field_69f647dc_posts_grid_post_type', 'base_theme_load_public_post_type_choices');
function base_theme_load_public_post_type_choices($field) {
    $post_types = get_post_types(array('public' => true), 'objects');
    $choices = array();
    foreach ($post_types as $post_type) {
        if ($post_type->name === 'attachment') {
            continue;
        }
        $choices[$post_type->name] = $post_type->label;
    }
    $field['choices'] = $choices;
    return $field;
}

// Reuse the same dynamic post type choices on the Theme Settings "Per Post Type Banners" repeater.
// Pages are a valid choice here too: if enabled, it's the site-wide default hero for any page that
// doesn't add its own Hero module — a page's own Hero module (if present) always wins.
add_filter('acf/load_field/key=field_683a4511_hero_ptset_post_type', 'base_theme_load_public_post_type_choices');

// Populate the "Taxonomy" select on the Theme Settings "Per Taxonomy Banners" repeater with the
// site's actual registered public taxonomies, so new taxonomies show up automatically.
add_filter('acf/load_field/key=field_683a4511_hero_taxset_taxonomy', 'base_theme_load_public_taxonomy_choices');
function base_theme_load_public_taxonomy_choices($field) {
    $taxonomies = get_taxonomies(array('public' => true), 'objects');
    $choices = array();
    foreach ($taxonomies as $taxonomy) {
        $choices[$taxonomy->name] = $taxonomy->label;
    }
    $field['choices'] = $choices;
    return $field;
}

// Returns the enabled Hero row (from Theme Settings > hero_banners > hero_post_type_settings)
// for a given post type, or null if Hero isn't enabled for it. Shared by the admin field
// visibility filter below and by the automatic-page-hero renderer further down.
function base_theme_get_post_type_hero_settings($post_type) {
    static $cache = array();
    if (array_key_exists($post_type, $cache)) {
        return $cache[$post_type];
    }
    $rows = get_field('hero_banners', 'option')['hero_post_type_settings'] ?? [];
    $result = null;
    foreach ($rows as $row) {
        if (($row['post_type'] ?? '') === $post_type && !empty($row['enable_hero'])) {
            $result = $row;
            break;
        }
    }
    $cache[$post_type] = $result;
    return $result;
}

// Turns a Background Type + image/color/gradient combo (as used across the Hero Banners fields in
// Theme Settings) into a raw CSS "background" declaration. Caller is responsible for wrapping the
// result in esc_attr() before echoing as a style="" attribute.
function base_theme_hero_background_style($type, $image, $color, $gradient) {
    $theme_color_vars = array(
        'primary'   => 'var(--primary-color)',
        'secondary' => 'var(--secondary-color)',
        'font'      => 'var(--font-color)',
        'white'     => 'var(--white)',
        'black'     => 'var(--black)',
    );
    switch ($type) {
        case 'gradient':
            $gradient = trim($gradient);
            return $gradient !== '' ? 'background:' . $gradient . ';' : '';
        case 'custom':
            return $color !== '' ? 'background-color:' . $color . ';' : '';
        case 'image':
            return $image !== '' ? "background-image:url('" . esc_url($image) . "');" : '';
        default:
            return isset($theme_color_vars[$type]) ? 'background-color:' . $theme_color_vars[$type] . ';' : '';
    }
}

// Hero min-height, as CSS custom properties. Falls back to the site-wide Theme Settings value when
// no override is passed, and CSS falls back further to 300px if neither is set. Shared by the
// automatic Theme Settings hero below and by includes/flexible/layouts/hero/hero.php (which passes
// its own per-instance fields as overrides, letting one page's Hero module differ from the rest).
function base_theme_hero_min_height_style($override_desktop = '', $override_mobile = '') {
    $hero_banners = get_field('hero_banners', 'option') ?: [];
    $desktop = $override_desktop !== '' ? $override_desktop : ($hero_banners['min_height_desktop'] ?? '');
    $mobile  = $override_mobile !== '' ? $override_mobile : ($hero_banners['min_height_mobile'] ?? '');
    $style = '';
    if ($desktop !== '') {
        $style .= '--hero-min-height-desktop:' . intval($desktop) . 'px;';
    }
    if ($mobile !== '') {
        $style .= '--hero-min-height-mobile:' . intval($mobile) . 'px;';
    }
    return $style;
}

// Whether a Background Type slot actually has usable content for the given type.
function base_theme_hero_slot_has_content($type, $image, $color, $gradient) {
    switch ($type) {
        case 'gradient': return trim((string) $gradient) !== '';
        case 'custom':   return $color !== '';
        case 'image':    return $image !== '';
        default:         return true; // theme palette colors (primary/secondary/font/white/black) are always usable
    }
}

// Resolves the background to use for a page's automatic hero: this post type's row in Theme
// Settings -> the site-wide single default -> the page's featured image -> the hardcoded default.
function base_theme_get_automatic_page_hero() {
    $post_type_settings = base_theme_get_post_type_hero_settings('page');
    if (!$post_type_settings) {
        return null; // Hero not enabled for Pages in Theme Settings
    }

    $hero_banners = get_field('hero_banners', 'option') ?: [];

    $type         = $post_type_settings['single_background_type'] ?? 'image';
    $image        = $post_type_settings['default_single_image'] ?? '';
    $color        = $post_type_settings['single_background_color'] ?? '';
    $gradient     = $post_type_settings['single_background_gradient'] ?? '';
    $content_type = $post_type_settings['default_single_content_type'] ?? '';

    if (!base_theme_hero_slot_has_content($type, $image, $color, $gradient)) {
        $type         = $hero_banners['default_single_background_type'] ?? 'image';
        $image        = $hero_banners['default_single_hero'] ?? '';
        $color        = $hero_banners['default_single_background_color'] ?? '';
        $gradient     = $hero_banners['default_single_background_gradient'] ?? '';
        $content_type = $hero_banners['default_single_hero_content_type'] ?? '';
    }

    if ($type === 'image' && $image === '' && has_post_thumbnail()) {
        $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
    }

    if (!base_theme_hero_slot_has_content($type, $image, $color, $gradient)) {
        $type  = 'image';
        $image = get_template_directory_uri() . '/assets/img/bg.webp';
    }

    return compact('type', 'image', 'color', 'gradient', 'content_type');
}

// Whether this page already has its own Hero module in flex_sections — if so, that always wins
// over the automatic Theme Settings hero.
function base_theme_page_has_hero_module($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $rows = get_field('flex_sections', $post_id) ?: [];
    foreach ($rows as $row) {
        if (($row['acf_fc_layout'] ?? '') === 'hero') {
            return true;
        }
    }
    return false;
}

// Renders the automatic Theme Settings hero for a Page, unless the page has its own Hero module
// (which always takes priority) or Hero isn't enabled for Pages at all.
function base_theme_render_automatic_page_hero() {
    if (base_theme_page_has_hero_module()) {
        return;
    }
    $hero = base_theme_get_automatic_page_hero();
    if (!$hero) {
        return;
    }
    $style = base_theme_hero_background_style($hero['type'], $hero['image'], $hero['color'], $hero['gradient']);
    if ($style === '') {
        return;
    }
    $style .= base_theme_hero_min_height_style();
    $class = 'block-hero';
    if ($hero['content_type']) {
        $class .= ' ' . $hero['content_type'];
    }
    ?>
    <section class="<?php echo esc_attr($class); ?>" style="<?php echo esc_attr($style); ?>">
        <div class="container">
            <div class="block-hero-content">
                <div class="content">
                    <h1 class="hero-title"><?php echo esc_html(get_the_title()); ?></h1>
                    <div class="breadcrumbs">
                        <?php if (function_exists('yoast_breadcrumb')) {
                            yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}

// Only show the per-post "Hero Override" fields when Hero is actually enabled for that post's type.
add_filter('acf/prepare_field/key=field_690b1a2c_hero_override_image', 'base_theme_hide_hero_override_if_disabled');
add_filter('acf/prepare_field/key=field_690b1a2c_hero_override_content_type', 'base_theme_hide_hero_override_if_disabled');
function base_theme_hide_hero_override_if_disabled($field) {
    global $post;
    if (!$post || !base_theme_get_post_type_hero_settings(get_post_type($post))) {
        return false;
    }
    return $field;
}

// Hide the "Hero" flexible content layout on the Frontpage template — that template
// never renders a hero, so it shouldn't be offered as a section choice there.
// ACF location rules only gate whole field groups, not individual layouts, so this
// has to be done by filtering the layout list itself.
add_filter('acf/prepare_field/key=field_69f647dc_flex_sections', 'base_theme_hide_hero_layout_on_frontpage');
function base_theme_hide_hero_layout_on_frontpage($field) {
    global $post;
    if (empty($field['layouts']) || !$post || get_page_template_slug($post) !== 'flexible-content-work.php') {
        return $field;
    }
    foreach ($field['layouts'] as $i => $layout) {
        if (($layout['name'] ?? '') === 'hero') {
            unset($field['layouts'][$i]);
        }
    }
    return $field;
}

//Theme Settings Menu
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'    => 'Theme Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'global-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}

// Enable pagination for post type archives
function enable_post_type_archive_pagination() {
    add_rewrite_rule(
        '^([^/]+)/page/([0-9]+)/?$',
        'index.php?post_type=$matches[1]&paged=$matches[2]',
        'top'
    );
}
add_action('init', 'enable_post_type_archive_pagination');

// Modify main query for post type archives to limit posts
function modify_post_type_archive_query($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_post_type_archive()) {
            $query->set('posts_per_page', 3);
        }
    }
}
add_action('pre_get_posts', 'modify_post_type_archive_query');
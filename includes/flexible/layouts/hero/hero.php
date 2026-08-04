<?php
// Reuses the .block-hero styles from assets/scss/blocks/_hero.scss (same markup/classes
// as includes/blocks/hero.php) — no dedicated SCSS partial needed for this layout.
$section = get_sub_field('group_hero') ?: [];

if (empty($section['disable_section'])):
    $background_type = $section['background_type'] ?? 'image';
    $image = $section['image'] ?? '';
    $background_color = $section['background_color'] ?? '';
    $background_gradient = $section['background_gradient'] ?? '';
    $content_type = $section['content_type'] ?? '';
    $overlay_color = $section['overlay_color'] ?? '';

    // Image type only: fall back to the featured image, then the theme default.
    if ($background_type === 'image' && $image === '' && has_post_thumbnail()) {
        $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
    }
    if ($background_type === 'image' && $image === '') {
        $image = get_template_directory_uri() . '/assets/img/bg.webp';
    }

    $section_classes = 'block-hero flex-hero';
    if ($content_type) {
        $section_classes .= ' ' . $content_type;
    }

    $custom_class = trim($section['custom_class'] ?? '');
    if ($custom_class !== '') {
        $section_classes .= ' ' . sanitize_text_field($custom_class);
    }

    $min_height_desktop = $section['min_height_desktop'] ?? '';
    $min_height_mobile  = $section['min_height_mobile'] ?? '';

    $section_style = base_theme_hero_background_style($background_type, $image, $background_color, $background_gradient);
    $section_style .= base_theme_hero_min_height_style($min_height_desktop, $min_height_mobile);

    // Overlay only makes sense on top of an image — a color/gradient background is already
    // fully under the editor's control.
    $overlay_style = $background_type === 'image' ? base_theme_hero_overlay_style($overlay_color) : '';
?>
<section class="<?php echo esc_attr($section_classes); ?>" style="<?php echo esc_attr($section_style); ?>">
    <?php if ($overlay_style !== '') : ?>
    <div class="hero-overlay" style="<?php echo esc_attr($overlay_style); ?>"></div>
    <?php endif; ?>
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
<?php endif; ?>

<?php
// Reuses the .block-hero styles from assets/scss/blocks/_hero.scss (same markup/classes
// as includes/blocks/hero.php) — no dedicated SCSS partial needed for this layout.
$section = get_sub_field('group_hero') ?: [];

if (empty($section['disable_section'])):
    $image = $section['image'] ?? '';
    $content_type = $section['content_type'] ?? '';

    $thumbnail = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : '';
    $default_image = get_template_directory_uri() . '/assets/img/bg.webp';
    $background_image = $image ?: ($thumbnail ?: $default_image);

    $section_classes = 'block-hero flex-hero';
    if ($image && $content_type) {
        $section_classes .= ' ' . $content_type;
    }

    $custom_class = trim($section['custom_class'] ?? '');
    if ($custom_class !== '') {
        $section_classes .= ' ' . sanitize_text_field($custom_class);
    }
?>
<section class="<?php echo esc_attr($section_classes); ?>" style="background-image: url('<?php echo esc_url($background_image); ?>');">
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

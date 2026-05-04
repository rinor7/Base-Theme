<?php
$section = get_sub_field('two-side-image-text-group') ?: [];

if (empty($section['disable_section'])):
    $image_url = $section['image'] ?? '';
    $button_1 = $section['button_1'] ?? null;
    $button_2 = $section['button_2'] ?? null;
    $section_classes = 'flex-image-text';

    if (!empty($section['image_no_container_left'])) {
        $section_classes .= ' image-no-container-left';
    }

    $allowed_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p');
    $title_1_tag = $section['titleh1_tag'] ?? 'h2';
    $title_2_tag = $section['titleh2_tag'] ?? 'h3';
    $title_3_tag = $section['titleh3_tag'] ?? 'p';

    if (!in_array($title_1_tag, $allowed_tags, true)) {
        $title_1_tag = 'h2';
    }
    if (!in_array($title_2_tag, $allowed_tags, true)) {
        $title_2_tag = 'h3';
    }
    if (!in_array($title_3_tag, $allowed_tags, true)) {
        $title_3_tag = 'p';
    }

    $font_color_map = array(
        'primary'   => 'var(--primary-color)',
        'secondary' => 'var(--secondary-color)',
        'font'      => 'var(--font-color)',
        'white'     => 'var(--white)',
        'black'     => 'var(--black)',
    );
    $font_color_key = $section['font_color'] ?? '';
    $heading_style_attr = '';
    if ($font_color_key === 'custom') {
        $custom_color = $section['font_color_custom'] ?? '';
        if (!empty($custom_color)) {
            $heading_style_attr = ' style="color:' . esc_attr($custom_color) . ';"';
        }
    } elseif (!empty($font_color_key) && isset($font_color_map[$font_color_key])) {
        $heading_style_attr = ' style="color:' . esc_attr($font_color_map[$font_color_key]) . ';"';
    }
?>
<section class="<?php echo esc_attr($section_classes); ?>">
    <div class="container">
        <div class="row">
            <div class="flex-image-text__media col-lg-6">
                <?php if (!empty($image_url)): ?>
                    <div class="flex-image-text__image">
                        <img src="<?php echo esc_url($image_url); ?>" alt="" loading="lazy">
                    </div>
                <?php endif; ?>
            </div>
            <div class="flex-image-text__content col-lg-6">
                <?php if (!empty($section['titleh1'])): ?>
                    <<?php echo esc_attr($title_1_tag); ?><?php echo $heading_style_attr; ?>><?php echo esc_html($section['titleh1']); ?></<?php echo esc_attr($title_1_tag); ?>>
                <?php endif; ?>

                <?php if (!empty($section['titleh2'])): ?>
                    <<?php echo esc_attr($title_2_tag); ?><?php echo $heading_style_attr; ?>><?php echo esc_html($section['titleh2']); ?></<?php echo esc_attr($title_2_tag); ?>>
                <?php endif; ?>

                <?php if (!empty($section['titleh3'])): ?>
                    <<?php echo esc_attr($title_3_tag); ?><?php echo $heading_style_attr; ?>><?php echo wp_kses_post(strip_outer_p_tags($section['titleh3'])); ?></<?php echo esc_attr($title_3_tag); ?>>
                <?php endif; ?>

                <?php if (!empty($button_1) || !empty($button_2)): ?>
                    <div class="flex-image-text__buttons">
                        <?php if (!empty($button_1['title']) && !empty($button_1['url'])): ?>
                            <div class="default-btn">
                                <a href="<?php echo esc_url($button_1['url']); ?>"<?php echo !empty($button_1['target']) ? ' target="' . esc_attr($button_1['target']) . '"' : ''; ?> class="link-btn"><?php echo esc_html($button_1['title']); ?></a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($button_2['title']) && !empty($button_2['url'])): ?>
                            <div class="default-btn two-btns">
                                <a href="<?php echo esc_url($button_2['url']); ?>"<?php echo !empty($button_2['target']) ? ' target="' . esc_attr($button_2['target']) . '"' : ''; ?> class="link-btn"><?php echo esc_html($button_2['title']); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
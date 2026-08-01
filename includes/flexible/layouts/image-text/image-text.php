<?php
$section = get_sub_field('two-side-image-text-group') ?: [];

if (empty($section['disable_section'])):
    $image_field = $section['image'] ?? null;
    $image_url = $image_field['url'] ?? '';
    $image_alt = trim($image_field['alt'] ?? '');
    if ($image_alt === '') {
        if (!empty($section['titleh1'])) {
            $image_alt = wp_strip_all_tags($section['titleh1']);
        } elseif (!empty($section['titleh2'])) {
            $image_alt = wp_strip_all_tags($section['titleh2']);
        } elseif (!empty($section['titleh3'])) {
            $image_alt = wp_strip_all_tags($section['titleh3']);
        }
    }
    $button_1 = $section['button_1'] ?? null;
    $button_2 = $section['button_2'] ?? null;
    $button_1_style = ($section['button_1_style'] ?? 'btn-1') === 'btn-2' ? 'btn-style-2' : 'btn-style-1';
    $button_2_style = ($section['button_2_style'] ?? 'btn-1') === 'btn-2' ? 'btn-style-2' : 'btn-style-1';
    $image_position = !empty($section['image_position']) ? 'right' : 'left';

    $instance_index = get_next_instance_index('flex-image-text');
    $section_classes = 'flex-image-text image-position-' . $image_position . ' flex-image-text-index-' . $instance_index;

    if (!empty($section['image_no_container'])) {
        $section_classes .= ' image-no-container-' . $image_position;
    }

    $custom_class = trim($section['custom_class'] ?? '');
    if ($custom_class !== '') {
        $section_classes .= ' ' . sanitize_text_field($custom_class);
    }

    $row_class = 'row' . ($image_position === 'right' ? ' flex-lg-row-reverse' : '');

    $font_color_map = array(
        'primary'   => 'var(--primary-color)',
        'secondary' => 'var(--secondary-color)',
        'font'      => 'var(--font-color)',
        'white'     => 'var(--white)',
        'black'     => 'var(--black)',
    );
    $build_background_style = function ($type, $custom_color, $gradient) use ($font_color_map) {
        if ($type === 'gradient') {
            $gradient = trim($gradient);
            return $gradient !== '' ? 'background:' . $gradient . ';' : '';
        }
        if ($type === 'custom') {
            return !empty($custom_color) ? 'background-color:' . $custom_color . ';' : '';
        }
        if (!empty($type) && isset($font_color_map[$type])) {
            return 'background-color:' . $font_color_map[$type] . ';';
        }
        return '';
    };

    $padding_desktop = $section['padding_desktop'] ?? '';
    $padding_mobile  = $section['padding_mobile'] ?? '';
    $section_style = $build_background_style($section['background_color'] ?? '', $section['background_color_custom'] ?? '', $section['background_gradient'] ?? '');
    if ($padding_desktop !== '') {
        $section_style .= '--section-padding-desktop:' . intval($padding_desktop) . 'px;';
    }
    if ($padding_mobile !== '') {
        $section_style .= '--section-padding-mobile:' . intval($padding_mobile) . 'px;';
    }
    $section_style_attr = $section_style ? ' style="' . esc_attr($section_style) . '"' : '';

    $row_gap_desktop = $section['row_gap_desktop'] ?? '';
    $row_gap_mobile  = $section['row_gap_mobile'] ?? '';
    $content_style = '';
    if ($row_gap_desktop !== '') {
        $content_style .= '--row-gap-desktop:' . intval($row_gap_desktop) . 'px;';
    }
    if ($row_gap_mobile !== '') {
        $content_style .= '--row-gap-mobile:' . intval($row_gap_mobile) . 'px;';
    }
    $content_style_attr = $content_style ? ' style="' . esc_attr($content_style) . '"' : '';

    $image_border_radius = $section['image_border_radius'] ?? '';
    $image_height_desktop = $section['image_height_desktop'] ?? '';
    $image_height_mobile  = $section['image_height_mobile'] ?? '';
    $image_style = '';
    if ($image_border_radius !== '') {
        $image_style .= '--image-border-radius:' . intval($image_border_radius) . 'px;';
    }
    if ($image_height_desktop !== '') {
        $image_style .= '--image-height-desktop:' . intval($image_height_desktop) . 'px;';
    }
    if ($image_height_mobile !== '') {
        $image_style .= '--image-height-mobile:' . intval($image_height_mobile) . 'px;';
    }
    $image_style_attr = $image_style ? ' style="' . esc_attr($image_style) . '"' : '';

    $image_fit = ($section['image_fit'] ?? 'cover') === 'contain' ? 'contain' : 'cover';
    $image_class = 'flex-image-text__image image-fit-' . $image_fit;

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

    $build_heading_style_attr = function ($color_key, $custom_color) use ($font_color_map) {
        if ($color_key === 'custom') {
            if (!empty($custom_color)) {
                return ' style="color:' . esc_attr($custom_color) . ';"';
            }
            return '';
        }
        if (!empty($color_key) && isset($font_color_map[$color_key])) {
            return ' style="color:' . esc_attr($font_color_map[$color_key]) . ';"';
        }
        return '';
    };

    $heading_1_style_attr = $build_heading_style_attr($section['titleh1_color'] ?? '', $section['titleh1_color_custom'] ?? '');
    $heading_2_style_attr = $build_heading_style_attr($section['titleh2_color'] ?? '', $section['titleh2_color_custom'] ?? '');
    $heading_3_style_attr = $build_heading_style_attr($section['titleh3_color'] ?? '', $section['titleh3_color_custom'] ?? '');
?>
<section class="<?php echo esc_attr($section_classes); ?>"<?php echo $section_style_attr; ?>>
    <div class="container">
        <div class="<?php echo esc_attr($row_class); ?>">
            <div class="flex-image-text__media col-lg-6">
                <?php if (!empty($image_url)): ?>
                    <div class="<?php echo esc_attr($image_class); ?>"<?php echo $image_style_attr; ?>>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" loading="lazy">
                    </div>
                <?php endif; ?>
            </div>
            <div class="flex-image-text__content col-lg-6"<?php echo $content_style_attr; ?>>
                <?php if (!empty($section['titleh1'])): ?>
                    <<?php echo esc_attr($title_1_tag); ?><?php echo $heading_1_style_attr; ?>><?php echo esc_html($section['titleh1']); ?></<?php echo esc_attr($title_1_tag); ?>>
                <?php endif; ?>

                <?php if (!empty($section['titleh2'])): ?>
                    <<?php echo esc_attr($title_2_tag); ?><?php echo $heading_2_style_attr; ?>><?php echo esc_html($section['titleh2']); ?></<?php echo esc_attr($title_2_tag); ?>>
                <?php endif; ?>

                <?php if (!empty($section['titleh3'])): ?>
                    <<?php echo esc_attr($title_3_tag); ?><?php echo $heading_3_style_attr; ?>><?php echo wp_kses_post(strip_outer_p_tags($section['titleh3'])); ?></<?php echo esc_attr($title_3_tag); ?>>
                <?php endif; ?>

                <?php if (!empty($button_1) || !empty($button_2)): ?>
                    <div class="flex-image-text__buttons">
                        <?php if (!empty($button_1['title']) && !empty($button_1['url'])): ?>
                            <div class="default-btn">
                                <a href="<?php echo esc_url($button_1['url']); ?>"<?php echo !empty($button_1['target']) ? ' target="' . esc_attr($button_1['target']) . '"' : ''; ?> class="link-btn <?php echo esc_attr($button_1_style); ?>"><?php echo esc_html($button_1['title']); ?></a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($button_2['title']) && !empty($button_2['url'])): ?>
                            <div class="default-btn two-btns">
                                <a href="<?php echo esc_url($button_2['url']); ?>"<?php echo !empty($button_2['target']) ? ' target="' . esc_attr($button_2['target']) . '"' : ''; ?> class="link-btn <?php echo esc_attr($button_2_style); ?>"><?php echo esc_html($button_2['title']); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
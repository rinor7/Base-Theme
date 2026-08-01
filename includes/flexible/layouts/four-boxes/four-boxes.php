<?php
$section = get_sub_field('group_four_boxes') ?: [];

if (empty($section['disable_section'])):
    $items = $section['items'] ?? [];

    $allowed_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p');

    $font_color_map = array(
        'primary'   => 'var(--primary-color)',
        'secondary' => 'var(--secondary-color)',
        'font'      => 'var(--font-color)',
        'white'     => 'var(--white)',
        'black'     => 'var(--black)',
    );
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
    $title_style_attr = $build_heading_style_attr($section['title_color'] ?? '', $section['title_color_custom'] ?? '');
    $subtitle_style_attr = $build_heading_style_attr($section['subtitle_color'] ?? '', $section['subtitle_color_custom'] ?? '');
    $item_title_style_attr = $build_heading_style_attr($section['item_title_color'] ?? '', $section['item_title_color_custom'] ?? '');
    $item_subtitle_style_attr = $build_heading_style_attr($section['item_subtitle_color'] ?? '', $section['item_subtitle_color_custom'] ?? '');

    $bg_color = $section['background_color'] ?? '';
    $padding_desktop = $section['padding_desktop'] ?? '';
    $padding_mobile  = $section['padding_mobile'] ?? '';
    $section_style = '';
    if (!empty($bg_color)) {
        $section_style .= '--section-bg-color:' . $bg_color . ';';
    }
    if ($padding_desktop !== '') {
        $section_style .= '--section-padding-desktop:' . intval($padding_desktop) . 'px;';
    }
    if ($padding_mobile !== '') {
        $section_style .= '--section-padding-mobile:' . intval($padding_mobile) . 'px;';
    }
    $section_style_attr = $section_style ? ' style="' . esc_attr($section_style) . '"' : '';

    $instance_index = get_next_instance_index('four-boxes');
    $section_classes = 'four-boxes four-boxes-index-' . $instance_index;
    $custom_class = trim($section['custom_class'] ?? '');
    if ($custom_class !== '') {
        $section_classes .= ' ' . sanitize_text_field($custom_class);
    }

    $title_section    = $section['title_section'] ?? '';
    $subtitle_section = $section['subtitle_section'] ?? '';
    $margin_desktop   = !empty($section['margin_bottom_desktop'])
        ? (int)$section['margin_bottom_desktop'] . 'px'
        : '6px';
    $margin_mobile    = !empty($section['margin_bottom_mobile'])
        ? (int)$section['margin_bottom_mobile'] . 'px'
        : $margin_desktop;

    $header_style = '--mb-desktop:' . $margin_desktop . ';--mb-mobile:' . $margin_mobile . ';';
    if (!empty($section['header_row_gap_desktop'])) {
        $header_style .= '--header-gap-desktop:' . intval($section['header_row_gap_desktop']) . 'px;';
    }
    if (!empty($section['header_row_gap_mobile'])) {
        $header_style .= '--header-gap-mobile:' . intval($section['header_row_gap_mobile']) . 'px;';
    }

    $columns_desktop = (int)($section['columns_desktop'] ?? 4);
    if (!in_array($columns_desktop, array(2, 3, 4), true)) {
        $columns_desktop = 4;
    }
    $col_lg = 12 / $columns_desktop;
    $col_sm = $columns_desktop === 2 ? 12 : 6;
    $col_class = 'col-lg-' . $col_lg . ' col-sm-' . $col_sm;
?>
<section class="<?php echo esc_attr($section_classes); ?>"<?php echo $section_style_attr; ?> aria-label="Boxes Section">
    <div class="container">
        <?php if ($title_section || $subtitle_section): ?>
            <div class="section-header" style="<?php echo esc_attr($header_style); ?>">
                <?php if ($title_section): ?>
                    <div class="section-header-title"<?php echo $title_style_attr; ?>><?php echo wp_kses_post(strip_outer_p_tags($title_section)); ?></div>
                <?php endif; ?>
                <?php if ($subtitle_section): ?>
                    <div class="section-header-subtitle"<?php echo $subtitle_style_attr; ?>><?php echo wp_kses_post(strip_outer_p_tags($subtitle_section)); ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($items)): ?>
            <div class="row">
                <?php foreach ($items as $item):
                    $image_field = $item['image'] ?? null;
                    $image     = $image_field['url'] ?? '';
                    $title     = $item['title'] ?? '';
                    $subtitle  = $item['subtitle'] ?? '';
                    $title_tag = $item['title_tag'] ?? 'h2';
                    if (!in_array($title_tag, $allowed_tags, true)) $title_tag = 'h2';
                    if (empty($image) && empty($title) && empty($subtitle)) continue;
                    $image_alt = trim($image_field['alt'] ?? '');
                    if ($image_alt === '') {
                        $image_alt = $title !== '' ? $title : $subtitle;
                    }
                ?>
                    <div class="box <?php echo esc_attr($col_class); ?>">
                        <div class="box__wrap">
                            <?php if (!empty($image)): ?>
                                <div class="img">
                                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($image_alt); ?>" loading="lazy">
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($title)): ?>
                                <<?php echo esc_attr($title_tag); ?><?php echo $item_title_style_attr; ?>><?php echo esc_html($title); ?></<?php echo esc_attr($title_tag); ?>>
                            <?php endif; ?>
                            <?php if (!empty($subtitle)): ?>
                                <p<?php echo $item_subtitle_style_attr; ?>><?php echo esc_html($subtitle); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

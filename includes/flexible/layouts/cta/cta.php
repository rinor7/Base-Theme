<?php
$section = get_sub_field('group_cta') ?: [];

if (empty($section['disable_section'])):
    $subtitle = $section['subtitle'] ?? '';
    $title    = $section['title'] ?? '';
    $button_1 = $section['button_1'] ?? null;
    $button_2 = $section['button_2'] ?? null;

    $allowed_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p');
    $subtitle_tag = $section['subtitle_tag'] ?? 'p';
    $title_tag    = $section['title_tag']    ?? 'h2';
    if (!in_array($subtitle_tag, $allowed_tags, true)) $subtitle_tag = 'p';
    if (!in_array($title_tag, $allowed_tags, true))    $title_tag    = 'h2';

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
    $subtitle_style_attr = $build_heading_style_attr($section['subtitle_color'] ?? '', $section['subtitle_color_custom'] ?? '');
    $title_style_attr = $build_heading_style_attr($section['title_color'] ?? '', $section['title_color_custom'] ?? '');

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

    $instance_index = get_next_instance_index('cta');
    $section_classes = 'cta cta-index-' . $instance_index;
    $custom_class = trim($section['custom_class'] ?? '');
    if ($custom_class !== '') {
        $section_classes .= ' ' . sanitize_text_field($custom_class);
    }

    $button_1_style = ($section['button_1_style'] ?? 'btn-1') === 'btn-2' ? 'btn-style-2' : 'btn-style-1';
    $button_2_style = ($section['button_2_style'] ?? 'btn-1') === 'btn-2' ? 'btn-style-2' : 'btn-style-1';

    $has_btn_1 = is_array($button_1) && !empty($button_1['url']) && !empty($button_1['title']);
    $has_btn_2 = is_array($button_2) && !empty($button_2['url']) && !empty($button_2['title']);
?>
<section class="<?php echo esc_attr($section_classes); ?>"<?php echo $section_style_attr; ?> aria-label="Call to Action">
    <div class="container">
        <div class="side-wrapper">
            <?php if (!empty($subtitle) || !empty($title)): ?>
                <div class="lefts">
                    <?php if (!empty($subtitle)): ?>
                        <<?php echo esc_attr($subtitle_tag); ?><?php echo $subtitle_style_attr; ?>><?php echo esc_html($subtitle); ?></<?php echo esc_attr($subtitle_tag); ?>>
                    <?php endif; ?>
                    <?php if (!empty($title)): ?>
                        <<?php echo esc_attr($title_tag); ?><?php echo $title_style_attr; ?>><?php echo esc_html($title); ?></<?php echo esc_attr($title_tag); ?>>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if ($has_btn_1 || $has_btn_2): ?>
                <div class="rights">
                    <div class="buttons">
                        <?php if ($has_btn_1): ?>
                            <div class="default-btn">
                                <a href="<?php echo esc_url($button_1['url']); ?>"<?php echo !empty($button_1['target']) ? ' target="' . esc_attr($button_1['target']) . '"' : ''; ?> class="link-btn <?php echo esc_attr($button_1_style); ?>"><?php echo esc_html($button_1['title']); ?></a>
                            </div>
                        <?php endif; ?>
                        <?php if ($has_btn_2): ?>
                            <div class="default-btn two-btns">
                                <a href="<?php echo esc_url($button_2['url']); ?>"<?php echo !empty($button_2['target']) ? ' target="' . esc_attr($button_2['target']) . '"' : ''; ?> class="link-btn <?php echo esc_attr($button_2_style); ?>"><?php echo esc_html($button_2['title']); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

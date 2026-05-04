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

    $title_section    = $section['title_section'] ?? '';
    $subtitle_section = $section['subtitle_section'] ?? '';
    $margin_desktop   = !empty($section['margin_bottom_desktop'])
        ? (int)$section['margin_bottom_desktop'] . 'px'
        : '6px';
    $margin_mobile    = !empty($section['margin_bottom_mobile'])
        ? (int)$section['margin_bottom_mobile'] . 'px'
        : $margin_desktop;

    $columns_desktop = (int)($section['columns_desktop'] ?? 4);
    if (!in_array($columns_desktop, array(2, 3, 4), true)) {
        $columns_desktop = 4;
    }
    $col_lg = 12 / $columns_desktop;
    $col_sm = $columns_desktop === 2 ? 12 : 6;
    $col_class = 'col-lg-' . $col_lg . ' col-sm-' . $col_sm;
?>
<section class="four-boxes" aria-label="Boxes Section">
    <div class="container">
        <?php if ($title_section || $subtitle_section): ?>
            <div class="section-header" style="--mb-desktop:<?php echo esc_attr($margin_desktop); ?>;--mb-mobile:<?php echo esc_attr($margin_mobile); ?>;">
                <?php if ($title_section): ?>
                    <div class="section-header-title"<?php echo $heading_style_attr; ?>><?php echo wp_kses_post(strip_outer_p_tags($title_section)); ?></div>
                <?php endif; ?>
                <?php if ($subtitle_section): ?>
                    <div class="section-header-subtitle"<?php echo $heading_style_attr; ?>><?php echo wp_kses_post(strip_outer_p_tags($subtitle_section)); ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($items)): ?>
            <div class="row">
                <?php foreach ($items as $item):
                    $image     = $item['image'] ?? '';
                    $title     = $item['title'] ?? '';
                    $subtitle  = $item['subtitle'] ?? '';
                    $title_tag = $item['title_tag'] ?? 'h2';
                    if (!in_array($title_tag, $allowed_tags, true)) $title_tag = 'h2';
                    if (empty($image) && empty($title) && empty($subtitle)) continue;
                ?>
                    <div class="box <?php echo esc_attr($col_class); ?>">
                        <div class="box__wrap">
                            <?php if (!empty($image)): ?>
                                <div class="img">
                                    <img src="<?php echo esc_url($image); ?>" alt="" loading="lazy">
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($title)): ?>
                                <<?php echo esc_attr($title_tag); ?><?php echo $heading_style_attr; ?>><?php echo esc_html($title); ?></<?php echo esc_attr($title_tag); ?>>
                            <?php endif; ?>
                            <?php if (!empty($subtitle)): ?>
                                <p<?php echo $heading_style_attr; ?>><?php echo esc_html($subtitle); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

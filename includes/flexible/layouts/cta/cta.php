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

    $has_btn_1 = is_array($button_1) && !empty($button_1['url']) && !empty($button_1['title']);
    $has_btn_2 = is_array($button_2) && !empty($button_2['url']) && !empty($button_2['title']);
?>
<section class="cta" aria-label="Call to Action">
    <div class="container">
        <div class="side-wrapper">
            <?php if (!empty($subtitle) || !empty($title)): ?>
                <div class="lefts">
                    <?php if (!empty($subtitle)): ?>
                        <<?php echo esc_attr($subtitle_tag); ?><?php echo $heading_style_attr; ?>><?php echo esc_html($subtitle); ?></<?php echo esc_attr($subtitle_tag); ?>>
                    <?php endif; ?>
                    <?php if (!empty($title)): ?>
                        <<?php echo esc_attr($title_tag); ?><?php echo $heading_style_attr; ?>><?php echo esc_html($title); ?></<?php echo esc_attr($title_tag); ?>>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if ($has_btn_1 || $has_btn_2): ?>
                <div class="rights">
                    <div class="buttons">
                        <?php if ($has_btn_1): ?>
                            <div class="default-btn">
                                <a href="<?php echo esc_url($button_1['url']); ?>"<?php echo !empty($button_1['target']) ? ' target="' . esc_attr($button_1['target']) . '"' : ''; ?> class="link-btn"><?php echo esc_html($button_1['title']); ?></a>
                            </div>
                        <?php endif; ?>
                        <?php if ($has_btn_2): ?>
                            <div class="default-btn two-btns">
                                <a href="<?php echo esc_url($button_2['url']); ?>"<?php echo !empty($button_2['target']) ? ' target="' . esc_attr($button_2['target']) . '"' : ''; ?> class="link-btn"><?php echo esc_html($button_2['title']); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

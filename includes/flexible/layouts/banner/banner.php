<?php 
$banner = get_sub_field('group_banner') ?: [];
if (empty($banner['disable_section'])): 
    $video_url = $banner['video'] ?? '';
    $image_url = $banner['image'] ?? '';
    $overlay_color = $banner['video_overlay_color'] ?? '#000000a1';
    $bg_overlay_color = $banner['background_overlay_color'] ?? '#000000a1';
    $bg_overlay_gradient = trim($banner['background_overlay_gradient'] ?? '');
    $bg_overlay_style = $bg_overlay_gradient
        ? 'background: ' . $bg_overlay_gradient . ';'
        : 'background-color: ' . $bg_overlay_color . ';';

    // Handle height logic
    $min_height = $banner['min_height_desktop'] ?? '';
    if (wp_is_mobile() && !empty($banner['min_height_mobile'])) {
        $min_height = $banner['min_height_mobile'];
    }
    if (is_numeric($min_height)) {
        $min_height .= 'px';
    }

    // Build style attribute for section
    $inline_style = '';
    if (!empty($min_height)) {
        $inline_style .= 'height:' . esc_attr($min_height) . ';';
    }
    if (!$video_url && $image_url) {
        $inline_style .= 'background-image:url(' . esc_url($image_url) . ');';
    }
?>
<section class="banner__section"
    <?php if (!empty($inline_style)): ?>style="<?php echo $inline_style; ?>"<?php endif; ?>
    aria-label="Banner">

    <?php if ($video_url): ?>
        <div class="video-wrapper">
            <video autoplay muted loop playsinline preload="auto" class="banner-video">
                <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="overlay" style="background-color: <?php echo esc_attr( $overlay_color ); ?>;"></div>
        </div>
    <?php else: ?>
        <div class="image-overlay" style="<?php echo esc_attr($bg_overlay_style); ?>"></div>
    <?php endif; ?>

    <?php
    $content_width = $banner['content_width'] ?? 'two_columns';
    $right_image   = $banner['right_image'] ?? '';
    $right_col_class = '';

    switch ($content_width) {
        case 'narrow':
            $col_class = 'col-lg-5';
            $right_col_class = 'col-lg-7';
            break;
        case 'two_columns':
            $col_class = 'col-lg-6';
            $right_col_class = 'col-lg-6';
            break;
        case 'wide':
            $col_class = 'col-lg-7';
            $right_col_class = 'col-lg-5';
            break;
        case 'full_width':
        default:
            $col_class = 'col-lg-12';
            break;
    }

    $has_right_image = $right_col_class && !empty($right_image);
    $reverse_layout  = $has_right_image && !empty($banner['reverse_layout']);
    $row_class       = 'row' . ($reverse_layout ? ' flex-lg-row-reverse' : '');
    ?>
    <div class="container">
        <div class="<?php echo esc_attr($row_class); ?>">
           <?php

            // Desktop alignment only for full width
            $alignment_desktop = $banner['content_alignment'] ?? 'center'; // left | center

            // Mobile alignment always available
            $alignment_mobile  = $banner['content_alignment_mobile'] ?? 'center'; // left | center

            // Build classes
            $alignment_class = '';
            if ($col_class === 'col-lg-12') {
                $alignment_class .= ' align-desktop-' . $alignment_desktop;
            }
            $alignment_class .= ' align-mobile-' . $alignment_mobile;

            $allowed_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p');
            $title_tag = $banner['title_tag'] ?? 'h1';
            $subtitle_tag = $banner['subtitle_tag'] ?? 'p';

            if (!in_array($title_tag, $allowed_tags, true)) {
                $title_tag = 'h1';
            }
            if (!in_array($subtitle_tag, $allowed_tags, true)) {
                $subtitle_tag = 'p';
            }

            $font_color_map = array(
                'primary'   => 'var(--primary-color)',
                'secondary' => 'var(--secondary-color)',
                'font'      => 'var(--font-color)',
                'white'     => 'var(--white)',
                'black'     => 'var(--black)',
            );
            $font_color_key = $banner['font_color'] ?? '';
            $heading_style_attr = '';
            if ($font_color_key === 'custom') {
                $custom_color = $banner['font_color_custom'] ?? '';
                if (!empty($custom_color)) {
                    $heading_style_attr = ' style="color:' . esc_attr($custom_color) . ';"';
                }
            } elseif (!empty($font_color_key) && isset($font_color_map[$font_color_key])) {
                $heading_style_attr = ' style="color:' . esc_attr($font_color_map[$font_color_key]) . ';"';
            }

            $row_gap_desktop = $banner['row_gap_desktop'] ?? '';
            $row_gap_mobile  = $banner['row_gap_mobile'] ?? '';
            $lefts_style = '';
            if ($row_gap_desktop !== '') {
                $lefts_style .= '--row-gap-desktop:' . intval($row_gap_desktop) . 'px;';
            }
            if ($row_gap_mobile !== '') {
                $lefts_style .= '--row-gap-mobile:' . intval($row_gap_mobile) . 'px;';
            }
            $lefts_style_attr = $lefts_style ? ' style="' . esc_attr($lefts_style) . '"' : '';
            ?>
            <div class="lefts <?php echo esc_attr($col_class . ' ' . $alignment_class); ?>"<?php echo $lefts_style_attr; ?>>
                <?php if (!empty($banner['title'])): ?>
                    <<?php echo esc_attr($title_tag); ?><?php echo $heading_style_attr; ?>><?php echo esc_html($banner['title']); ?></<?php echo esc_attr($title_tag); ?>>
                <?php endif; ?>

                <?php if (!empty($banner['subtitle'])): ?>
                    <<?php echo esc_attr($subtitle_tag); ?><?php echo $heading_style_attr; ?>><?php echo esc_html($banner['subtitle']); ?></<?php echo esc_attr($subtitle_tag); ?>>
                <?php endif; ?>

                <?php
                $button_1 = $banner['button_1'] ?? '';
                $button_2 = $banner['button_2'] ?? '';
                $has_btn_1 = is_array($button_1) && !empty($button_1['url']) && !empty($button_1['title']);
                $has_btn_2 = is_array($button_2) && !empty($button_2['url']) && !empty($button_2['title']);
                ?>
                <?php if ($has_btn_1 || $has_btn_2): ?>
                    <div class="buttons">
                        <?php if ($has_btn_1): ?>
                            <div class="default-btn"> 
                                <a href="<?php echo esc_url($button_1['url']); ?>" class="link-btn"<?php if (!empty($button_1['target'])): ?> target="<?php echo esc_attr($button_1['target']); ?>"<?php endif; ?>>
                                    <?php echo esc_html($button_1['title']); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($has_btn_2): ?>
                            <div class="default-btn two-btns">
                                <a href="<?php echo esc_url($button_2['url']); ?>" class="link-btn"<?php if (!empty($button_2['target'])): ?> target="<?php echo esc_attr($button_2['target']); ?>"<?php endif; ?>>
                                    <?php echo esc_html($button_2['title']); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($has_right_image): ?>
                <div class="rights <?php echo esc_attr($right_col_class); ?>">
                    <img src="<?php echo esc_url($right_image); ?>" alt="">
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>
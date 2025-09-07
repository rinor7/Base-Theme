<?php 
$banner = get_field('group_banner') ?: [];
if (empty($banner['disable_section'])): 
    $video_url = $banner['video'] ?? '';
    $image_url = $banner['image'] ?? '';
    $overlay_color = $banner['video_overlay_color'] ?? get_field('video_overlay_color') ?? '#000000a1';
    $bg_overlay_color = $banner['background_overlay_color'] ?? get_field('background_overlay_color') ?? '#000000a1';

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
<section class="banner__section banner-all__section"
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
        <div class="image-overlay" style="background-color: <?php echo esc_attr( $bg_overlay_color ); ?>;"></div>
    <?php endif; ?>

    <div class="container">
        <div class="row">
            <div class="lefts col-lg-6">
                <?php if (!empty($banner['title'])): ?>
                    <h1><?php echo esc_html($banner['title']); ?></h1>
                <?php endif; ?>

                <?php if (!empty($banner['subtitle'])): ?>
                    <?php echo $banner['subtitle']; ?>
                <?php endif; ?>

                <?php if (!empty($banner['button_name_1']) || !empty($banner['button_name_2'])): ?>
                    <div class="buttons">
                        <?php if (!empty($banner['button_name_1']) && !empty($banner['button_link_1'])): ?>
                            <div class="default-btn">
                                <a href="<?php echo esc_url($banner['button_link_1']); ?>" class="link-btn">
                                    <?php echo esc_html($banner['button_name_1']); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($banner['button_name_2']) && !empty($banner['button_link_2'])): ?>
                            <div class="default-btn two-btns">
                                <a href="<?php echo esc_url($banner['button_link_2']); ?>" class="link-btn">
                                    <?php echo esc_html($banner['button_name_2']); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="rights col-lg-6"></div>
        </div>
    </div>
</section>
<?php endif; ?>
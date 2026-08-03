<?php
$section = get_sub_field('group_content') ?: [];

if (empty($section['disable_section'])):
    $instance_index = get_next_instance_index('content');
    $section_classes = 'flex-content flex-content-index-' . $instance_index;

    $custom_class = trim($section['custom_class'] ?? '');
    if ($custom_class !== '') {
        $section_classes .= ' ' . sanitize_text_field($custom_class);
    }
?>
<section class="<?php echo esc_attr($section_classes); ?>">
    <div class="container">
        <?php the_content(); ?>
    </div>
</section>
<?php endif; ?>

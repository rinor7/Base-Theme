<?php $section = get_field('pt-noswiper'); if (empty($section['disable_section'])): ?>
<section class="slider__boxes-section-plus">
    <div class="container">
        <?php render_section_header($section); ?>
        <div class="row">
            <?php
                $args = array(
                'post_type' => 'posttype',
                'posts_per_page' => '-1',
                'order' => 'ASC',
                );
                $loop = new WP_Query($args);
                $post_count = $loop->post_count;
                // Determine the column class based on the number of posts
                $col_class = 'col-lg-3';
                if ($post_count == 6) {
                    $col_class = 'col-lg-4';
                }
                while($loop->have_posts()):
                    $loop->the_post();
                ?>
            <div class="box__wrapper <?php echo esc_attr($col_class); ?>">
                <div class="img">
                    <img src="<?php the_post_thumbnail_url();?>" alt="Image" loading=“lazy”>
                </div>
                <h2><?php the_title(); ?></h2>
                <?php the_content(); ?>
            </div>
            <?php
                endwhile;
                wp_reset_postdata();
                ?>
        </div>
    </div>
</section>
<?php endif; ?>
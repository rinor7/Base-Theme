<?php $section = get_field('pt-swiper'); if (empty($section['disable_section'])): ?>
<section class="slider__boxes-section">
    <div class="container">
        <?php render_section_header($section); ?>
        <div class="swiper mySwiper mySwiper-boxes-section">
            <div class="swiper-wrapper">
                <?php
                    $args = array(
                        'post_type' => 'posttype',
                        'posts_per_page' => -1,
                        'order' => 'ASC',
                    );
                    $loop = new WP_Query($args);
                    while ($loop->have_posts()):
                        $loop->the_post();
                    ?>
                <div class="swiper-slide">
                    <div class="slider-wrap">
                        <div class="img">
                            <img src="<?php the_post_thumbnail_url(); ?>" alt="Image" loading="lazy">
                        </div>
                        <h2><?php the_title(); ?></h2>
                        <?php the_content(); ?>
                    </div>
                </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
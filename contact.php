<?php
/* Template Name: Contact */
get_header(); ?>

<main id="primary" class="site-main site-contact">

<?php if (have_rows('flex_sections')) : ?>
    <?php get_template_part('includes/flexible/flexible-render'); ?>
<?php else : ?>
    <div class="container">
        <?php the_content(); ?>
    </div>
<?php endif; ?>

</main>

<?php get_footer();  ?>
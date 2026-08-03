<?php get_header(); ?>

	<main id="primary" class="site-default">

		<?php base_theme_render_automatic_page_hero(); ?>

		<?php if (have_rows('flex_sections')) : ?>
			<?php get_template_part('includes/flexible/flexible-render'); ?>
		<?php else : ?>
			<div class="container">
				<?php the_content(); ?>
			</div>
		<?php endif; ?>

	</main><!-- #main -->


<?php get_footer(); ?>
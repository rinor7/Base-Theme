<?php get_header(); ?>

	<main id="primary" class="site-single single-page">

	<?php include("includes/hero.php"); ?>


	
	<div class="container">
		<div class="content<?php echo (empty($hero) || get_field('show_thumbnail_in_content')) && has_post_thumbnail() ? ' has-post-thumbnail' : ''; ?>">
			<?php if (empty($hero)) : ?>
			<h1><?php the_title(); ?></h1>
			<?php endif; ?>
			<?php if ((empty($hero) || get_field('show_thumbnail_in_content')) && has_post_thumbnail()) : ?>
			<img class="wp-post-image" src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'medium')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
			<?php endif; ?>
			<?php the_content(); ?>
		</div>
	</div>
		

	</main><!-- #main -->



<?php get_footer(); ?>
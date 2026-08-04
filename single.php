<?php get_header(); ?>

	<main id="primary" class="site-single single-page">

	<?php include("includes/hero.php"); ?>


	
	<?php if (has_post_thumbnail()) : ?>
	<div class="intro">
		<img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'full')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
	</div>
	<?php endif; ?>
	
	<div class="container">
		<div class="content">
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</div>
	</div>
		

	</main><!-- #main -->



<?php get_footer(); ?>
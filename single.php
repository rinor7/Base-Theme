<?php
global $header_type; // required to access global variable
include("includes/headers/{$header_type}.php"); 
?>

	<main id="primary" class="site-single single-page">

	<?php include("includes/blocks/hero.php"); ?>


	
	<div class="intro">
		<img src="<?php the_post_thumbnail_url();?>" alt="">
	</div>
	
	<div class="container">
		<div class="content">
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</div>
	</div>
		

	</main><!-- #main -->



<?php include("includes/footers/default.php");  ?>
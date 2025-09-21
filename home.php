<?php
global $header_type; // required to access global variable
include("includes/headers/{$header_type}.php"); 
?>

<main id="primary" class="site-archive archive-page-main-posts">

	<?php include("includes/blocks/hero.php"); ?>

    <div class="container">
        <div class="archive-content">
        <?php if (have_posts()) : ?>

            <div class="page-header">
                <h1 class="page-title"><?php post_type_archive_title(); ?></h1>
        	</div>

            <div class="articles">
            <?php while (have_posts()) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="entry-header">
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </div>
                </article>

            <?php endwhile; ?>
            </div>
            
        <?php else : ?>

            <p><?php _e('No posts found', 'textdomain'); ?></p>

        <?php endif; ?>
        </div>
    </div>
</main>

<?php include("includes/footers/default.php");  ?>
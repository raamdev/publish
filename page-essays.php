<?php
/**
 * Template Name: Footer Tag Cloud 
 */

get_header(); ?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>
					
					<?php if ( function_exists('wp_tag_cloud') ) : ?>
						<h2>Commonly Used Tags</h2>
						<?php wp_tag_cloud('smallest=10&largest=22'); ?>
					<?php endif; ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

<?php
/**
 * The template used for displaying Essays page content in page-essays.php
 *
 * @package Publish
 * @since Publish 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		
		<?php if ( function_exists('wp_tag_cloud') ) : ?>
			<div class="commonly-used-tags">
			<h1>Common Tags (all topics)</h1>
			<?php wp_tag_cloud('smallest=10&largest=22'); ?>
			</div>
		<?php endif; ?>
		
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'publish' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<?php edit_post_link( __( 'Edit', 'publish' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-<?php the_ID(); ?> -->

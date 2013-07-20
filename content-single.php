<?php
/**
 * @package Publish
 * @since Publish 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php raamdev_post_header_meta(); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( in_category('journal') ) : ?>
			<?php if ( is_raamdev_journal_viewable() ) : // Only show content if Journal is viewable ?>
				
				<?php the_raamdev_journal_released_message(); ?>
				<?php the_content(); ?>
			
			<?php else : // Show message about why Journal is not viewable ?>

				<?php the_raamdev_journal_not_released_message(); ?>
				
			<?php endif; ?>
		<?php else: // Not a journal entry ?>
			
			<?php the_content(); ?>
		
		<?php endif; ?>	
		<?php raamdev_post_authorship(); ?>

	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'publish' ), 'after' => '</div>' ) ); ?>
		<?php //raamdev_post_meta(); ?>
		<?php edit_post_link( __( 'Edit', 'publish' ), '<div class="edit-link">', '</div>' ); ?>
		<?php rd_sharing_buttons(); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->

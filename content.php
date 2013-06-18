<?php
/**
 * @package Publish
 * @since Publish 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'publish' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php if ( in_category('journal') ) : ?>
			<?php if ( is_raamdev_journal_viewable() ) : // Only show excerpts if Journal viewable ?>

				<?php the_raamdev_journal_released_message(); ?>
				<?php the_excerpt(); ?>

			<?php else : // Show message describing why journal is not viewable ?>

				<?php the_raamdev_journal_not_released_message(); ?>
				
			<?php endif; ?>
			
		<?php else : // Not a journal entry ?>
			
			<?php if ('aside' === get_post_format()) : // Do something special for Asides ?>
				
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_content(); ?></a>
				
			<?php else: ?>
				
				<?php the_excerpt(); ?>
			
			<?php endif; ?>
			
		<?php endif; ?>
		
	</div><!-- .entry-summary -->
	
	<?php else : // Not Search ?>
	<div class="entry-content">
		<?php if ( in_category('journal') ) : // Journal entry ?>
			<?php if ( is_raamdev_journal_viewable() ) : // Only show content if Journal is viewable ?>
				
				<?php the_raamdev_journal_released_message(); ?>		
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'publish' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'publish' ), 'after' => '</div>' ) ); ?>
			
			<?php else : // Show message about why Journal is not viewable ?>

				<?php the_raamdev_journal_not_released_message(); ?>
				
			<?php endif; ?>
			
		<?php else: // Not a journal entry ?>
			<?php if ('aside' === get_post_format()) : // Do something special for Asides ?>
				
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_content(); ?></a>
				
			<?php else: ?>
				
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'publish' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'publish' ), 'after' => '</div>' ) ); ?>
				
			<?php endif; ?>

		<?php endif; ?>				
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() || 'journal' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
	
		<?php raamdev_post_meta(); ?>
			
		<?php endif; // End if 'post' == get_post_type() ?>

		<div class="entry-meta-links">
			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'publish' ), __( '1 Comment', 'publish' ), __( '% Comments', 'publish' ) ); ?></span>
			<?php endif; ?>

			<?php edit_post_link( __( 'Edit', 'publish' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
		</div>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->

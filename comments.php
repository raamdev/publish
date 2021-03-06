<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to publish_comment() which is
 * located in the functions.php file.
 *
 * @package Publish
 * @since Publish 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

	<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<!-- START COMMENT REPLY FORM -->

	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
			<p class="nocomments"><?php _e( 'Comments are closed.', 'publish' ); ?></p>
		<?php endif; ?>

	<?php if ( !in_category('journal') || is_raamdev_journal_viewable() ) : ?>
		<?php //comment_form( array( 'comment_notes_after' => '<p class="form-allowed-tags"></p>' ) ); ?>
		<?php $comment_form_args = rd_comment_form_args(); ?>
		<?php comment_form( $comment_form_args ); ?>
		<?php //comment_form( ); ?>

		<div style="clear: both;"></div>

		<?php rd_sharing_buttons_text(); ?>

	<?php endif; // !in_category('journal') ?>

	<!-- END COMMENT REPLY FORM -->

	<?php if ( have_comments() ) : ?>
		<?php if ( !in_category('journal') || is_raamdev_journal_viewable() ) : ?>

			<?php if(get_comments_number() > 0) : ?>
				<div class="leave-a-reply">
					<?php printf( _n( '1 Comment', '%1$s Comments ', get_comments_number(), 'publish' ), number_format_i18n( get_comments_number() ) ); ?>
				</div>
			<?php endif; ?>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav role="navigation" id="comment-nav-above" class="site-navigation comment-navigation">
				<h1 class="assistive-text"><?php _e( 'Comment navigation', 'publish' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'publish' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'publish' ) ); ?></div>
			</nav><!-- #comment-nav-before .site-navigation .comment-navigation -->
			<?php endif; // check for comment navigation ?>

			<ol class="commentlist">
				<?php
					/* Loop through and list the comments. Tell wp_list_comments()
					 * to use publish_comment() to format the comments.
					 * If you want to overload this in a child theme then you can
					 * define publish_comment() and that will be used instead.
					 * See publish_comment() in inc/template-tags.php for more.
					 */
					wp_list_comments( array( 'type' => 'comment', 'callback' => 'publish_comment' ) );
				?>
			</ol><!-- .commentlist -->

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
				<h1 class="assistive-text"><?php _e( 'Comment navigation', 'publish' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'publish' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'publish' ) ); ?></div>
			</nav><!-- #comment-nav-below .site-navigation .comment-navigation -->
			<?php endif; // check for comment navigation ?>
			
			<?php if (comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' )) : ?>
			<div><a href="#respond">Your thoughts? Please click here to leave a reply</a></div>
			<?php endif; ?>
			
		<?php else : ?>
			
			<?php the_raamdev_journal_not_released_comments_message(); ?>
			
		<?php endif; // !in_category('journal') ?>

	<?php endif; // have_comments() ?>

		<br><br>
	<!-- START PING/TRACKBACKS LIST -->

	<?php if ( have_comments() ) : ?>
	<?php if ( count($wp_query->comments_by_type['pings'])) { ?>
	<br />
	<h3 id="pings" class="comments-title"><?php// echo count($wp_query->comments_by_type['pings']); ?>Readers who shared <em><?php the_title(); ?></em></h3>
	        <ul class="pinglist">
	                <?php wp_list_comments('type=pings&callback=publish_theme_pings'); ?>
	        </ul>
	<?php } ?>
	<?php endif; ?>

	<!-- END PING/TRACKBACKS LIST -->
	<?php if( is_single() ) : ?>
	<!-- START Efficient Related Posts LIST -->
	<?php if( function_exists('wp_related_posts') ) { do_action('erp-show-related-posts', array('title'=>'Related Thoughts, Essays, and Journals', 'num_to_display'=>12, 'no_rp_text'=>'No Related Posts Found')); } ?>
	<?php endif; ?>
	<!-- END Efficient Related Posts LIST -->
</div><!-- #comments .comments-area -->

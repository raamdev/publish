<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Publish
 * @since Publish 1.0
 */
?>

	</div><!-- #main .site-main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'publish_credits' ); ?>
		</div><!-- .site-info -->
		
		<nav role="navigation" class="site-navigation main-navigation footer-navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'depth' => 1 ) ); ?>
		</nav>
		
	</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

<?php raamdev_pageslide_subscribe_form(); ?>

</body>
</html>

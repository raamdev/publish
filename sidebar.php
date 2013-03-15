<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Publish
 * @since Publish 1.0
 */
?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php do_action( 'publish_before_sidebar' ); ?>
			<?php dynamic_sidebar( 'sidebar-1' ) ?>

			<?php // Show tag cloud on category and tag archives pages ?>
			<?php if ( is_category() || is_tag() ) { ?>
				<div id="tag-box">
					<h3>Category Tags:</h3>
				<?php 
				  if( function_exists("stc_widget") )
				    stc_widget();
				?> 
				</div>
			<?php } // End if ( is_category() || is_tag() )  ?>
			
		</div><!-- #secondary .widget-area -->

<?php
/**
 * Template Name: Archives
 */

get_header(); ?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

				<?php the_post(); ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
				
				<h2>Search the Archives</h2>
				<?php get_search_form(); ?>

				<h2>Yearly Archives</h2>
				<select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
				  <option value=""><?php echo esc_attr( __( 'Select Year' ) ); ?></option> 
				  <?php wp_get_archives( array( 'type' => 'yearly', 'format' => 'option' ) ); ?>
				</select>

				<h2>Monthly Archives</h2>
				<select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
				  <option value=""><?php echo esc_attr( __( 'Select Month' ) ); ?></option> 
				  <?php wp_get_archives( array( 'type' => 'monthly', 'format' => 'option' ) ); ?>
				</select>

				<h2>Category Archives</h2>
				<ul>
					 <?php wp_list_categories('title_li='); ?>
				</ul>
				
				<?php if ( function_exists('wp_tag_cloud') ) : ?>
					<div class="commonly-used-tags">
					<h2>Commonly Used Tags</h2>
					<?php wp_tag_cloud('smallest=10&largest=22'); ?>
					</div>
				<?php endif; ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

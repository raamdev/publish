<?php
/**
 * Customize the output of pings in the comments section (used by comments.php)
 */
function publish_theme_pings($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    
     <div id="comment-<?php comment_ID(); ?>">     

	<div class="commentbody">
<?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?> <span style="font-size: 12px; color: #AAAAAA;"> <?php printf(__('%1$s '), get_comment_date("Y-m-d"),  get_comment_time("H:i:s")) ?> <?php edit_comment_link(__('(Edit)'),'  ','') ?></span>
     </div>

     </div>
<?php }



/*
 * Create Custom Post Types
 */
add_action( 'init', 'create_post_type_thoughts' );
add_action( 'init', 'create_post_type_journal' );

function create_post_type_thoughts() {	
	register_post_type('thoughts', array(	'label' => 'Thoughts','description' => '','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => false,'rewrite' => array('slug' => ''),'query_var' => true,'has_archive' => true,'supports' => array('title','editor','trackbacks','comments','revisions','custom-fields','post-formats',),'taxonomies' => array('post_tag',),'labels' => array (
	  'name' => 'Thoughts',
	  'singular_name' => 'Thought',
	  'menu_name' => 'Thoughts',
	  'add_new' => 'Add Thought',
	  'add_new_item' => 'Add New Thought',
	  'edit' => 'Edit',
	  'edit_item' => 'Edit Thought',
	  'new_item' => 'New Thought',
	  'view' => 'View Thought',
	  'view_item' => 'View Thought',
	  'search_items' => 'Search Thoughts',
	  'not_found' => 'No Thoughts Found',
	  'not_found_in_trash' => 'No Thoughts Found in Trash',
	  'parent' => 'Parent Thought',
	),) );	
}

function create_post_type_journal() {
	register_post_type('journal', array(	'label' => 'Journal','description' => '','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => false,'rewrite' => array('slug' => ''),'query_var' => true,'has_archive' => true,'supports' => array('title','editor','trackbacks','comments','revisions','custom-fields','post-formats',),'taxonomies' => array('post_tag','category',),'labels' => array (
	  'name' => 'Journal',
	  'singular_name' => 'Journal Entry',
	  'menu_name' => 'Journal',
	  'add_new' => 'Add Journal',
	  'add_new_item' => 'Add New Journal',
	  'edit' => 'Edit',
	  'edit_item' => 'Edit Journal',
	  'new_item' => 'New Journal',
	  'view' => 'View Journal',
	  'view_item' => 'View Journal',
	  'search_items' => 'Search Journal',
	  'not_found' => 'No Journal Entries Found',
	  'not_found_in_trash' => 'No Journal Entries Found in Trash',
	  'parent' => 'Parent Journal Entry',
	),) );
}

if ( ! function_exists( 'get_ncl_location' ) ) :
/**
 * Returns location information supplied by Nomad Current Location plugin
 */
function get_ncl_location( $prefix = "" ) {
	
	$location = get_post_meta( get_the_ID(), 'ncl_current_location', true );
	
		if(trim($location) != "") 
			{ 
				return $location_html = $prefix . '<span class="mapThis" place="' . $location . '" zoom="2">' . $location . '</span>'; 
			}
			else {
				return $location_html = '';
			}
}
endif;

if ( ! function_exists( 'raamdev_post_meta' ) ) :
/**
 * Returns post meta
 */
function raamdev_post_meta() {
	
		// Get location information using Nomad Current Location plugin
		$location_html = get_ncl_location( $prefix = " from ");
	
		/* translators: used between list items, there is a space after the comma */
		$category_list = get_the_category_list( __( ', ', 'publish' ) );

		/* translators: used between list items, there is a space after the comma */
		$tag_list = get_the_tag_list( '', __( ', ', 'publish' ) );

		if ( ! publish_categorized_blog() ) {
			// This blog only has 1 category so we just need to worry about tags in the meta text
			if ( '' != $tag_list ) {
				$meta_text = __( '<span class="meta-data">This entry was tagged %2$s.</span<', 'publish' );
			} else {
				$meta_text = __( '', 'publish' );
			}

		} else {
			// But this blog has loads of categories so we should probably display them here
			if ( '' != $tag_list) {
				$meta_text = __( '<span class="meta-data">Published in %1$s on <a href="%5$s" title="%6$s" rel="bookmark"><time class="entry-date" datetime="%7$s" pubdate>%8$s</time></a>%9$s. Tagged %2$s.</span>', 'publish' );
			} else {
				$meta_text = __( '<span class="meta-data">Published in %1$s on <a href="%5$s" title="%6$s" rel="bookmark"><time class="entry-date" datetime="%7$s" pubdate>%8$s</time></a>%9$s.</span>', 'publish' );
			}

		} // end check for categories on this blog

		printf(
			$meta_text,
			$category_list,
			$tag_list,
			get_permalink(),
			the_title_attribute( 'echo=0' ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			$location_html
		);
}
endif;


if ( ! function_exists( 'raamdev_post_header_meta' ) ) :
/**
 * Returns post header metadata
 */
function raamdev_post_header_meta() {
?>
<!-- START POST HEADER METADATA -->

<div>
<div class="entry-meta">

<?php $audio = get_post_meta( get_the_ID(), 'audio_reading_url', true ); ?>
<?php if (trim($audio) != "") { ?>

<?php if ('journal' == get_post_type()) { ?>
	<?php $release_after=365 * 86400; // days * seconds per day
	$post_age = date('U') - get_post_time('U');
	if ($post_age > $release_after || current_user_can("access_s2member_level1")) { ?>	

	<div id="audio-player"><a class="wpaudio" href="<?php echo $audio; ?>">Listen to Raam Dev reading this entry</a></div>

	<?php } else { // else they don't have permission to view this ?>

	<div id="audio-player"><img class="wpaudio-play" src="http://raamdev.com/wordpress/wp-content/plugins/wpaudio-mp3-player/wpaudio-play.png" style="margin: 0px 5px 0px 0px; width: 14px; height: 13px; background-color: rgb(204, 204, 204); vertical-align: baseline; border: 0px; padding: 0px; background-position: initial initial; background-repeat: initial initial; "><a href="http://raamdev.com/wordpress/wp-login.php" style="border-bottom: 1px solid #eee !important;">Login</a> to listen to Raam Dev reading this entry</div>

	<?php } // ends permissions check ?>
<?php } else { // else it's not a journal entry, so just give access ?>
	<div id="audio-player"><a class="wpaudio" href="<?php echo $audio; ?>">Listen to Raam Dev reading this entry</a></div>
<?php } // ends check if journal ?>	
<?php } // ends check if audio file URL exists ?>

</div>
</div>

<!-- END POST HEADER METADATA -->

<?php }
endif;


function sharing_buttons() {
?>

<!-- START POST SHARING -->

<div style="width: 400px; margin: 0 auto;">
			<div style="float: right; margin-left: 0.75em;"><a href="https://twitter.com/share?url=<?php the_permalink(); ?>&text=RT%20@RaamDev%20<?php the_title(); ?>" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script></div>
<div style="float: right; margin-right: 120px;"><g:plusone size="medium" annotation="none"></g:plusone></div>
<div align="left" style="padding: 0px; width: 95px; overflow: hidden;"><iframe src="//www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;send=false&amp;layout=button_count&amp;width=200&amp;show_faces=false&amp;action=recommend&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=129928197106327" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:130px; height:21px;" allowTransparency="true"></iframe></div>
</div>

<!-- END POST SHARING -->

<?php }


if ( ! function_exists( 'is_raamdev_journal_viewable' ) ) :
/**
 * Returns true if post is more than 1 year old, otherwise returns false
 */
function is_raamdev_journal_viewable() {
	$release_after=365 * 86400; // days * seconds per day
	$post_age = date('U') - get_post_time('U');
	if ( $post_age > $release_after || current_user_can("access_s2member_level1") ) {
		return true;
	} 
	else { 
		return false; 
		}
}
endif;


if ( ! function_exists( 'the_raamdev_journal_released_message' ) ) :
/**
 * Returns message about journal release
 */
function the_raamdev_journal_released_message() {
	// only show this message if the user is not logged in or doesn't have access
	if ( !is_user_logged_in() || !current_user_can("access_s2member_level1") ) :
		?>
		<div style="font-size: 80%; border: 1px solid #eee; padding: 20px; margin-bottom: 20px; line-height: 1.4em; background: #eee;">This is an entry from my <a href="http://raamdev.com/about/journal/">personal Journal</a> and it was published over one year ago. It was initially only available to paying subscribers. However, as per my <a href="http://raamdev.com/income-ethics-series/#public_domain">Income Ethics</a>, "all non-free creative work will be made public domain within one year". So, after spending one year behind a paywall, this content is now free. Ah, sweet freedom!</div>
	
		<?php
	endif;
}
endif;


if ( ! function_exists( 'the_raamdev_journal_not_released_message' ) ) :
/**
 * Returns message about journal not released yet
 */
function the_raamdev_journal_not_released_message() {

		?>
						<div id="journal-notice"><blockquote>
										<p>This journal entry has not been released into the public domain and is currently only available through a subscription to the <a href="http://raamdev.com/about/journal/">Journal</a> or a <a href="/about/journal/#one_time_donation">one-time donation</a>.</p>
	<?php if(is_user_logged_in()) { ?>
	<p>Since you're already logged in, you can <a href="/account/modification/">upgrade now</a> to receive access to this entry.</p>
	<?php } else { ?>
	<p>If you have an active subscription to the Journal, please <a href="https://raamdev.com/wordpress/wp-login.php">login</a> to access this entry (you may need to <a href="https://raamdev.com/wordpress/wp-login.php?action=lostpassword">reset your password</a> first).</p>
	<?php } ?>

						</blockquote></div>
	<?php }
endif;


if ( ! function_exists( 'the_raamdev_journal_not_released_comments_message' ) ) :
/**
 * Returns message about journal not released yet
 */
function the_raamdev_journal_not_released_comments_message() {
	?>
						<div id="journal-notice-comments">
										<p><strong>Comments are hidden.</strong></p>
						</div>
<?php }
endif;


if ( ! function_exists( 'rd_get_recent_posts' ) ) :
/**
 * Returns recent posts for given category and excludes given post formats
 */
function rd_get_recent_posts( $number_posts = '10', $category = '', $exclude_formats = array() ) {

	// Make sure category exists
	if ( !get_cat_ID( $category ) ) { return false; }

	// Build array of format exclution queries
	if( !empty( $exclude_formats ) ) :
		$i=0;
		$tax_query = array();
		
		foreach ( $exclude_formats as $format ) {
			
			$tax_query[$i] = array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => 'post-format-' . $format,
				'operator' => 'NOT IN'
				);

			$i++;
		}
	endif;

	?>
	<ul>
	<?php
		$args = array( 'numberposts' => $number_posts, 'category' => get_cat_ID($category), 'post_status' => 'publish', 'tax_query' => $tax_query );
		$recent_posts = wp_get_recent_posts( $args );
		foreach( $recent_posts as $recent ){
			echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
		}
	?>
	</ul>
<?php
}
endif;


if ( ! function_exists( 'raamdev_pageslide_subscribe_form' ) ) :
/**
 * Returns pageslide subscribe form
 */
function raamdev_pageslide_subscribe_form() {

		?>
	<!-- BEGIN PAGESLIDE SUBSCRIBE FORM CODE -->
	
	<div id="signup" style="display:none">
	<div class="wrapper"><div class="cell">
	<section>
	<p><strong>Subscribe</strong> to receive new thoughts and essays as they're published.</p>
	<form action="http://raamdev.us1.list-manage.com/subscribe/post?u=5daf0f6609de2506882857a28&id=dc1b1538af" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank">
		<?php if ( is_single() && !in_category('journal') ) : ?>
			<?php $reflections = ""; $technology = ""; $writing = ""; ?>
			<?php if( in_category('20') ) { $reflections = "checked"; } ?>
			<?php if( in_category('5') ) { $technology = "checked"; } ?>
			<?php if( in_category('859') ) { $writing = "checked"; } ?>
		<?php else : ?>
			<?php $reflections = "checked"; $technology = "checked"; $writing = "checked"; ?>
		<?php endif; ?>
		
		<div style="display:none;"> <input type="hidden" name="MERGE3" value="<?php echo 'http://' . $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>" id="MERGE3"> </div>
		<div style="display:none;"> <input type="hidden" name="group[1873]" value="32" id="group[1873]"> </div>
		<div class="mc-field-group">
			<label for="mce-group[1129]">How often would you like to receive new updates? </label>
			<select name="group[1129]" class="REQ_CSS" id="mce-group[1129]" tabindex="502">
			<option value="1" selected="selected">Immediately</option>
		<option value="2">Weekly</option>
		<option value="4">Monthly</option>
			</select>
		<div class="subscribe-home-essay-topics">
		Essay topics:&nbsp;&nbsp;
		<input type="checkbox" id="group_64" name="group[1989][64]" value="1" <?php echo $reflections; ?>>&nbsp;<label style="font-style: italic;">Personal Reflections</label>&nbsp;&nbsp;
		<input type="checkbox" id="group_128" name="group[1989][128]" value="1" <?php echo $technology; ?>>&nbsp;<label style="font-style: italic;">Technology</label>&nbsp;&nbsp;
		<input type="checkbox" id="group_256" name="group[1989][256]" value="1" <?php echo $writing; ?>>&nbsp;<label style="font-style: italic;">Writing</label><br>
		</div>
		</div>
	<input type="text" placeholder="First Name..." id="mce-FNAME" name="FNAME">
	<input type="text" placeholder="Email Address..." id="mce-EMAIL" name="EMAIL">
	<input type="submit" value="Subscribe" tabindex="503" >
	</form>
	<hr>
	<small>RSS Feeds:&nbsp;<a href="a">All Topics</a> · <a href="a">Personal Reflections</a> · <a href="a">Writing & Publishing</a> · <a href="a">Technology</a></small>
	<br/><br/>
	<small><a href="javascript:$.pageslide.close()">« Back</a></small>
	</section>
	</div></div>
	</div>


	<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery-pageslide/lib/jquery-1.7.1.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery-pageslide/jquery.pageslide.min.js"></script>
	<script>    
	    /* Slide to the left, and make it model (you'll have to call $.pageslide.close() to close) */
	    $(".signup").pageslide({ direction: "left", modal: true });
	</script>

	<!-- END PAGESLIDE SUBSCRIBE FORM CODE -->
	
<?php }
endif;


if ( ! function_exists( 'rd_new_nav_menu_items' ) ) :
/**
 * Filter wp_nav_menu() to add additional custom links
 */
function rd_new_nav_menu_items($items) {
	
	if ( !is_user_logged_in() ) {
		$subscribe_link = '<li class="menu-item"><a href="#signup" class="signup">Subscribe</a></li>';
		$items = $items . $subscribe_link;
		$loginlink = '<li>&nbsp;</li><li class="menu-item"><a href="' . wp_login_url() . '">Login</a></li>';
		$items = $items . $loginlink;
	}
	if ( is_user_logged_in() ) {
		$my_account_link = '<li>&nbsp;</li><li class="menu-item"><a href="/account/">My Account</a></li>';
		$items = $items . $my_account_link;
		$logout_link = '<li class="menu-item"><a href="' . wp_logout_url() . '">Logout</a></li>';
		$items = $items . $logout_link;
	}
    return $items;
}
add_filter( 'wp_nav_menu_items', 'rd_new_nav_menu_items' );
endif;


if ( ! function_exists( 'rd_rss_filter_post_formats' ) ) :
/**
 * Filter post formats from RSS feed
 */
add_action( 'pre_get_posts', 'rd_rss_filter_post_formats' );
function rd_rss_filter_post_formats( &$wp_query )
{
    if ( $wp_query->is_feed() ) {
			if( isset($wp_query->query_vars['rss-post-format-aside']) ) { // Only return Asides
        $post_format_tax_query = array(
            'taxonomy' => 'post_format',
            'field' => 'slug',
            'terms' => 'post-format-aside',
            'operator' => 'IN'
        );
        $tax_query = $wp_query->get( 'tax_query' );
        if ( is_array( $tax_query ) ) {
            $tax_query = $tax_query + $post_format_tax_query;
        } else {
            $tax_query = array( $post_format_tax_query );
        }
        $wp_query->set( 'tax_query', $tax_query );
    }
		else if( isset($wp_query->query_vars['rss-post-format-image']) ) { // Only return Images
			
        $post_format_tax_query = array(
            'taxonomy' => 'post_format',
            'field' => 'slug',
            'terms' => 'post-format-image',
            'operator' => 'IN'
        );
        $tax_query = $wp_query->get( 'tax_query' );
        if ( is_array( $tax_query ) ) {
            $tax_query = $tax_query + $post_format_tax_query;
        } else {
            $tax_query = array( $post_format_tax_query );
        }
        $wp_query->set( 'tax_query', $tax_query );

    }
		else if ( isset($wp_query->query_vars['rss-post-format-standard']) ) { // 
		
      $post_format_tax_query = array(
          'taxonomy' => 'post_format',
          'field' => 'slug',
          'terms' => array('post-format-aside', 'post-format-image'),
          'operator' => 'NOT IN'
      );
      $tax_query = $wp_query->get( 'tax_query' );
      if ( is_array( $tax_query ) ) {
          $tax_query = $tax_query + $post_format_tax_query;
      } else {
          $tax_query = array( $post_format_tax_query );
      }
      $wp_query->set( 'tax_query', $tax_query );			

		} // if( isset($wp_query->query_vars['rss-post-format-aside']) 
	} // if ( $wp_query->is_feed() )
} // function rd_rss_filter_post_formats()
endif;


if ( ! function_exists( 'rd_rss_filter_journal' ) ) :
/**
 * Filter journal entries from RSS feeds, except when using secret URL
 */
add_action( 'pre_get_posts', 'rd_rss_filter_journal' );
function rd_rss_filter_journal( &$wp_query ) {
    if ( $wp_query->is_feed() && !isset($wp_query->query_vars['rss-journal-kjadj831fsdj'])) {
      $wp_query->set( 'category__not_in', '921' );
		} else if ( $wp_query->is_feed() && isset($wp_query->query_vars['rss-journal-kjadj831fsdj']) ) {
			$wp_query->set( 'category__in', '921' );
		}
}
endif;


if ( ! function_exists( 'rd_add_query_vars' ) ) :
/**
 * Query vars used for filtering RSS feeds
 */
function rd_add_query_vars($aVars) {
	$aVars[] = "rss-post-format-aside";
	$aVars[] = "rss-post-format-image";
	$aVars[] = "rss-post-format-standard";
	$aVars[] = "rss-journal-kjadj831fsdj";
	return $aVars;
}
add_filter('query_vars', 'rd_add_query_vars');
endif;


if ( ! function_exists( 'rd_rss_change_title' ) ) :
/**
 * Changes the RSS feed title to rename specific post formats
 */
function rd_rss_change_title() {
		$title = get_wp_title_rss();
	if ( strpos( $title, "Aside") ) {
		$new_title = str_replace("Aside", "Thoughts", $title);
		echo $new_title;
	} else { 
		echo get_wp_title_rss(); 
	} 
}
endif;
add_filter('wp_title_rss', 'rd_rss_change_title', 1);


if ( ! function_exists( 'rd_journal_365_filter_where' ) ) :
/**
 * Create a filtering function for showing journal entries older than 365 days
 */
function rd_journal_365_filter_where( $where = '' ) {
	// posts older than 365 days
	$where .= " AND post_date < '" . date('Y-m-d', strtotime('-365 days')) . "'";
	return $where;
}
endif;


if ( ! function_exists( 'rd_get_public_journals' ) ) :
/**
 * List public journals (older than 365 days)
 */
function rd_get_public_journals( $number_posts = '10' ) {
	add_filter( 'posts_where', 'rd_journal_365_filter_where' );
		?>
		<ul>
		<?php
			$args = array( 'posts_per_page' => $number_posts, 'category_name' => 'Personal Reflections', 'post_status' => 'publish' );
			//$recent_posts = wp_get_recent_posts( $args );
			$recent_posts = new WP_Query( $args );
			if ( $recent_posts->have_posts() ) :
				while ( $recent_posts->have_posts() ) : $recent_posts->the_post();
					echo '<li><a href="' . get_permalink() . '" title="Look '. get_the_title() .'" >' . get_the_title().'</a> </li> ';
				endwhile;
			else :
				echo wpautop( 'Sorry, no posts were found' );
			endif;
		?>
		</ul>
	<?php
	wp_reset_postdata();
	remove_filter( 'posts_where', 'rd_journal_365_filter_where' );
}
endif;
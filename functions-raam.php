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
add_action( 'init', 'create_post_type_journalk09r4tyf58u35' );

function create_post_type_thoughts() {	
	register_post_type('thoughts', array(	'label' => 'Thoughts','description' => '','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => false,'rewrite' => array('slug' => ''),'query_var' => true,'has_archive' => true,'supports' => array('title','editor','trackbacks','comments','revisions','custom-fields',),'taxonomies' => array('post_tag',),'labels' => array (
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
	register_post_type('journal', array(	'label' => 'Journal','description' => '','public' => true,'show_ui' => true,'show_in_menu' => true,'capability_type' => 'post','hierarchical' => false,'rewrite' => array('slug' => ''),'query_var' => true,'has_archive' => true,'supports' => array('title','editor','trackbacks','comments','revisions','custom-fields',),'taxonomies' => array('post_tag',),'labels' => array (
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

/* Used to hack the post_type RSS feed and prevent public from viewing the Journal feed */
function create_post_type_journalk09r4tyf58u35() {
	register_post_type('journalk09r4tyf58u35', array(	'label' => 'Journal_k09r4tyf58u35','description' => '','public' => true,'show_ui' => true,'show_in_menu' => false,'capability_type' => 'post','hierarchical' => false,'rewrite' => array('slug' => ''),'query_var' => true,'has_archive' => true,'supports' => array('title','editor','trackbacks','comments','revisions','custom-fields',),'taxonomies' => array('post_tag',),'labels' => array (
	  'name' => 'Journalk09r4tyf58u35',
	  'singular_name' => 'Journal Entry_k09r4tyf58u35',
	  'menu_name' => 'Journal_k09r4tyf58u35',
	  'add_new' => 'Add Journal_k09r4tyf58u35',
	  'add_new_item' => 'Add New Journal_k09r4tyf58u35',
	  'edit' => 'Edit',
	  'edit_item' => 'Edit Journal_k09r4tyf58u35',
	  'new_item' => 'New Journal_k09r4tyf58u35',
	  'view' => 'View Journal_k09r4tyf58u35',
	  'view_item' => 'View Journal_k09r4tyf58u35',
	  'search_items' => 'Search Journal_k09r4tyf58u35',
	  'not_found' => 'No Journal Entries Found_k09r4tyf58u35',
	  'not_found_in_trash' => 'No Journal_k09r4tyf58u35 Entries Found in Trash',
	  'parent' => 'Parent Journal_k09r4tyf58u35 Entry',
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

	// Make sure post formats exist and build array of formats to exclude
	if( !empty( $exclude_formats ) ) :
		$i=0;
		$tax_query = array();
		foreach ( $exclude_formats as $format ) {

			$term = term_exists('post-format-' . $format, 'post_format');
			if ($term === 0 || $term === null) { return false; }

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

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
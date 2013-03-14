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

if ( ! function_exists( 'publish_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Publish 1.0
 */
function publish_posted_on() {
	$location = get_post_meta( get_the_ID(), 'ncl_current_location', true );
	
		if(trim($location) != "") 
			{ 
				$location_html = " from <span class=\"mapThis\" place=\"$location\" zoom=\"2\">$location</span>"; 
			}
			else {
				$location_html = "";
			}
	
	printf( __( 'Published <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a></span><span class="ncl-location">%5$s</span>', 'publish' ) . '.',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		$location_html
	);
}
endif;
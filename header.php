<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Publish
 * @since Publish 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '-', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/inc/jquery-pageslide/jquery.pageslide.css">
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php if ( !is_home() ) { // Hide the site title and site logo when not showing home page ?>
	<style type="text/css">.site-title, .site-logo { display: none; }</style>
<?php } ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		<?php if ( get_header_image() ) : ?>
			<a class="site-logo" href="/about/" title="About <?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="author">
				<img class="no-grav" src="<?php echo esc_url( get_header_image() ); ?>" height="<?php echo absint( get_custom_header()->height ); ?>" width="<?php echo absint( get_custom_header()->width ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
			</a>
		<?php endif; ?>
		<hgroup>
			<h1 class="site-title"><a href="/about/" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="author"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			<?php if ( function_exists('ncl_show_location') && is_home() ) : ?>
				<h2 class="site-description-location">Last seen <?php echo do_shortcode("[ncl-current-location display='date']"); ?> ago in <span class="mapThis" place="<?php echo do_shortcode("[ncl-current-location wikify='false']"); ?>" zoom="2"><?php echo do_shortcode("[ncl-current-location wikify='false']"); ?></span>.</h2>
			<?php endif; ?>
		</hgroup>

		<nav role="navigation" class="site-navigation main-navigation">
			<h1 class="assistive-text"><?php _e( 'Menu', 'publish' ); ?></h1>
			<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'publish' ); ?>"><?php _e( 'Skip to content', 'publish' ); ?></a></div>

			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'depth' => 1 ) ); ?>
		</nav><!-- .site-navigation .main-navigation -->

		<?php do_action( 'publish_header_after' ); ?>
	</header><!-- #masthead .site-header -->

	<div id="main" class="site-main">
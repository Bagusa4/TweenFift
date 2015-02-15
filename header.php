<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Tween_Fift
 * @since Tween Fift 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<script>(function(){document.documentElement.className='js'})();</script>
	<link rel="Shortcut Icon" href="<?php global $redux_tween_fift; $ico = $redux_tween_fift['favicon']['url']; ?><?php echo $ico; ?>" type="image/x-icon" />
	<!-- Css or Script JS From Framework ! DO NOT EDIT CODE IN BELOW ! -->
	<style>
	<?php global $redux_tween_fift; echo $redux_tween_fift [ 'opt-ace-editor-css' ] ?>
	</style>
	<script>
	<?php global $redux_tween_fift; echo $redux_tween_fift [ 'opt-ace-editor-js' ] ?>
	</script>
	<?php if ( is_attachment() || is_category() || is_home() || is_tag() ) { ?><?php } else { ?><style>.hentry {padding: 0 !important;}</style> <?php } ?>
	<!-- END Css or Script JS From Framework ! DO NOT EDIT CODE IN ABOVE ! -->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'tweenfift' ); ?></a>

<!-- Main Menu --><?php get_template_part( 'menu' ); ?>
<div id="site-all-main" class="site-all-main">
	<div id="sidebar" class="sidebar">
		<header id="masthead" class="site-header" role="banner">
			<div class="site-branding">
				<?php
					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif;

					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; ?></p>
					<?php endif;
				?>
				<button class="secondary-toggle"><?php _e( 'Menu and widgets', 'tweenfift' ); ?></button>
			</div><!-- .site-branding -->
		</header><!-- .site-header -->

		<?php get_sidebar(); ?>
	</div><!-- .sidebar -->

	<div id="content" class="site-content">
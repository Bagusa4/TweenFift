<?php
/**
 * Tween Fift functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Tween_Fift
 * @since Tween Fift 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Tween Fift 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

/**
 * Tween Fift only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'tweenfift_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Tween Fift 1.0
 */
function tweenfift_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on tweenfift, use a find and replace
	 * to change 'tweenfift' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'tweenfift', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );
	
	/*
	 * Change Image Link In Wordpress to Attachments Page.
	 *
	 * See: http://www.wpbeginner.com/wp-tutorials/automatically-remove-default-image-links-wordpress/
	 */
	function wpb_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	
	if ($image_set !== 'post') {
		update_option('image_default_link_type', 'post');
	} 
	}
	add_action('admin_init', 'wpb_imagelink_setup', 10);
	
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'tweenfift' ),
		'social'  => __( 'Social Links Menu', 'tweenfift' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = tweenfift_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'tweenfift_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', tweenfift_fonts_url() ) );
}
endif; // tweenfift_setup
add_action( 'after_setup_theme', 'tweenfift_setup' );


/**
 * START Framework Options
 * Please Do not Change Anything Under this Code. If You Do not Want Experiencing Problems. !!!	
**/
// Remove Demo or Developer Mode
/**
     * The Redux Framework Disable dev_mode Plugin
     * A simple, truly extensible and fully responsive options framework
     * for WordPress themes and plugins. Developed with WordPress coding
     * standards and PHP best practices in mind.
     * Plugin Name:     Redux Developer Mode Disabler
     * Plugin URI:      http://wordpress.org/plugins/redux-developer-mode-disabler
     * Github URI:      https://github.com/ReduxFramework/redux-disable-devmode
     * Description:     A simple plugin to help the users of developers who ship a Redux based product with developer mode on. This plugin globally disables developer mode for all Redux instances.
     * Author:          Team Redux
     * Author URI:      http://reduxframework.com
     * Version:         1.0.0
     * Text Domain:     redux-framework
     * License:         GPL3+
     * License URI:     http://www.gnu.org/licenses/gpl-3.0.txt
     * Domain Path:     /ReduxFramework/ReduxCore/languages
     *
     * @package         ReduxFramework
     * @author          Dovy Paukstys <dovy@reduxframework.com>
     * @license         GNU General Public License, version 3
     * @copyright       2012-2014 Redux Framework
     */
    if ( ! function_exists( 'redux_disable_dev_mode_plugin' ) ) {
        function redux_disable_dev_mode_plugin( $redux ) {
            if ( $redux->args['opt_name'] != 'redux_demo' ) {
				if ( $redux->args['dev_mode'] == true ) {
					$redux->args['dev_mode'] = false;
				}
            } else {
				if ( $redux->args['dev_mode'] == false ) {
					$redux->args['dev_mode'] = true;
				}
			}
        }
        add_action( 'redux/construct', 'redux_disable_dev_mode_plugin' );
    }

// Remove Demo Mode
function removeDemoModeLink() { // Be sure to rename this function to something more unique
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
    }
}
add_action('init', 'removeDemoModeLink');
// END Remove Demo or Developer Mode 

// Include the Redux theme options Framework
if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/inc/framework/ReduxCore/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/inc/framework/ReduxCore/framework.php' );
}

// Tweak the Redux Framework
// Register all the theme Options
if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/inc/framework/framework-config.php' ) ) {
    require_once( dirname( __FILE__ ) . '/inc/framework/framework-config.php' );
}
/**
 * END Framework Options	
**/


/**
 * Register widget area.
 *
 * @since Tween Fift 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function tweenfift_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'tweenfift' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'tweenfift' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'tweenfift_widgets_init' );

if ( ! function_exists( 'tweenfift_fonts_url' ) ) :
/**
 * Register Google fonts for Tween Fift.
 *
 * @since Tween Fift 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function tweenfift_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Noto Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'tweenfift' ) ) {
		$fonts[] = 'Noto Sans:400italic,700italic,400,700';
	}

	/* translators: If there are characters in your language that are not supported by Noto Serif, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'tweenfift' ) ) {
		$fonts[] = 'Noto Serif:400italic,700italic,400,700';
	}

	/* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'tweenfift' ) ) {
		$fonts[] = 'Inconsolata:400,700';
	}

	/* translators: To add an additional character subset specific to your language, translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language. */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'tweenfift' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Enqueue scripts and styles.
 *
 * @since Tween Fift 1.0
 */
function tweenfift_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'tweenfift-fonts', tweenfift_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'tweenfift-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'tweenfift-ie', get_template_directory_uri() . '/css/ie.css', array( 'tweenfift-style' ), '20141010' );
	wp_style_add_data( 'tweenfift-ie', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'tweenfift-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'tweenfift-style' ), '20141010' );
	wp_style_add_data( 'tweenfift-ie7', 'conditional', 'lt IE 8' );

	wp_enqueue_script( 'tweenfift-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'tweenfift-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

	wp_enqueue_script( 'tweenfift-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20141212', true );
	wp_localize_script( 'tweenfift-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'tweenfift' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'tweenfift' ) . '</span>',
	) );
}
add_action( 'wp_enqueue_scripts', 'tweenfift_scripts' );

/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Tween Fift 1.0
 *
 * @see wp_add_inline_style()
 */
function tweenfift_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';

	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}

	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	if ( $next && has_post_thumbnail( $next->ID ) ) {
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	wp_add_inline_style( 'tweenfift-style', $css );
}
add_action( 'wp_enqueue_scripts', 'tweenfift_post_nav_background' );

/**
 * Display descriptions in main navigation.
 *
 * @since Tween Fift 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function tweenfift_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'tweenfift_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Tween Fift 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function tweenfift_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'tweenfift_search_form_modify' );

/**
 * Implement the Custom Header feature.
 *
 * @since Tween Fift 1.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Tween Fift 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Tween Fift 1.0
 */
require get_template_directory() . '/inc/customizer.php';

/**
 *
 * Tools Accessories
 *
 */
define( 'BASE_DIR', TEMPLATEPATH . '/' ); 
include( BASE_DIR . 'inc/tools/tools.php' );
 
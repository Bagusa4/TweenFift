<?php 
function tweenfift_breadcrumbs() {
	$args = array(
		'home_title' 		=> 'Home',
		'front_page' 		=> false,
		'show_blog' 		=> false,
		'singular_post_taxonomy'=> 'category',
		'echo' 			=> true
	);
	$items = tweenfift_get_items( $args );
	$breadcrumbs = '';
	$breadcrumbs .= '<div class="breadcrumbs"><div xmlns:v="http://rdf.data-vocabulary.org/#">';
	$breadcrumbs .= join( " &raquo; ", $items );
	$breadcrumbs .= '</div></div>';
	$breadcrumbs = apply_filters( 'tweenfift', $breadcrumbs );
		echo $breadcrumbs;
}

function tweenfift_get_items( $args ) {
	global $wp_query;

	$item = array();
	if ( !is_front_page() )
		$item[] = '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="'. home_url( '/' ) .'">' . $args['home_title'] . '</a></span>';

	if ( is_home() ) {
		$item[] = '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="'. home_url( '/' ) .'">' . $args['home_title'] . '</a></span>';
	}

	elseif ( is_singular() ) {

		$post = $wp_query->get_queried_object();
		$post_id = (int) $wp_query->get_queried_object_id();
		$post_type = $post->post_type;

		$post_type_object = get_post_type_object( $post_type );

		if ( 'post' === $wp_query->post->post_type && $args['show_blog'] ) {
			$item[] = '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . get_the_title( get_option( 'page_for_posts' ) ) . '</a></span>';
		}

		if ( 'page' !== $wp_query->post->post_type ) {

			if ( function_exists( 'get_post_type_archive_link' ) && !empty( $post_type_object->has_archive ) )
				$item[] = '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_post_type_archive_link( $post_type ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . $post_type_object->labels->name . '</a></span>';

			if ( isset( $args["singular_{$wp_query->post->post_type}_taxonomy"] ) && is_taxonomy_hierarchical( $args["singular_{$wp_query->post->post_type}_taxonomy"] ) ) {
				$terms = wp_get_object_terms( $post_id, $args["singular_{$wp_query->post->post_type}_taxonomy"] );
				$item = array_merge( $item, tweenfift_get_term_parents( $terms[0], $args["singular_{$wp_query->post->post_type}_taxonomy"] ) );
			}
			elseif ( isset( $args["singular_{$wp_query->post->post_type}_taxonomy"] ) )
				$item[] = get_the_term_list( $post_id, $args["singular_{$wp_query->post->post_type}_taxonomy"], '', ', ', '' );
		}

		if ( ( is_post_type_hierarchical( $wp_query->post->post_type ) || 'attachment' === $wp_query->post->post_type ) && $parents = tweenfift_get_parents( $wp_query->post->post_parent ) ) {
			$item = array_merge( $item, $parents );
		}

		$item['last'] = get_the_title();
	}
	else if ( is_archive() ) {

		if ( is_category() || is_tag() || is_tax() ) {

			$term = $wp_query->get_queried_object();
			$taxonomy = get_taxonomy( $term->taxonomy );

			if ( ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent ) && $parents = tweenfift_get_term_parents( $term->parent, $term->taxonomy ) )
				$item = array_merge( $item, $parents );

			$item['last'] = $term->name;
		}

		else if ( function_exists( 'is_post_type_archive' ) && is_post_type_archive() ) {
			$post_type_object = get_post_type_object( get_query_var( 'post_type' ) );
			$item['last'] = $post_type_object->labels->name;
		}

		else if ( is_date() ) {

			if ( is_day() )
				$item['last'] = 'Archives for '. get_the_time( 'F j, Y' );

			elseif ( is_month() )
				$item['last'] = 'Archives for '. single_month_title( ' ', false );

			elseif ( is_year() )
				$item['last'] = 'Archives for '. get_the_time( 'Y' );
		}

		else if ( is_author() )
			$item['last'] = 'Archives by: '. get_the_author_meta( 'display_name', $wp_query->post->post_author );
	}
	else if ( is_search() )
		$item['last'] = 'Search results for "'. stripslashes( strip_tags( get_search_query() ) ) . '"';

	return apply_filters( 'tweenfift_items', $item );
}
function tweenfift_get_parents( $post_id = '', $separator = '/' ) {
	$parents = array();
	if ( $post_id == 0 )
		return $parents;
	while ( $post_id ) {
		$page = get_page( $post_id );
		$parents[]  = '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . get_the_title( $post_id ) . '</a></span>';
		$post_id = $page->post_parent;
	}
	if ( $parents )
		$parents = array_reverse( $parents );
	return $parents;
}
function tweenfift_get_term_parents( $parent_id = '', $taxonomy = '', $separator = '/' ) {
	$html = array();
	$parents = array();
	if ( empty( $parent_id ) || empty( $taxonomy ) )
		return $parents;
	while ( $parent_id ) {
		$parent = get_term( $parent_id, $taxonomy );
		$parents[] = '<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_term_link( $parent, $taxonomy ) . '" title="' . esc_attr( $parent->name ) . '">' . $parent->name . '</a></span>';
		$parent_id = $parent->parent;
	}
	if ( $parents )
		$parents = array_reverse( $parents );
	return $parents;
}

/**
 *
 * Infinite Scroll By Qassim Hassan
 *
 * https://wordpress.org/plugins/infinite-scroll-to-twenty-fifteen/screenshots/
 */
global $redux_tween_fift; $infinitescroll_switch = $redux_tween_fift['switch-infinite-scroll']; if(($infinitescroll_switch == '1')) {
include get_template_directory() . '/inc/tools/infinite-scroll-to-twenty-fifteen.php';
}

/**
 *
 * Images Accessories
 *
 */
include get_template_directory() . '/inc/tools/imgacc.php';

/**
 *
 * To require and recommend plugins
 *
 */
require_once dirname( __FILE__ ) . '/TGM-Plugin-Activation-master/tgmfunction.php';
?>
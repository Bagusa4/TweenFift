<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Tween_Fift
 * @since Tween Fift 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		// Post thumbnail.
		tweenfift_post_thumbnail();
	?>

	<?php if ( is_home() || is_archive() || is_category() ) {
	} else {
		global $redux_tween_fift; $tfbd_switch1 = $redux_tween_fift['switch-breadcrumbs']; if(($tfbd_switch1 == '1')) {
 			tweenfift_breadcrumbs(); 
		}
	} ?>

	<header class="entry-header">
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			endif;
		?>
	</header><!-- .entry-header -->
	
	<!-- ADS 2 -->
		<?php if ( is_home() || is_archive() || is_category() ) { 
		} else { ?>
		<?php global $redux_tween_fift; $ads2 = $redux_tween_fift['ads-2']; if(($ads2 == '')) {
		} else { ?>
				<?php global $redux_tween_fift; $ads_switch2 = $redux_tween_fift['switch-ads-2']; if(($ads_switch2 == '1')) { ?>
				<div class="ads-p">
				<h3 class="title"><span>Advertisement</span></h3>
				<div class="widget_ads">
				<?php global $redux_tween_fift; echo $redux_tween_fift['ads-2']; ?>
				</div>
				</div>
				<?php } else { } ?>
		<?php } ?>
		<?php } ?>

	<div class="entry-content">
		<?php if ( is_home() || is_archive() || is_category() ) {
			/* translators: %s: Name of current post */
			the_excerpt( sprintf(
				__( 'Continue reading %s', 'tweenfift' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'tweenfift' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'tweenfift' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
			} else {
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s', 'tweenfift' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'tweenfift' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'tweenfift' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		} ?>
	</div><!-- .entry-content -->

	<!-- ADS 3 -->
	<?php if ( is_home() || is_archive() || is_category() ) { 
	} else { ?>
	<?php global $redux_tween_fift; $ads3 = $redux_tween_fift['ads-3']; if(($ads3 == '')) {
	} else { ?>
			<?php global $redux_tween_fift; $ads_switch3 = $redux_tween_fift['switch-ads-3']; if(($ads_switch3 == '1')) { ?>
			<div class="ads-p">
			<h3 class="title"><span>Advertisement</span></h3>
			<div class="widget_ads">
			<?php global $redux_tween_fift; echo $redux_tween_fift['ads-3']; ?>
			</div>
			</div>
			<?php } else { } ?>
	<?php } ?>
	<?php } ?>
	
	<?php
		// Author bio.
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
		endif;
	?>

	<footer class="entry-footer">
		<?php tweenfift_entry_meta(); ?>
		<?php edit_post_link( __( 'Edit', 'tweenfift' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->


<!-- Image Accessories -->
<?php if ( is_single() || is_page() || is_404() || is_attachment() ) { 
     get_template_part( 'imgaccc' );
} ?>
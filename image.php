<?php
/**
 * The template for displaying image attachments
 *
 * @package WordPress
 * @subpackage Tween_Fift
 * @since Tween Fift 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<?php get_template_part( 'marqueetags' ); ?>
		<main id="main" class="site-main" role="main">

			<?php
				// Start the loop.
				while ( have_posts() ) : the_post();
			?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<header class="entry-header header-imgattachments">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header><!-- .entry-header -->

					<div class="breadcrumbs-imgattachments">
					<?php if ( is_home() || is_archive() || is_category() ) {
					} else {
						global $redux_tween_fift; $tfbd_switch1 = $redux_tween_fift['switch-breadcrumbs']; if(($tfbd_switch1 == '1')) {
 						tweenfift_breadcrumbs(); 
					}
					} ?>
					</div>

					<!-- ADS 2 -->
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
					
					<div class="entry-content entry-attachments">

						<?php global $redux_tween_fift; $spfirst_switch = $redux_tween_fift['switch-first-spinner']; if(($spfirst_switch == '1')) { ?><?php include (TEMPLATEPATH . '/inc/tools/randompage.php'); ?><?php } ?>
					
						<div class="entry-attachment">
							<?php
								/**
								 * Filter the default Tween Fift image attachment size.
								 *
								 * @since Tween Fift 1.0
								 *
								 * @param string $image_size Image size. Default 'large'.
								 */
								$image_size = apply_filters( 'tweenfift_attachment_size', 'post-thumbnails' );

								echo wp_get_attachment_image( get_the_ID(), $image_size );
							?>

							<?php if ( has_excerpt() ) : ?>
								<div class="entry-caption">
									<?php the_excerpt(); ?>
								</div><!-- .entry-caption -->
							<?php endif; ?>

						</div><!-- .entry-attachment -->

						<?php global $redux_tween_fift; $spsecond_switch = $redux_tween_fift['switch-second-spinner']; if(($spsecond_switch == '1')) { ?><?php include (TEMPLATEPATH . '/inc/tools/random.php'); ?><?php } ?>
						
						<?php
							the_content();
							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'tweenfift' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
								'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'tweenfift' ) . ' </span>%',
								'separator'   => '<span class="screen-reader-text">, </span>',
							) );
						?>
					</div><!-- .entry-content -->
						
					<!-- ADS 3 -->
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
					
					<nav id="image-navigation" class="navigation image-navigation">
						<div class="nav-links">
							<div class="nav-previous"><?php previous_image_link( false, __( 'Previous Image', 'tweenfift' ) ); ?></div><div class="nav-next"><?php next_image_link( false, __( 'Next Image', 'tweenfift' ) ); ?></div>
						</div><!-- .nav-links -->
					</nav><!-- .image-navigation -->
					
					<footer class="entry-footer">
						<?php tweenfift_entry_meta(); ?>
						<?php edit_post_link( __( 'Edit', 'tweenfift' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-footer -->

				</article><!-- #post-## -->
				
				<!-- Image Accessories -->
				<?php if ( is_single() || is_page() || is_404() || is_attachment() ) { 
						get_template_part( 'imgaccc' );
				} ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

					// Previous/next post navigation.
					the_post_navigation( array(
						'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'tweenfift' ),
					) );

				// End the loop.
				endwhile;
			?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Tween_Fift
 * @since Tween Fift 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
                <?php get_template_part( 'marqueetags' ); ?>
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'content', get_post_format() );

			// End the loop.
			//Show Anything After 2 Post
            if( $wp_query->current_post == 1 ) { ?>
				<!-- ADS 1 -->
				<?php global $redux_tween_fift; $ads1 = $redux_tween_fift['ads-1']; if(($ads1 == '')) {
				} else { ?>
						<?php global $redux_tween_fift; $ads_switch1 = $redux_tween_fift['switch-ads-1']; if(($ads_switch1 == '1')) { ?>
						<div class="ads">
						<h3 class="title"><span>Advertisement</span></h3>
						<div class="widget_ads">
						<?php global $redux_tween_fift; echo $redux_tween_fift['ads-1']; ?>
						</div>
						</div>
						<?php } else { } ?>
				<?php } ?>
            <?php }
			//Show Anything After 2 Post END
			//Show Anything After 4 Post
            if( $wp_query->current_post == 3 ) { ?>
				<!-- ADS 5 -->
				<?php global $redux_tween_fift; $ads5 = $redux_tween_fift['ads-5']; if(($ads5 == '')) {
				} else { ?>
						<?php global $redux_tween_fift; $ads_switch5 = $redux_tween_fift['switch-ads-5']; if(($ads_switch5 == '1')) { ?>
						<div class="ads">
						<h3 class="title"><span>Advertisement</span></h3>
						<div class="widget_ads">
						<?php global $redux_tween_fift; echo $redux_tween_fift['ads-5']; ?>
						</div>
						</div>
						<?php } else { } ?>
				<?php } ?>
			<?php }
			//Show Anything After 2 Post END
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'tweenfift' ),
				'next_text'          => __( 'Next page', 'tweenfift' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'tweenfift' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
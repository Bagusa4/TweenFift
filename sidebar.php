<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Tween_Fift
 * @since Tween Fift 1.0
 */

if ( has_nav_menu( 'primary' ) || has_nav_menu( 'social' ) || is_active_sidebar( 'sidebar-1' )  ) : ?>
	<div id="secondary" class="secondary">

<!-- Default Menu -->

		<?php if ( has_nav_menu( 'social' ) ) : ?>
			<nav id="social-navigation" class="social-navigation" role="navigation">
				<?php
					// Social links navigation menu.
					wp_nav_menu( array(
						'theme_location' => 'social',
						'depth'          => 1,
						'link_before'    => '<span class="screen-reader-text">',
						'link_after'     => '</span>',
					) );
				?>
			</nav><!-- .social-navigation -->
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
			<div id="widget-area" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</div><!-- .widget-area -->
		<?php endif; ?>
		
		<!-- Recent Gallery Sidebar -->
		<?php global $redux_tween_fift; $rg_switch1 = $redux_tween_fift['switch-gallery-sidebar']; if(($rg_switch1 == '1')) { ?>
		<aside class="widget-rg">
		<h2>Gallery</h2>
		<div id="recent-postimg">
		<div id="recent-post2">
		<?php 
		$recent_posts = get_posts('numberposts=4&orderby=date');//angka 6 = jumlah postingan yang mau ditampilkan
		foreach( $recent_posts as $post ) :
		setup_postdata($post);
		?>
		<div class="recent-post1-thumb">
		<?php sidebarimg(); ?>
		</div>
		<?php endforeach; ?>
		</div></div>
		</aside>
		<?php } else { } ?>
		<div style="clear: both"></div>

	</div><!-- .secondary -->

<?php endif; ?>
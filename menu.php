<?php
/*
Template Name: Menu
*/
?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<ul>
				    <li>
					<a href="<?php echo home_url() ; ?>">Home</a>
				    </li>
				</ul>
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<?php
					// Primary navigation menu.
					wp_nav_menu( array(
						'menu_class'     => 'nav-menu',
						'theme_location' => 'primary',
					) );
				?>
		<?php endif; ?>
			</nav><!-- .main-navigation -->
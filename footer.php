<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Tween_Fift
 * @since Tween Fift 1.0
 */
?>

	</div><!-- .site-content -->
	</div><!-- .site-all-main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php
				/**
				 * Fires before the Tween Fift footer text for footer customization.
				 *
				 * @since Tween Fift 1.0
				 */
				do_action( 'tweenfift_credits' );
			?>
			<!--<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'tweenfift' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'tweenfift' ), 'WordPress' ); ?></a>--><?php global $redux_tween_fift; echo $redux_tween_fift['opt-editor-footer']; ?>
		</div><!-- .site-info -->
	</footer><!-- .site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
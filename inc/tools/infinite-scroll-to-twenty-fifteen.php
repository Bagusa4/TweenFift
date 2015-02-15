<?php
/*
Plugin Name: Infinite Scroll To Twenty Fifteen
Plugin URI: http://qass.im/my-plugins/
Description: One click add Infinite Scroll to Twenty Fifteen theme with animation effect.
Version: 1.0.1
Author: Qassim Hassan
Author URI: http://qass.im
License: GPLv2 or later
*/

/*  Copyright 2014  Qassim Hassan  (email : qassim.pay@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/*
// Add infinite scroll text messages field to reading page
function infinite_scroll_text_messages_field(){
	add_settings_section('infinite_scroll_section', 'Infinite Scroll Text Messages', 'text__messages__section', 'reading');
	
	add_settings_field( "load_text", "Loading Text Message", "load_text_callback_function", "reading", "infinite_scroll_section" );
	register_setting( 'reading', 'load_text' );
	
	add_settings_field( "done_text", "Finished Text Message", "done_text_callback_function", "reading", "infinite_scroll_section" );
	register_setting( 'reading', 'done_text' );
}
add_action( 'admin_init', 'infinite_scroll_text_messages_field' );

function text__messages__section(){
	echo '<p>This fields to change text messages.</p>';
}

function load_text_callback_function(){
	if (get_option( 'load_text' )){
		$msgText = get_option( 'load_text' );
	}else{
		$msgText = 'Loading posts ...';
	}
	?>
    <input name="load_text" type="text" value="<?php echo $msgText; ?>">
    <?php
}

function done_text_callback_function(){
	if (get_option( 'done_text' )){
		$finishedMsg = get_option( 'done_text' );
	}else{
		$finishedMsg = 'No more posts!';
	}
	?>
    <input name="done_text" type="text" value="<?php echo $finishedMsg; ?>">
    <?php
}
*/

// Include javascript
function add__javascript__to__twenty__fifteen() {
	wp_enqueue_script( 'infinite-scroll-js', get_template_directory_uri() . '/js/jquery.infinitescroll.min.js', array('jquery'), null, false); // infinite scroll
	wp_enqueue_script( 'wow-js', get_template_directory_uri() . '/js/wow.js', array('jquery'), null, false); // wow animation
}
add_action('wp_enqueue_scripts', 'add__javascript__to__twenty__fifteen');


// Add infinite scroll to Twenty Fifteen theme
function twenty__fifteen__infinite__scroll() {
	global $redux_tween_fift;

	if( !is_single() and !is_page() and !is_attachment() ){
		
	if ($redux_tween_fift['opt-load-text-message']){
		$msgText = $redux_tween_fift['opt-load-text-message'];
	}else{
		$msgText = 'Loading posts ...'; // default message is Loading posts ...
	}
	
	if ($redux_tween_fift['opt-done-text-message']){
		$finishedMsg = $redux_tween_fift['opt-done-text-message'];
	}else{
		$finishedMsg = 'No more posts!'; // default message is No more posts!
	}
	
	$loading = '<div class="lpa"> <div class="lpheader lpanimate"></div> <div class="lpb"> <div class="lpc lpanimate"> <div class="lpabc-1"></div> <div class="lpabc-2"></div> <div class="lpabc-3"></div> <div class="lpabc-4"></div> <div class="lpabc-5"></div> <div class="lpabc-6"></div> <div class="lpabc-7"></div> <div class="lpabc-8"></div> <div class="lpabc-9"></div> <div class="lpabc-10"></div> <div class="lpabc-11"></div> <div class="lpabc-12"></div> </div> </div> <div class="lpfooter"> <div class="lpabcf lpanimate"> <p class="tlpabcf">'.$msgText.'</p> </div> </div> </div>'; //<p style="text-align:center;margin-top:8.3333%;">'.$msgText.'</p>
	
	$done = '<div class="lpa"> <div class="lpheader lpanimate"></div> <div class="lpb"> <div class="lpc lpanimate"> <div class="lpabc-1"></div> <div class="lpabc-2"></div> <div class="lpabc-3"></div> <div class="lpabc-4"></div> <div class="lpabc-5"></div> <div class="lpabc-6"></div> <div class="lpabc-7"></div> <div class="lpabc-8"></div> <div class="lpabc-9"></div> <div class="lpabc-10"></div> <div class="lpabc-11"></div> <div class="lpabc-12"></div> </div> </div> <div class="lpfooter"> <div class="lpabcf lpanimate"> <p class="tlpabcf">'.$finishedMsg.'</p> </div> </div> </div>'; //<p style="text-align:center;margin-top:8.3333%;">'.$finishedMsg.'</p>
	?>
    
    <div id="infinite-scroll-twenty-fifteen">
		<?php next_posts_link('Next page'); ?>
	</div>
    
		<script type="text/javascript">
			jQuery(document).ready(function() {
  				jQuery('#main').infinitescroll({
    				navSelector  : "div#infinite-scroll-twenty-fifteen",  // selector for the paged navigation (it will be hidden)
    				nextSelector : "div#infinite-scroll-twenty-fifteen a:first",  // selector for the NEXT link (to page number 2)
    				itemSelector : "#main article.hentry",  // selector for all items you'll retrieve
					debug        : false,  // disable debug messaging ( to console.log )
					loading: {
						img   		 : "", // loading image
						msgText  	 : '<?php echo $loading; ?>',  // loading message
						finishedMsg  : '<?php echo $done; ?>' // finished message
					},
					animate    : false, // if the page will do an animated scroll when new content loads
					dataType   : 'html'  // data type is html
  				});
				new WOW().init(); // activate wow animation
				jQuery('nav.navigation').remove(); // remove navigation
			});
		</script>
        <style type="text/css">
			div#infinite-scroll-twenty-fifteen, nav.navigation, #infscr-loading img{
				display:none !important;
			}
			
			article.hentry:first-child{
				animation-name:none !important;
				-webkit-animation-name:none !important;
			}
			
			.animated{
  				-webkit-animation-duration: 1s;
 	 			animation-duration: 1s;
  				-webkit-animation-fill-mode: both;
  				animation-fill-mode: both;
			}

			.fadeInUp{
  				-webkit-animation-name: fadeInUp;
  				animation-name: fadeInUp;
			}

			@-webkit-keyframes fadeInUp {
  				0%{
					opacity: 0;
    				-webkit-transform: translateY(20px);
    				transform: translateY(20px);
  				}

  				100%{
    				opacity: 1;
    				-webkit-transform: translateY(0);
    				transform: translateY(0);
  				}
			}
			
			@keyframes fadeInUp {
  				0%{
    				opacity: 0;
    				-webkit-transform: translateY(20px);
    				-ms-transform: translateY(20px);
    				transform: translateY(20px);
  				}

  				100%{
    				opacity: 1;
    				-webkit-transform: translateY(0);
    				-ms-transform: translateY(0);
    				transform: translateY(0);
  				}
			}
			
			/* CSS By Bagusa4 */
			@-webkit-keyframes placeHolderShimmer {
				0% {
					background-position: -468px 0;
				}

				100% {
					background-position: 468px 0;
				}
			}

			.lpa {
				background: #fff;
				border: 1px solid;
				border-color: #e9eaed #dfe0e4 #d0d1d5;
				-webkit-border-radius: 3px;
				margin: 78px 78px;
			}

			.lpb {
				display: block;
				padding: 12px;
				text-align: center;
				height: 200px;
			}

			.lpanimate {
				-webkit-animation-duration: 1s;
				-webkit-animation-fill-mode: forwards;
				-webkit-animation-iteration-count: infinite;
				-webkit-animation-name: placeHolderShimmer;
				-webkit-animation-timing-function: linear;
				background: #f6f7f8;
				background-image: -webkit-gradient(linear, left center, right center, from(#f6f7f8), color-stop(.2, #edeef1), color-stop(.4, #f6f7f8), to(#f6f7f8));
				background-image: -webkit-linear-gradient(left, #f6f7f8 0%, #edeef1 20%, #f6f7f8 40%, #f6f7f8 100%);
			}

			.lpc {
				background-repeat: no-repeat;
				background-size: 800px 104px;
				height: 104px;
				position: relative;
			}

			.lpheader {
				background-color: #f7f7f7;
				padding: 2% 0 10%;
				text-align: center;
			}

			.lpfooter {
				background-color: #f7f7f7;
				padding: 2% 0 2%;
				text-align: center;
			}

			.lpfooter p {
				margin: 0;
			}

			.lpc div {
				background: #fff;
				height: 6px;
				left: 0;
				position: absolute;
				right: 0;
			}

			div.lpabc-1 {
				height: 40px;
				left: 40px;
				right: auto;
				top: 0;
				width: 8px;
			}

			div.lpabc-2 {
				height: 8px;
				left: 48px;
				top: 0;
			}

			div.lpabc-3 {
				left: 136px;
				top: 8px;
			}

			div.lpabc-4 {
				height: 12px;
				left: 48px;
				top: 14px;
			}

			div.lpabc-5 {
				left: 100px;
				top: 26px;
			}

			div.lpabc-6 {
				height: 10px;
				left: 48px;
				top: 32px;
			}

			div.lpabc-7 {
				height: 20px;
				top: 40px;
			}

			div.lpabc-8 {
				left: 410px;
				top: 60px;
			}

			div.lpabc-9 {
				height: 13px;
				top: 66px;
			}

			div.lpabc-10 {
				left: 440px;
				top: 79px;
			}

			div.lpabc-11 {
				height: 13px;
				top: 85px;
			}

			div.lpabc-12 {
				left: 178px;
				top: 98px;
			}

			div.lpabcf {
			}

			div.tlpabc {
				left: 440px;
				top: 79px;
			}
		</style>
	<?php
	}
}
add_action( 'wp_footer', 'twenty__fifteen__infinite__scroll', 100 );


// Add "wow" and "fadeInDown" classes to post classes
function add__animation__classes($classes){
	if ( !is_single() and !is_page() ){
		$classes[] = 'wow fadeInUp';
	}
	return $classes;
}
add_filter( 'post_class', 'add__animation__classes' );

?>
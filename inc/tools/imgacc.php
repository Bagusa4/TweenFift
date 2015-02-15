<?php
/*
Template Name: Image Accessories Function
*/
?>
<?php

/*---------------CUSTOM IMG SINGLE ----------*/
function gallerysingle($args = array())
{
	
	$get_posts_args = array(
	"post_parent"    => get_the_ID(),
	"what_to_show"=>"posts",

	"post_type"=>"attachment",
	"orderby"=>"RAND",
	"order"=>"RAND",
	"showposts"=>20,
	"post_mime_type"=>"image/jpeg,image/jpg,image/gif,image/png");
	$posts = get_posts($get_posts_args);
	foreach ($posts as $post)
	{
		$parent = get_post($post->post_parent);
		if(($imgsrc = wp_get_attachment_image($post->ID,'singleimgattachment')) 
				&& ($imglink= get_attachment_link($post->ID))
				&& $parent->post_status == "publish")
		{
			echo  "<a href='" . $imglink . "'>".$imgsrc."</a>" ;
		}
	}
}
/*---------------END IMG SINGLE ----------*/

/*---------------CUSTOM IMG ATT ----------*/
function gb() {
	global $post;
	$pos = get_post($post);
	if ( $gb = get_children(array(
					'post_parent' => $pos->post_parent,
					'post_type' => 'attachment',
					'numberposts' => 50, 
					'post_mime_type' => 'image',)))
	{
		foreach( $gb as $gbr ) {
			$url=get_attachment_link($gbr->ID);
			$gambar=wp_get_attachment_image( $gbr->ID, 'singleimgattachment');
			echo '<a href="'.$url.'">'.$gambar.'</a>';
		}
	}
}
/*---------------END CUSTOM IMG ATT ----------*/

/*---------------CUSTOM IMG SIDEBAR ----------*/
function sidebarimg($args = array())
{
	
	$get_posts_args = array(
	"post_parent"    => get_the_ID(),
	"what_to_show"=>"posts",

	"post_type"=>"attachment",
	"orderby"=>"RAND",
	"order"=>"RAND",
	"showposts"=>1,
	"post_mime_type"=>"image/jpeg,image/jpg,image/gif,image/png");
	$nofollow = 'rel="nofollow"';
	$posts = get_posts($get_posts_args);
	foreach ($posts as $post)
	{
		$parent = get_post($post->post_parent);
		if(($imgsrc = wp_get_attachment_image($post->ID,'sidebarimgattachment')) 
				&& ($imglink= get_attachment_link($post->ID))
				&& $parent->post_status == "publish")
		{
			echo  "<a href='" . $imglink . "'>".$imgsrc."</a>" ;
			echo '</span>';
			echo '<em>';
			echo apply_filters( 'the_title' , $post->post_title );
			echo '</em>';
		}
	}
}
/*---------------end IMG SIDEBAR ----------*/

/*---------------CUSTOM IMG RELATED ----------*/
function relateds($args = array())
{
	
	$get_posts_args = array(
	"post_parent"    => get_the_ID(),
	"what_to_show"=>"posts",

	"post_type"=>"attachment",
	"orderby"=>"RAND",
	"order"=>"RAND",
	"showposts"=>1,
	"post_mime_type"=>"image/jpeg,image/jpg,image/gif,image/png");
	$posts = get_posts($get_posts_args);
	foreach ($posts as $post)
	{
		$parent = get_post($post->post_parent);
		if(($imgsrc = wp_get_attachment_image($post->ID, 'relatedimgattachment')) 
				&& ($imglink= get_attachment_link($post->ID))
				&& $parent->post_status == "publish")
		{
			echo  "<a href='" . $imglink . "'>".$imgsrc."</a>" ;
		}
	}
}
/*---------------END CUSTOM IMG RELATED ----------*/

/*---------------CUSTOM EXCERPTS ----------*/
function an_excerptlength_archive($length) {
    return 60;
}
function an_excerptlength_index($length) {
    return 70;
}
function an_excerptlength_related($length) {
    return 60;
}

function an_excerpt($length_callback='', $more_callback='') {
    global $post;
    if(function_exists($length_callback)){
        add_filter('excerpt_length', $length_callback);
    }
    if(function_exists($more_callback)){
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>'.$output.'</p>';
    echo $output;
}
/*------------------- END CUSTOM EXCERPTS ---------------------*/ 

/** JS SPIN -----------------------------------------------------
* Simple spinner
*/
/*function js_spin($s){
$s = str_replace(array('{','}'),'',$s);
$e = explode("|", $s);
$c = count($e);
$l = $c-1;
$i = mt_rand(0,$l);
$t = $e[$i];
return $t;
}*/
/* Simple Spinner by http://www.edcharkow.com/blog/spintax-easy-php-code/ */
function js_spin($s){
preg_match('#\{(.+?)\}#is',$s,$m);
if(empty($m)) return $s;

$t = $m[1];

if(strpos($t,'{')!==false){
$t = substr($t, strrpos($t,'{') + 1);
}

$parts = explode("|", $t);
$s = preg_replace("+\{".preg_quote($t)."\}+is", $parts[array_rand($parts)], $s, 1);

return js_spin($s);
}
/*--------------------------END JS SPIN ------------------------*/
?>
<?php //Image Options
//For Sidebar Image
add_image_size( 'sidebarimgattachment', 377, 200, true );
//For Related Image
add_image_size( 'relatedimgattachment', 180, 135, true );
//For Related Image
add_image_size( 'singleimgattachment', 120, 120, true );
//For Default Thumb Size
update_option( 'thumb_size_w', 150 );
update_option( 'thumb_size_h', 150 );
update_option( 'thumb_crop', 1 );
//For Default Thumbnail Size
update_option( 'thumbnail_size_w', 150 );
update_option( 'thumbnail_size_h', 150 );
update_option( 'thumbnail_crop', 1 );
//For Medium Size
update_option( 'medium_size_w', 300 );
update_option( 'medium_size_h', 300 );
update_option( 'medium_crop', 1 );
//For Large Size
update_option( 'large_size_w', 1024 );
update_option( 'large_size_h', 1024 );
update_option( 'large_crop', 1 );
//For Post Thumbnail
update_option( 'post-thumbnail_size_w', 825 );
update_option( 'post-thumbnail_size_h', 510 );
update_option( 'post-thumbnail_crop', 1 );
?>
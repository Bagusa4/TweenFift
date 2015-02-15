<?php
/*
Template Name: Image Accessories Caller
*/
?>

<!-- Gallery Single --> <!-- AND --> <!-- Gallery Single IMG Attachments -->
<?php global $redux_tween_fift; $rg_switch2 = $redux_tween_fift['switch-gallery-single']; if(($rg_switch2 == '1')) { ?>
<div id="gallerysingle">
<div id="gallerysingl"><h2><?php if ( !is_attachment() ) {
global $post;
$attachments = get_children( array( 'post_parent' => get_the_ID(), 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) );

$count = count( $attachments );
$specific = array();
$i = 1;

foreach ( $attachments as $attachment ) {
    $specific[$attachment->ID] = $i;
    ++$i;
}

echo "{$specific[$post->ID]} {$count}";

} ?> Photos of the <?php if ( !is_attachment() ) { the_title(); } else { printf( __( ' %2$s ', 'tetapsemangat' ), esc_url( get_permalink(
$post->post_parent ) ), get_the_title( $post->post_parent )); } ?></h2></div>

<div class="gambar1">
<?php if ( !is_attachment() ) { gallerysingle(); } else { gb(); }?>

</div>
</div>
<?php } else { } ?>

<!-- ADS 4 -->
<?php if ( is_single() || is_page() || is_404() || is_attachment() ) { ?>
<?php global $redux_tween_fift; $ads4 = $redux_tween_fift['ads-4']; if(($ads4 == '')) {
} else { ?>
		<?php global $redux_tween_fift; $ads_switch4 = $redux_tween_fift['switch-ads-4']; if(($ads_switch4 == '1')) { ?>
		<div class="ads">
		<h3 class="title"><span>Advertisement</span></h3>
		<div class="widget_ads">
		<?php global $redux_tween_fift; echo $redux_tween_fift['ads-4']; ?>
		</div>
		</div>
		<?php } else { } ?>
<?php } ?>
<?php } ?>

<!-- Related -->
<?php global $redux_tween_fift; $rg_switch3 = $redux_tween_fift['switch-related']; if(($rg_switch3 == '1')) { ?>
<div class="related">
<h3>Related Post from <?php
printf( __( ' %2$s ', 'tetapsemangat' ), esc_url( get_permalink(
$post->post_parent ) ), get_the_title( $post->post_parent ));
?></h3>


<?php 
$recent_posts = get_posts('numberposts=6&orderby=rand');//angka 6 = jumlah postingan yang mau ditampilkan
foreach( $recent_posts as $post ) :
setup_postdata($post);
?>
<ul class="related-cnt">
<div class="related-omg">
<div class="rltdleft">
 <?php relateds();?>
</div>
</div>

<div class="related-entry">
<li><a rel='nofollow' href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>

<div class="related-p">

<?php an_excerpt('an_excerptlength_related', ''); ?>
</div>


<div id="rpcatp">
<?php
foreach((get_the_category()) as $category) {
echo $category->cat_name . ' Category ';
}
?>

</div>
</div>
</ul>
<div style="clear: both"></div>
<?php endforeach; ?>
</div>
<?php } else { } ?>
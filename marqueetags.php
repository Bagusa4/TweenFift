<?php
/*
Template Name: Marquee Tags
*/
?>

<?php global $redux_tween_fift; $tm_switch1 = $redux_tween_fift['switch-tags-marquee']; if(($tm_switch1 == '1')) { ?>
<div class="marqueetag"><marquee direction="right" id="marquee" onMouseOver="this.setAttribute('scrollamount', 0, 0);" OnMouseOut="this.setAttribute('scrollamount', 6, 0);"><ul>
<?php
$posttags = get_tags();
$separator = ' ';
$output = '';
if ($posttags) {
  foreach($posttags as $tag) {
    $output .='<li><a href="'.get_tag_link($tag->term_id).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $tag->name ) ) . '">#'.$tag->name.'</a></li>'.$separator;
  }
echo trim($output, $separator);
} 
?>
</ul></marquee></div>
<?php } else { } ?>
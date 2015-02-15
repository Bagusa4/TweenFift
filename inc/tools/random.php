<?php
/**
 * Random Feature
**/
?>
<div style="margin:10px 0px 0px 0px;width:100%;float:left">

<?php
/*<?php
echo '<p> K1 '.$K2.' '.$K3.' K4 '.$tagname.'. K5 '.$K6.' '.$K7.' K8 '.$tagname.'. K9 '.$K10.' '.$atitle.' K11 '.$K12.' K13 '.$partitle.' K14 <a href="'.$postasli.'">K15</a>.
?>

Second Spinner Rule

Sentence 1, Sentence 2, Sentence 3, Sentence 4, Sentence Tags Name, Sentence 5, Sentence 6, Sentence 7, Sentence 8, Sentence Tags Name, Sentence 9, Sentence 10, Sentence Image Title, Sentence 11, Sentence 9, Sentence 12, Sentence 13, Sentence Post Name, Sentence 14, Link to Post.


Sentence Tags Name, Sentence Image Title, Sentence Post Name, and Link to Post. Cannot be change.
*/
/* KATA-KATA MUTIARA */
/*
- JUDUL PARENT
- JUDUL ATTACHMENT
- CATEGORY
- TANGGAL
- AUTHOR
- TOTAL GAMBAR
- TAGS

*/
$atitle		= $post->post_title;
$atitle		= str_replace(array('-','_','+'),' ',$atitle);
$atitle		= ucwords($atitle); //Upper Case Words

/*
ucfirst ();		// upper case first sentence
strtoupper();	// str to upper case
strtolower();	// str to lower case
*/

$parid 		= $post->post_parent;
$partitle 	= get_the_title($parid);
$cats		= get_the_category($parid);
$catname	= $cats[0]->name;

$date		= get_the_time('F jS, Y H:i:s A');
$author		= get_the_author();

$labelled	= '{labelled|tagged|marked}';
$labelspun	= js_spin($labelled);
$entitled	= '{entitled|with the title}';
$entitlespun = js_spin($entitled);
$read		= $getk12;
$readspun	= js_spin($read);

echo '<p style="text-align: justify;"><strong>'.

$partitle.' : '.$atitle.'</strong></p>';

?>


<?php
$parid    = $post->post_parent;
$par      = get_post($parid);
//Excerpt
$parkon = $par->post_content;
$parkon = apply_filters('the_content', $parkon);
$parkon = str_replace(']]>', ']]&gt;', $parkon);
$parkon = str_replace(array("\n","\r","\t"),'',$parkon); //minifikasi
$parkon = str_replace('</p><p>','</p>[(.Y.)]<p>',$parkon); //sisipkan pemisah
$xkon   = explode('[(.Y.)]',$parkon);
$lastp  = count($xkon)-1;
$rindex = mt_rand(0,$lastp);
$xcerpt= $xkon[$rindex];
echo '<blockquote style="text-align: justify;">'.$xcerpt.'</blockquote>';
?>


<?php
/* KATA-KATA MUTIARA */
/*
- JUDUL PARENT
- JUDUL ATTACHMENT
- CATEGORY
- TANGGAL
- AUTHOR
- TOTAL GAMBAR
- TAGS

*/
$atitle		= $post->post_title;
$atitle		= str_replace(array('-','_','+'),' ',$atitle);
$atitle		= ucwords($atitle); //Upper Case Words

/*
ucfirst ();		// upper case first sentence
strtoupper();	// str to upper case
strtolower();	// str to lower case
*/

$parid 		= $post->post_parent;
$partitle 	= get_the_title($parid);
$cats		= get_the_category($parid);
$catname	= $cats[0]->name;

$date		= get_the_time('F jS, Y H:i:s A');
$author		= get_the_author();

$labelled	= '{labelled|tagged|marked}';
$labelspun	= js_spin($labelled);
$entitled	= '{entitled|with the title}';
$entitlespun = js_spin($entitled);
$read		= $getk12;
$readspun	= js_spin($read);
$tags 		= get_the_tags($parid);

 if($tags) {

	$i = 1;

	$limit = 10;

	shuffle($tags);

	echo '';

	foreach($tags as $tag) {

		if($i > $limit) {

		  break;

		} else {

		$tagname = $tag->name;


		if($i == $limit) { $comma = '';} else { $comma = ',';}

		

		}

		$i++;
		}
	}


// Sentence Editor
global $redux_tween_fift; // Global Framework
$k1 = $redux_tween_fift['opt-editor-spsecond-1-sentence'];
$getk1 = js_spin($k1);
$k2 = $redux_tween_fift['opt-editor-spsecond-2-sentence'];
$getk2 = js_spin($k2);
$k3 = $redux_tween_fift['opt-editor-spsecond-3-sentence'];
$getk3 = js_spin($k3);
$k4 = $redux_tween_fift['opt-editor-spsecond-4-sentence'];
$getk4 = js_spin($k4);
$k5 = $redux_tween_fift['opt-editor-spsecond-5-sentence'];
$getk5 = js_spin($k5);
$k6 = $redux_tween_fift['opt-editor-spsecond-6-sentence'];
$getk6 = js_spin($k6);
$k7 = $redux_tween_fift['opt-editor-spsecond-7-sentence'];
$getk7 = js_spin($k7);
$k8 = $redux_tween_fift['opt-editor-spsecond-8-sentence'];
$getk8 = js_spin($k8);
$k9 = $redux_tween_fift['opt-editor-spsecond-9-sentence'];
$getk9 = js_spin($k9);
$k10 = $redux_tween_fift['opt-editor-spsecond-10-sentence'];
$getk10 = js_spin($k10);
$k11 = $redux_tween_fift['opt-editor-spsecond-11-sentence'];
$getk11 = js_spin($k11);
$k12 = $redux_tween_fift['opt-editor-spsecond-12-sentence'];
$getk12 = js_spin($k12);
$k13 = $redux_tween_fift['opt-editor-spsecond-13-sentence'];
$getk13 = js_spin($k13);
$k14 = $redux_tween_fift['opt-editor-spsecond-14-sentence'];
$getk14 = js_spin($k14);
$k15 = $redux_tween_fift['opt-editor-spsecond-15-sentence'];
$getk15 = js_spin($k15);


//SPUN MESSAGES

$pic = '{picture|image|photo|pic|photograph}';

$picspun = js_spin($pic);

$about = '{about|regarding|concerning|on the subject of}';

$aboutspun = js_spin($about);

$posted = '{published|posted|created|uploaded|released}';

$postspun = js_spin($posted);

$riteclick = '{right click|clicking the right mouse}';

$riteclickspun = js_spin($riteclick);

$essen = $getk2;

$essenspun = js_spin($essen);



$info = $getk3;

$infospun = js_spin($info);



$hires = '{hi-res|high-res|high resolution|high definition|large}';

$hirespun = js_spin($hires);



$best = $getk6;

$bestspun = js_spin($best);



$resour = $getk7;

$resourspun = js_spin($resour);



$find = $getk10;

$findspun = js_spin($find);


$get = '{get|obtain|gain|take|enlist}';

$getspun = js_spin($get);


$tanggal = get_the_time("l, F j, Y H:i a");

$author = get_the_author();



list($width, $height) = getimagesize( get_attached_file($post->ID) );



//tags, category: PR


$postasli = get_permalink($post->post_parent);


echo '<p style="text-align: justify;"> '.$getk1.' '.$essenspun.' '.$infospun.' '.$getk4.' '.$tagname.'. '.$getk5.' '.$bestspun.' '.$resourspun.' '.$getk8.' '.$tagname.'. '.$getk9.' '.$findspun.' '.$atitle.' '.$getk11.' '.$readspun.' '.$getk13.' '.$partitle.' '.$getk14.' <a href="'.$postasli.'" rel="dofollow">'.$getk15.'</a>

</p>';

?>

<p style="text-align: justify;"><strong>Back to <?php
printf( __( '<a href="%1$s" title="Return to %2$s" rel="gallery"> %2$s </a>', 'tetapsemangat' ), esc_url( get_permalink(
$post->post_parent ) ), get_the_title( $post->post_parent ));
?></strong></p>
</div>
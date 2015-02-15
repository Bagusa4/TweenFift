<?php
/**
 * Randompage Feature
**/
?>
<div style="margin: 0px 0px 0px 0px;text-align:justify;width:100%;float:left">
<p style="text-align: justify;">
<?php
/*<?php
echo 'K1 '.$K2.' '.$K3.' '.$K4.' K5 '.$K6.' K7 '.$partitle.' '.$K8.' k9 '.$k10.' K11 '.$catname.', ';$tags 		= get_the_tags($parid);

echo 'k12 '.$k13.' k14 '.$date.' k15 '.$author.'.';

?>

First Spinner Rule

Sentence 1, Sentence 2, Sentence 3, Sentence 4, Sentence 5, Sentence 6, Sentence 7, Sentence Post Name, Sentence 8, Sentence 9, Sentence 10, Sentence 11, Sentence Category Name, Sentence Tags Name, Sentence 12, Sentence 13, Sentence 14, Sentence Post Date, Sentence 15, Author Name.

Sentence Post Name, Sentence Category Name, Sentence Tags Name, Sentence Post Date, Author Name. Cannot be change.
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


// Sentence Editor
global $redux_tween_fift; // Global Framework
$k1 = $redux_tween_fift['opt-editor-spfirst-1-sentence'];
$getk1 = js_spin($k1);
$k2 = $redux_tween_fift['opt-editor-spfirst-2-sentence'];
$getk2 = js_spin($k2);
$k3 = $redux_tween_fift['opt-editor-spfirst-3-sentence'];
$getk3 = js_spin($k3);
$k4 = $redux_tween_fift['opt-editor-spfirst-4-sentence'];
$getk4 = js_spin($k4);
$k5 = $redux_tween_fift['opt-editor-spfirst-5-sentence'];
$getk5 = js_spin($k5);
$k6 = $redux_tween_fift['opt-editor-spfirst-6-sentence'];
$getk6 = js_spin($k6);
$k7 = $redux_tween_fift['opt-editor-spfirst-7-sentence'];
$getk7 = js_spin($k7);
$k8 = $redux_tween_fift['opt-editor-spfirst-8-sentence'];
$getk8 = js_spin($k8);
$k9 = $redux_tween_fift['opt-editor-spfirst-9-sentence'];
$getk9 = js_spin($k9);
$k10 = $redux_tween_fift['opt-editor-spfirst-10-sentence'];
$getk10 = js_spin($k10);
$k11 = $redux_tween_fift['opt-editor-spfirst-11-sentence'];
$getk11 = js_spin($k11);
$k12 = $redux_tween_fift['opt-editor-spfirst-12-sentence'];
$getk12 = js_spin($k12);
$k13 = $redux_tween_fift['opt-editor-spfirst-13-sentence'];
$getk13 = js_spin($k13);
$k14 = $redux_tween_fift['opt-editor-spfirst-14-sentence'];
$getk14 = js_spin($k14);
$k15 = $redux_tween_fift['opt-editor-spfirst-15-sentence'];
$getk15 = js_spin($k15);


/* iki kontene */

$title 		= $getk3;
$amazing 	= $getk2;
$amaspun 	= js_spin($amazing);
$photo	 	= $getk4;
$gambarspun	= js_spin($photo);
$part		= $getk6;
$partspun	= js_spin($part);
$article	= $getk8;
$articlespun = js_spin($article);
$categorized = $getk10;
$catspun	= js_spin($categorized);

$published	= $getk13;
$pubspun	= js_spin($published);


echo ''.$getk1.' '.$amaspun.' '.$title.' '.$gambarspun.' '.$getk5.' '.$partspun.' '.$getk7.' '.$partitle.' '.$articlespun.' '.$getk9.' '.$catspun.' '.$getk11.' '.$catname.', ';$tags 		= get_the_tags($parid);

 if($tags) {

	$i = 1;

	$limit = 3;

	shuffle($tags);

	echo '';

	foreach($tags as $tag) {

		if($i > $limit) {

		  break;

		} else {

		$tagname = $tag->name;


		if($i == $limit) { $comma = '';} else { $comma = ',';}

		echo $tagname.$comma.' ';

		}

		$i++;
		}
	}
echo ''.$getk12.' '.$pubspun.' '.$getk14.' '.$date.' '.$getk15.' '.$author.'.';
?>
</p>
</div>
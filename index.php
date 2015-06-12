<?php
/*
Plugin Name: WP Content Slideshow REVISITED (featured post)
Plugin URI: http://www.uziiuzair.net
Description: A modified version of <a href="http://wordpress.org/plugins/wp-content-slideshow-reborn/">WP Content Slideshow Reborn</a>. This shows posts slideshow, with thumbnails and descriptions. 
Version: 1.23
Author: Selnomeria, Uzair Hayat (@uziiuzair), IWEBIX
Author URI: ###
*/ if ( ! defined( 'ABSPATH' ) ) exit; //Exit if accessed directly

define('PLUGIN_URL__WCSR',plugin_dir_url(__FILE__));

//REDIRECT SETTINGS PAGE (after activation)
add_action( 'activated_plugin', 'activat_redirect__WCSR' ); function activat_redirect__WCSR( $plugin ) { if( $plugin == plugin_basename( __FILE__ ) ) { exit( wp_redirect( admin_url( 'admin.php?page=my-wcrs-pageslug' ) ) ); } }

//ACTIVATION HOOK
register_activation_hook( __FILE__, 'activation__WCSR' );function activation__WCSR() {global $wpdb;
	if (!get_option('wcsr_HiddenFromHome1')) { update_option('wcsr_HiddenFromHome1',	array('__start1') ); }
	if (!get_option('wcsr_HiddenFromHome2')) { update_option('wcsr_HiddenFromHome2',	array('__start2') ); }
}

//add checkbox in POSTS/PAGES edit page.
add_action("add_meta_boxes", "content_init__WCSR");function content_init__WCSR(){
	foreach (get_post_types() as $each){
		add_meta_box("wcsr_slider_box", "WP Content Slideshow (REVISITED)", "content_meta__WCSR", $each, "side", "low");
	}
} 	function content_meta__WCSR(){	global $post;	$custom = get_post_custom($post->ID);	?>
		<div style="color:orange;font-weight:bold;"> 
		<div style="">WP CONTENT SLIDESHOW:</div>
			Display in Type1 slideshow?:<input type="hidden" name="wcsr_slider_1" value="0" /> <input style="margin:0 0 0 2px;" type="checkbox" name="wcsr_slider_1" value="1" <?php if($custom["wcsr_slider_1"][0] == 1) { echo "checked='checked'";} ?> />
		<br/>Display in Type2 slideshow?:<input type="hidden" name="wcsr_slider_2" value="0" /> <input style="margin:0 0 0 2px;" type="checkbox" name="wcsr_slider_2" value="1" <?php if($custom["wcsr_slider_2"][0] == 1) { echo "checked='checked'";} ?> />
		<br/>Hide this post in HOME PAGE posts query?:<input type="hidden" name="wcsr_postNoShow_1" value="0" /> <input style="margin:0 0 0 25px;" type="checkbox" name="wcsr_postNoShow_1" value="1" <?php if( in_array($post->ID, get_option("wcsr_HiddenFromHome1"))) { echo "checked='checked'";} ?> />
		</div>
	<?php
	}
	//save checked
	add_action('save_post', 'save_content__WCSR');function save_content__WCSR($post_id){
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )  {  return $post_id; }
		global $post;
		if (isset($_POST['wcsr_slider_1'])){
			if (in_array($post->post_type,  get_post_types())) { 
				update_post_meta($post->ID, "wcsr_slider_1", $_POST["wcsr_slider_1"]);
				$ar= get_option("wcsr_HiddenFromHome1"); 
				if (0==$_POST['wcsr_postNoShow1']){	update_option("wcsr_HiddenFromHome1", array_diff($ar, [$post_id])  ); }
				if (1==$_POST['wcsr_postNoShow1']){	if(!in_array($post_id,$ar)) {$ar[]=$post_id;  update_option("wcsr_HiddenFromHome1", $ar); }}
			}
		}
		if (isset($_POST['wcsr_slider_2'])){
			if (in_array($post->post_type,  get_post_types())) { 
				update_post_meta($post->ID, "wcsr_slider_2", $_POST["wcsr_slider_2"]);
				$ar= get_option("wcsr_HiddenFromHome2"); 
				if (0==$_POST['wcsr_postNoShow2']){	update_option("wcsr_HiddenFromHome2", array_diff($ar, [$post_id])  ); }
				if (1==$_POST['wcsr_postNoShow2']){	if(!in_array($post_id,$ar)) {$ar[]=$post_id;  update_option("wcsr_HiddenFromHome2", $ar); }}
			}
		}
	}
add_action( 'pre_get_posts', 'querymodify__WCSR',77); 
function querymodify__WCSR($query) { $q=$query;
	if( $q->is_main_query() && !is_admin() ) {
		if($q->is_home){
			//$q->init();			$q->set('post_type',LNG);$q->set('category__not_in', 64);
			//var_dump($q);
			
			$excluded_posts = get_option("wcsr_HiddenFromHome1");
			$query->set('post__not_in', $excluded_posts);
		}
	}
	return $q;
}





//Check for Post Thumbnail Support
add_theme_support( 'post-thumbnails' );
// set image width
add_action('after_setup_theme','img_init__WCSR'); function img_init__WCSR(){
	$img_width = get_option('wcsr_content_img_width'); if(empty($img_width))		{ $img_width = 300;}
	$img_height = get_option('wcsr_content_height');   if(empty($img_height))	{ $img_height = 250;}
	if (function_exists('add_image_size')) { 
		add_image_size( 'wcsr_slider_1', $img_width, $img_height, true ); 
		add_image_size( 'wcsr_slider_2', $img_width, $img_height, true ); 
	}
}
//remove warning
add_action('wp','remove_jqcycle_warning__WCSR');function remove_jqcycle_warning__WCSR(){
	if (isset($_GET['wcsr_ok4'])) {	if (current_user_can('edit_post')) {update_option('wcsr__Jquery_Cycle_Warning', '1'); exit('value updated!');}  }
	if (isset($_GET['wcsr_ok5'])) {	if (current_user_can('edit_post')) {update_option('wcsr__Jquery_bxSlider_Warning', '1'); exit('value updated!');}  }	
}


// ============================================================== OPTIONS PAGE =======================================================
add_action('admin_menu', 'REVISITEDD_slideshow_options_page'); function REVISITEDD_slideshow_options_page() { add_submenu_page('options-general.php' , 'WP Content Slideshow', 'WP Content Slideshow', 'manage_options', 'my-wcrs-pageslug', 'my_submenu_page_callback' );} 	
function my_submenu_page_callback(){ ?>
<div class="wrap">
	<div style="margin-left:0px; float: left; width: 400px;">
		<!--
		<form method="post" action="options.php"><?php wp_nonce_field('update-options'); ?>
			<div class="inside">
				<table class="form-table">
					<tr>
						<th><label for="content_sort">Choose Sorting of Posts/Pages</label></th>
						<td>
							<select name="content_sort">
								<option value="post_date" <?php if(get_option('wcsr_content_sort') == "post_date") {echo "selected=selected";} ?>>Date</option>
								<option value="title" <?php if(get_option('wcsr_content_sort') == "title") {echo "selected=selected";} ?>>Title</option>
								<option value="rand" <?php if(get_option('wcsr_content_sort') == "rand") {echo "selected=selected";} ?>>Random</option>
							</select>
						</td>
					</tr>
					<tr>
						<th><label for="content_order">Choose Order of Posts/Pages</label></th>
						<td>
							<select name="content_order">
								<option value="ASC" <?php if(get_option('wcsr_content_order') == "ASC") {echo "selected=selected";} ?>>Ascending</option>
								<option value="DESC" <?php if(get_option('wcsr_content_order') == "DESC") {echo "selected=selected";} ?>>Descending</option>
							</select>
						</td>
					</tr>
					<tr>
						<th><label for="content_width">Set Slideshow Width(i.e. 960px or 90%)</label></th>
						<td><input type="text" name="content_width" value="<?php $width = get_option('wcsr_content_width'); if(!empty($width)) {echo $width;} else {echo "960px";}?>"></td>
					</tr>
					<tr>
						<th><label for="wcsr_content_height">Set Slideshow Height(i.e. 300px or 10%)</label></th>
						<td><input type="text" name="wcsr_content_height" value="<?php $height = get_option('wcsr_content_height'); if(!empty($height)) {echo $height;} else {echo "310px";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_bg">Set BG Color (hexadecimal)</label></th>
						<td><input type="text" name="content_bg" value="<?php $bg = get_option('wcsr_content_bg'); if(!empty($bg)) {echo $bg;} else {echo "FFF";}?>"></td>
					</tr>
					<tr>
						<th><label for="wcsr_content_img_width">Set Image Width</label></th>
						<td><input type="text" name="wcsr_content_img_width" value="<?php $img_width = get_option('wcsr_content_img_width'); if(!empty($img_width)) {echo $img_width;} else {echo "300px";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_img_height">Set Image Height</label></th>
						<td><input type="text" name="content_img_height" value="<?php $height = get_option('wcsr_content_height'); if(!empty($height)) {echo $height;} else {echo "300px";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_nav_width">Set Navigation Width</label></th>
						<td><input type="text" name="content_nav_width" value="<?php $content_nav_width = get_option('wcsr_content_nav_width'); if(!empty($content_nav_width)) {echo $content_nav_width;} else {echo "270px";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_nav_height">Set Navigation Height</label></th>
						<td><input type="text" name="content_nav_height" value="<?php $content_nav_height = get_option('wcsr_content_nav_height'); if(!empty($content_nav_height)) {echo $content_nav_height;} else {echo "62px";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_nav_bg">Set Navigation Background Color</label></th>
						<td><input type="text" name="content_nav_bg" value="<?php $content_nav_bg = get_option('wcsr_content_nav_bg'); if(!empty($content_nav_bg)) {echo $content_nav_bg;} else {echo "EEE";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_nav_active_bg">Set Navigation Background Active Color</label></th>
						<td><input type="text" name="content_nav_active_bg" value="<?php $nav_bg_active_color = get_option('wcsr_content_nav_active_bg'); if(!empty($nav_bg_active_color)) {echo $nav_bg_active_color;} else {echo "CCC";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_nav_color">Set Navigation Color</label></th>
						<td><input type="text" name="content_nav_color" value="<?php $content_nav_color = get_option('wcsr_content_nav_color'); if(!empty($content_nav_color)) {echo $content_nav_color;} else {echo "333";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_nav_active_color">Set Navigation Hover Color</label></th>
						<td><input type="text" name="content_nav_active_color" value="<?php $nav_color = get_option('wcsr_content_nav_active_color'); if(!empty($nav_color)) {echo $nav_color;} else {echo "FFF";}?>"></td>
					</tr>
					
				</table>
			</div>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="wcsr_content_nav_active_bg, wcsr_content_sort, wcsr_content_order, wcsr_content_width, wcsr_content_height, wcsr_content_bg, wcsr_content_img_width, wcsr_content_img_height, wcsr_content_nav_width, wcsr_content_nav_height, wcsr_content_nav_bg, wcsr_content_nav_color, wcsr_content_nav_active_color" />
			<p class="submit"><input type="submit" name="Submit" value="<?php _e('Update Options') ?>" /></p>
		</form>
		-->
	</div>
	<h2>(modified version of WP CONTENT SLIDESHOW REBORN)</h2>
	<br/>(this plugin provides framework, and is primarily intended for re-use by you/your developer. Style it from your .css files).
	<br/><br/>
	<p>USAGE: on Edit Page/Post, check the checkbox "FEATURE THIS POST", so, it will be listed in FEATURED POSTS lists.</p>

	<div style="margin-top: 15px;"> <style> table.brde td{border: 1px solid black;}</style>
		<li>Then, Add shortcode in posts/pages/homepage: <code>[ContentSlideshowRevisited posttype="post,page,custom" thumb_descriptions="no"]</code>  </li>
		<table class="brde">
			<tr><td><b>slider_type</b></td><td>1(default)  OR  2(not reccomended)</td></tr>
			<tr><td><b>posttype</b></td><td> specify one or several(comma delimited) post types, and that shortcode will get ALL FEATURED MARKED POSTS from them</td></tr>
			<tr><td><b>thumb_descriptions</b></td><td><b>yes</b>(default) or <b>no</b> (Show descriptions under thumbnail titles)</td></tr>
			<tr><td><b>thumb_title_trim</b></td><td><b>0</b>(default) or <b>30</b>(or XX) (If inserted any number instead of 0, then the thumbnail titles will be trimmed to that chars)</td></tr>
			<tr><td><b>image_qaulity</b></td><td><b>thumbnail</b>(default), <b>medium</b>, <b>large</b>, <b>full</b>   (thumbnail is easily streched, so, although its bad quality, it well fits the area)</td></tr>
			<tr><td><b>auto_detect_image</b></td><td><b>yes</b>(default) or <b>no</b> (whenever the FEATURED IMAGE is not set, should the plugin automatically search for images inside post content, and set it as Slide image?)</td></tr>
			<tr><td><b>content_order</b></td><td><b>ASC</b> or <b>DESC</b> </td></tr>
			<tr><td><b>content_sort</b></td><td><b>post_date</b> OR <b>title</b> OR rand </td></tr>
			<tr><td><b>on_mouseover</b></td><td><b>yes(default)</b> OR <b>no</b>  (so, whenever you mouseover the thumbnail in the right list, the MAIN SLIDE will be changed. Otherwise, you need to CLICK, instead of Mouseover)</td></tr>
		</table>
		<br/>
		<br/>
		<br/>p.s.
		<br/>1) in template files, you can use: <code>&lt;?php do_shortcode('[ContentSlideshowRevisited...]'); ?&gt;</code>
		<br/>2) When you are logged in, you will see <b>"EDIT THIS POST"</b> in the top of the slideshow.
		<br/>3) In case, you want to display posts according to a CUSTOM QUERY, then add this(for example) into your functions.php: <code> add_action('wp','my_custom_f'); function my_custom_f(){ $GLOBALS['WCSR_posts'] = get_posts( array( 'category' => 36,  'post_type'=>array('post'), 'orderby' =>'date', 'posts_per_page'=> 5, ) );}</code>
	</div>
</div>

<?php }     function cut__WCSR($text, $chars, $points = "...") {  $text = strip_tags($text);	if( strlen($text) <= $chars) { return $text;} else { return mb_strimwidth($text,0,$chars, $points,'utf-8'); } }


















//SHORTCODE [ContentSlideshowRevisited]
add_shortcode("ContentSlideshowRevisited", "insert_content__WCSR");
function insert_content__WCSR($atts, $content = null) {  $GLOBALS['CHOSENTYPE__WSCR_1'] = false;   $GLOBALS['CHOSENTYPE__WSCR_2'] = false; 
	//[ContentSlideshowRevisited slider_type='1']
	$SliderType=  (  (!$atts['slider_type']) ?  '1' : $atts['slider_type'] );
	
	if ($SliderType=="1")		{$GLOBALS['CHOSENTYPE__WSCR_1']=true; define('CHOSENTYPE__WSCR_1',true); return slidertype__WCSR($atts,$content);}
	elseif ($SliderType=="2")	{$GLOBALS['CHOSENTYPE__WSCR_2']=true; define('CHOSENTYPE__WSCR_2',true); return slidertype__WCSR($atts,$content);}
	else {exit("WSCR_error222:  incorrect_ SLIDER_ type is chosen..");}
}





												
function slidertype__WCSR($atts,$content){  $out= '';
	//create temporary ID
	$GLOBALS['wcsr_tempid'] = $GLOBALS['wcsr_tempid'] ? $GLOBALS['wcsr_tempid'] +1 : 1;
	$GLOBALS['wcsr_All_tempids'][$GLOBALS['wcsr_tempid']] = $GLOBALS['wcsr_tempid'];
	
	
	//[ContentSlideshowRevisited post_types='post,page,mycustomm']
	$post_types		= (empty($atts['post_types']) ? get_post_types() : array_filter(explode(',',$atts['post_types']))  );
	//[ContentSlideshowRevisited thumb_descriptions='no']
	$DescrEnabled	= (  ('no'==$atts['thumb_descriptions']) ?  false : true );
	//[ContentSlideshowRevisited thumb_title_trim='0']
	$TrimEnabled	= (  (!$atts['thumb_title_trim'] || '0'==$atts['thumb_title_trim']) ?  999 : $atts['thumb_title_trim'] );
	//[ContentSlideshowRevisited image_qaulity='thumbnail']
	$ImgQuality		= (  (!$atts['image_qaulity']) ?  'thumbnail' : $atts['image_qaulity'] );
	//[ContentSlideshowRevisited auto_detect_image='no']
	$AutoDetectImg	= ('no' == $atts['auto_detect_image'] ?  false : true );
	//[ContentSlideshowRevisited on_mouseover='no']
	$GLOBALS['OnMouseOver__WCSR'][$GLOBALS['wcsr_tempid']]	= ('no' == $atts['on_mouseover']  ?   false : true );

			//=====================get user-defined options===========================
			$height=get_option("wcsr_content_height"); $width=get_option("wcsr_content_width");	$content_nav_width=get_option("wcsr_content_nav_width"); $content_nav_height=get_option("wcsr_content_nav_height"); $content_nav_bg=get_option("wcsr_content_nav_bg"); $content_nav_color=get_option('wcsr_content_nav_color'); $bg=get_option("wcsr_content_bg"); $nav_bg_active_color=get_option('wcsr_content_nav_active_bg'); $nav_color=get_option('wcsr_content_nav_active_color'); $img_width=get_option('wcsr_content_img_width');
			//=========================================================================
			

//===============================================================================================================
//============================================= START OUTPUT ====================================================
//===============================================================================================================

	$out .= '
	<div class="wcsr_maincontainer">';
	
	//====== GET POSTS ======//
	$sort =get_option('wcsr_content_sort'); if(empty($sort)){$sort = "post_date";}
	$order =get_option('wcsr_content_order'); if(empty($order)){$order = "DESC";}
	$myposts = ( $GLOBALS['WCSR_posts']  ?  $GLOBALS['WCSR_posts']  :   get_posts( array( 'meta_key'=>'wcsr_slider_1', 'meta_value'=>'1', 'post_type'=>$post_types, 'suppress_filters' => 0, 'orderby' => $sort, 'order' => $order) )   );
	if (empty($myposts)) {return '<div class="wcsr_empty">WP CONTENT SLIDESHOW REVISITED: NO POSTS INCLUDED!!!!!!!!!!!!!</div>'; return;}
	foreach( $myposts as $post ) { 
		$allPosts[$post->ID]['ID']= $post->ID;
		$allPosts[$post->ID]['permalinkk']= get_the_permalink($post->ID);
		$allPosts[$post->ID]['titlee']=  $post->post_title;
		$allPosts[$post->ID]['miniTitle']= cut__WCSR($post->post_title,  30 , "..."); //preg_replace('/(\s*)([^\s]*)(.*)/', '$2', $post->post_title);
		$allPosts[$post->ID]['excerptt']= $post->post_content;
		$allPosts[$post->ID]['authoridd']= $post->post_author;	
		$allPosts[$post->ID]['adminEditUrl'] = !(current_user_can('edit_post')) ? '' : 
			'<span onclick="if(event.preventDefault) event.preventDefault(); else event.returnValue = false;  window.open(\''.get_edit_post_link($post->ID).'\',\'_blank\');void(0);" class="wcsr_adminEdit">You can edit this post <span style="font-size:0.8em;">(ID_'.$post->ID.')</span></span>';
			//this bugs with jquery: 'a href="'.get_edit_post_link($post->ID).'" target="_blank" class="wcsr_adminEdit">You can edit this post</a>';  //admin_url('post.php?post='.$post->ID.'&action=edit';
		$thumbnail_id = get_post_thumbnail_id($post->ID); 
		if (!empty($thumbnail_id)){	$allPosts[$post->ID]['thumbb']= wp_get_attachment_image_src( $thumbnail_id, $ImgQuality )[0]; } //fullsize gets streched, not good !!
		
		if(empty($allPosts[$post->ID]['thumbb'])) {
			if ($AutoDetectImg){
				preg_match_all('/\<img(.*?)src\=[\'\"](.*?)[\'\"]/si', $post->post_content, $matches);
				if ($matches[2][0]){$allPosts[$post->ID]['thumbb'] = $matches[2][0];}
			}
		}
		if(empty($allPosts[$post->ID]['thumbb'])) {
			$allPosts[$post->ID]['thumbb']= 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Coats_of_arms_of_None.svg/41px-Coats_of_arms_of_None.svg.png';
		}
		//$allPosts[$post->ID]['authorlinkk']= the_author_posts_link($post->ID);
		//$allPosts[$post->ID]['authoravatarr']= get_avatar( get_the_author_meta('user_email', $post->post_author ), apply_filters('twentytwelve_author_bio_avatar_size', 62 ) );
	}
		
		
	
	//=============================================================== Slider Type 1============================================================
	if ($GLOBALS['CHOSENTYPE__WSCR_1']){
		//============= ## Initial Cycle =========================
		if (!defined('WCSR_P1_ALREADY_CALLED')) {	
			$out .= '
			<style type="text/css">'.
			'.wcsr_maincontainer{clear: both;}'.
			'.wcsr_maincontainer .wcsr_single {width:'. ($width ?  $width : "100%").';padding:0px !important;background-color: #'. ($bg ? $bg : "FFF").';height: '. ($height ? $height : "375px").';overflow:hidden;border: 9px solid #CCC;position: relative;border-radius: 4px; margin:0px;}'.
			'.wcsr_maincontainer .wcsr_single ul {background:transparent !important;margin: 0 !important;border: none !important;padding: 0 !important;list-style-type: none !important;position: relative;}'.
			'.wcsr_maincontainer .wcsr_single a{color:rgb(139, 139, 255); text-decoration:none;}'.
			'.wcsr_maincontainer .wcsr_single .wcsr_big_area ul {float:left;overflow:visible; width:100%; margin:0px !important; padding:0px !important; height:300px; position:relative;}'.
			'.wcsr_maincontainer .wcsr_single .wcsr_big_area ul li {max-width: 100%; overflow: visible;display:none; width:100%; height: auto;display:block;position:relative;top: 0px !important;left: 0px !important;float: left;margin:0px !important; padding:0px !important;z-index:1;border:solid 1px transparent;}'.
			'.wcsr_maincontainer .wcsr_single .wcsr_big_area ul li .span6 img {width: 40px;height: 40px;float: left;}'.
			'.wcsr_maincontainer .wcsr_single .wcsr_big_area ul li img.wcsr_bigimg {max-width: 100%; width:800px; height:auto; border: none !important; }'.
			'.wcsr_maincontainer .wcsr_single .wcsr_big_area{float:left;	width:59.5%;}'.
			'.wcsr_maincontainer .wcsr_single ul.wcsr_navig_window {height: 100%; oldheight:'. ($height ?  $height : "250px").';width: 40%; oldwidth:'. ($content_nav_width ?  $content_nav_width : "270px").';margin:0;padding: 0;float:right; overflow:auto; z-index: 5; }'.
			'.wcsr_maincontainer .wcsr_maincontainer .slideme {font-size: 9px;float: right;}'.
			'.wcsr_maincontainer .wcsr_maincontainer .slideme a {font-size: 8px;text-decoration: none;color: #CCC;}'.
			'.wcsr_maincontainer .wcsr_single .wcsr_navig_window li {background-color: #'. ($content_nav_bg ? $content_nav_bg : "EEE").'; display:block; margin: 1px 0px; padding: 2px 2px 2px 2px; list-style-type:none;display:block; height:73px;  width:100%; oldwidth:'. ($content_nav_width ?  $content_nav_width : "270px").'; display:block; border: 1px solid; overflow: hidden; float: left;}'.
			'.wcsr_maincontainer .wcsr_single .wcsr_navig_window li a {cursor:default;height: 100%;oldheight:'. ($content_nav_height ?  $content_nav_height : "62px").';  width: 100%; oldwidth:'. ($content_nav_width ?  $content_nav_width : "270px").'; display:block; margin:0; padding:0px; list-style-type:none; display:block; color:#'. ($content_nav_color ?  $content_nav_color : "333").';overflow:hidden;font-size: 14px; font-weight: bold; line-height:1.3em;}'.
			'.wcsr_maincontainer .wcsr_single .wcsr_navig_window li.on a {background-color: #'. ($nav_bg_active_color ?  $nav_bg_active_color : "CCC").';color:#fff;}'.
			'.wcsr_maincontainer .wcsr_single .wcsr_navig_window li a:hover,.wcsr_single .wcsr_navig_window li a:active {color:#'. ($nav_color ?  $nav_color : "FFF").';background-color: #'. ($nav_bg_active_color ?  $nav_bg_active_color : "CCC").';}'.
			'.wcsr_maincontainer .Slide_content_ID_'.$GLOBALS["post"]->ID.' {font-size: 10px;float: right;clear: both;position: relative;top: -2px;background-color: #CCC;padding: 3px 3px;line-height: 10px !important;}'.
			'.wcsr_maincontainer .wcsr_single .wcsr_navig_window li .wcsr_contnt {height: 86px; float: none;font-size: 12px;font-weight: normal;padding-top: 1px;}'.
			'.wcsr_maincontainer .wcsr_single .wcsr_dclass1{width: 300px; height: 100px; margin-top: 40px;}'.
			'.wcsr_maincontainer .wcsr_single a.wcsr_bigimg_a{float: left; margin-left: 20px;   margin-bottom: 4px;}'.
			'.wcsr_maincontainer .wcsr_single h1.wcsr_bigimg_h1{font-size:25px; color:white; margin: 5px 0 0 0;}'.
			'.wcsr_maincontainer .wcsr_single p.wcsr_bigimg_p{ margin-top: 2px;}'.
			'.wcsr_maincontainer .wcsr_single span.wcsr_span6{width: 40px; height: 40px; float: left; margin-top: 2px;}'.
			'.wcsr_maincontainer .wcsr_single .wcsr_div2class{ padding:0 0 0 7px; margin-left: 10px; height: 100%;  overflow-y: hidden; xxoverflow: hidden;}'.
			'.wcsr_maincontainer .wcsr_single .wcsr_thumgImgContainer{ margin: 0px ;height: 70px; float: left;  max-width:70px; width: 50%;}'.
			'.wcsr_maincontainer .wcsr_single img.wcsr_thumbimage{width:100%;height:100%;}'.
			'.wcsr_maincontainer .wcsr_single .wcsr_bigimg_contents{position: absolute;background-color: rgba(5, 5, 5, 0.5); height:auto; margin: 220px 0 0 0; width:100%;       -webkit-box-shadow: inset 0px -37px 29px -9px rgba(0,0,0,0.96); -moz-box-shadow: inset 0px -37px 29px -9px rgba(0,0,0,0.96);box-shadow: inset 0px -37px 29px -9px rgba(0,0,0,0.96);}'.
			'.wcsr_maincontainer .wcsr_single .wcsr_bigimg_container {float:left; width:100%; max-width:none; oldwidth:'. ($img_width ?  $img_width : "300px").'; height: 100%; oldheight:'. ($height ?  $height : "300px").';}'.
			'.wcsr_maincontainer .wcsr_single .wcsr_adminEdit{position: absolute; left:0px;top:0px;   z-index: 44; background-color:#D3F5CB; cursor:pointer;border-radius: 5px;padding: 1px;}'.
			'.wcsr_maincontainer .wcsr_empty{background-color:red;padding:10px;}'.
			'.wcsr_maincontainer .wcsr_bottom_shadower{height: 60px; position: absolute; z-index: 239; top: 95px; width: 100%; left: 0; background: -moz-linear-gradient(top, rgba(0,0,0,0) 0%, rgba(0,0,0,0.99) 100%); /* FF3.6+ */ background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(0,0,0,0.99))); /* Chrome,Safari4+ */ background: -webkit-linear-gradient(top, rgba(0,0,0,0) 0%,rgba(0,0,0,0.99) 100%); /* Chrome10+,Safari5.1+ */ background: -o-linear-gradient(top, rgba(0,0,0,0) 0%,rgba(0,0,0,0.99) 100%); /* Opera 11.10+ */ background: -ms-linear-gradient(top, rgba(0,0,0,0) 0%,rgba(0,0,0,0.99) 100%); /* IE10+ */ background: linear-gradient(to bottom, rgba(0,0,0,0) 0%,rgba(0,0,0,0.99) 100%); /* W3C */ filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#00000000", endColorstr="#a6000000",GradientType=0 ); /* IE6-9 */  }'.
			'</style>';
			define('WCSR_P1_ALREADY_CALLED', true);
		}
		//======================= END OF -- Initial Cycle ===============
		
		
		$out .= '
		<div class="wcsr_single"  id="jtarget_wcsr_singl_'.$GLOBALS['wcsr_tempid'].'" >
			<div class="wcsr_big_area jtarget_wcsr_b1_'.$GLOBALS['wcsr_tempid'].'"><ul>';	$counting = 1;	foreach ($allPosts as $post){	$out .= '
					<li id="main-post-'.$counting.'" class="wcsr_each_slide postid-'.$post['ID'].'" onclick="location.href=\''.$post['permalinkk'].'\';" title="'. _("Open").'">	'.$post['adminEditUrl'].'
						<div class="wcsr_bigimg_container">  <img src="'.$post['thumbb'].'" class="wcsr_bigimg" alt="'.$post['miniTitle'].'" /> </div>
						<div class="wcsr_bigimg_contents"> <a class="wcsr_bigimg_a" href="'.$post['permalinkk'].'" target="_blank" >  <h1 class="wcsr_bigimg_h1">'.$post['titlee'].'</h1>  <p class="wcsr_bigimg_p">'. cut__WCSR( $post['excerptt'], 450, "...").'</p> <div class="wcsr_bottom_shadower"></div></a> </div>
					</li>';	$counting = $counting + 1; 
																											} $out .= '
				</ul>
			</div>
			<div class="wscr_navig_area">
				<ul class="wcsr_navig_window jtarget_wcsr_navigwind_'.$GLOBALS['wcsr_tempid'].'">';  $counting = 1;	 foreach ($allPosts as $post){$out .= '
					<li id="post-'.$counting.'" class="wcsr_navig_each_li postid-'.$post['ID'].' '. ( ($counting==1) ? 'on' :'') .' clearfix" >
						<a href="#main-post-'.$counting.'" class="wcsr_navig_a postThumb-'.$post['ID'].'" title="'. cut__WCSR($post['titlee'],  30 , "...") .'">
							<div class="wcsr_thumgImgContainer"><img src="'.$post['thumbb'].'" class="wcsr_thumbimage" alt="'.$post['miniTitle'].'" /></div>
							<div class="wcsr_div2class"><div class="wcsr_titl">'. cut__WCSR($post['titlee'], $TrimEnabled , "...").'</div>
								'.( $DescrEnabled ?  '<div class="wcsr_contnt">'. cut__WCSR($post['excerptt'], 120, "...").'</div>'   :  '' ).'
							</div>
						</a>
					</li>';	$counting = $counting + 1;														 } $out .='
				</ul>
			</div>
		</div>';
	}
	
	

	//=============================================================== Slider Type 2============================================================
	if ($GLOBALS['CHOSENTYPE__WSCR_2']){
		//============= ## Initial Cycle =========================
		if (!defined('WCSR_P2_ALREADY_CALLED')) {	
			$out .= '
			<style type="text/css">	/************************************** bx slider css *********************************************/   	/** RESET AND LAYOUT */'.
			 '.wcsr_maincontainer .bx-wrapper {position: relative;margin: 0 auto 60px;padding: 0;*zoom: 1; }'.
			 '.wcsr_maincontainer .bx-wrapper img {max-width: 100%;display: block; }'.
			 '/** THEME ===================================*/'.
			 '/* LOADER */'.
			 '.wcsr_maincontainer .bx-wrapper .bx-loading {min-height: 50px;background: url('.PLUGIN_URL__WCSR.'/js/bxslider/images/bx_loader.gif) center center no-repeat #fff;height: 100%;width: 100%;position: absolute;top: 0;left: 0;z-index: 2000; }'.
			 '/* PAGER */'.
			 '.wcsr_maincontainer .bx-wrapper .bx-pager {font-size: .85em;font-family: Arial;font-weight: bold;color: #666;padding-top: 20px; }'.
			 '.wcsr_maincontainer .bx-wrapper .bx-pager.bx-default-pager a:hover, .wcsr_maincontainer .bx-wrapper .bx-pager.bx-default-pager a.active {background: #039017 ; }'.
			 '/* DIRECTION CONTROLS (NEXT / PREV) */'.
			 '.wcsr_maincontainer .bx-wrapper .bx-prev {left: 10px;background: url('.PLUGIN_URL__WCSR.'/js/bxslider/images/controls.png) no-repeat 0 -32px; }'.
			 '.wcsr_maincontainer .bx-wrapper .bx-next { right: 10px;background: url('.PLUGIN_URL__WCSR.'/js/bxslider/images/controls.png) no-repeat -43px -32px; }'.
			 '.wcsr_maincontainer .bx-wrapper .bx-prev:hover { background-position: 0 0; }'.
			 '.wcsr_maincontainer .bx-wrapper .bx-next:hover { background-position: -43px 0; }'.
			 '.wcsr_maincontainer .bx-wrapper .bx-controls-direction a { position: absolute; top: 50%; margin-top: -16px; outline: 0; width: 32px; height: 32px; text-indent: -9999px; z-index: 9999; }'.
			 '.wcsr_maincontainer .bx-wrapper .bx-controls-direction a.disabled { display: none; }'.
			 '/* PAGER WITH AUTO-CONTROLS HYBRID LAYOUT */'.
			 '.wcsr_maincontainer .bx-wrapper .bx-controls.bx-has-controls-auto.bx-has-pager .bx-pager {/*text-align: left;*/ 	width: 100%; }'.
			 '.wcsr_maincontainer .bx-wrapper .bx-pager .bx-pager-item {display: inline-block;}'.
					//'/* AUTO CONTROLS (START / STOP) */  /*.bx-wrapper .bx-controls-auto { text-align: center; }*/'.
					// '.wcsr_maincontainer .bx-wrapper .bx-controls-auto {position: absolute;/*bottom: -30px;*/ 	width: 100%; }'.
					// '.wcsr_maincontainer .bx-wrapper .bx-controls-auto .bx-controls-auto-item {display: inline-block;*zoom: 1;*display: inline; }'.
					// '.wcsr_maincontainer .bx-wrapper .bx-controls-auto .bx-start {display: block;text-indent: -9999px;width: 10px;height: 11px;outline: 0;background: url('.PLUGIN_URL__WCSR.'/js/bxslider/images/controls.png) -86px -11px no-repeat;margin: 0 3px; }'.
					// '.wcsr_maincontainer .bx-wrapper .bx-controls-auto .bx-start:hover, .bx-wrapper .bx-controls-auto .bx-start.active {background-position: -86px 0; }'.
					// '.wcsr_maincontainer .bx-wrapper .bx-controls-auto .bx-stop {display: block;text-indent: -9999px;width: 9px;height: 11px;outline: 0;background: url('.PLUGIN_URL__WCSR.'/js/bxslider/images/controls.png) -86px -44px no-repeat;margin: 0 3px; }'.
					// '.wcsr_maincontainer .bx-wrapper .bx-controls-auto .bx-stop:hover, .bx-wrapper .bx-controls-auto .bx-stop.active {background-position: -86px -33px; }'.
					// '.wcsr_maincontainer .bx-wrapper .bx-controls.bx-has-controls-auto.bx-has-pager .bx-controls-auto {/*right: 0;*/ 	/*width: 35px;*/ }'.
					'.bx-controls-auto{display:none;}'.
			 '/* IMAGE CAPTIONS */'.
			 '.wcsr_maincontainer .bx-wrapper .bx-caption {position: absolute;bottom: 0;left: 0;background: #666\9;background: rgba(80, 80, 80, 0.75);width: 100%; }'.
			 '.wcsr_maincontainer .bx-wrapper .bx-caption span {color: #fff;font-family: Arial;display: block;font-size: .85em;padding: 10px; }'.
			 '.wcsr_maincontainer .bx-wrapper .bx-pager {position: absolute; width: 100%; text-align: center; }'.
			 '.wcsr_maincontainer .bx-wrapper .bx-pager.bx-default-pager a {	background: #89908A none repeat scroll 0% 0%;text-indent: -9999px;	display: block;	width: 10px;height: 10px;margin: 0px 5px;	outline: 0px none;	border-radius: 5px;	}'.
			'</style>    <style type="text/css">'.
			'.wcsr_maincontainer .wcsr_adminEdit{position: absolute; left:0px;top:0px;   z-index: 44; background-color:#D3F5CB; cursor:pointer;border-radius: 5px;padding: 1px;}'.
			'.wcsr_maincontainer .advps-slide-container{  max-width: 700px; background-color:white; position:relative; margin: 0 auto;}'.
			'.wcsr_maincontainer .advps-slide-container ul {margin:0;padding:0; }'.
			'.wcsr_maincontainer .advps-excerpt-one{position:absolute;	 	-moz-opacity:1;filter:alpha(opacity=100);opacity:1;z-index:1; }'.
			'.wcsr_maincontainer .advps-overlay-one {width:100%;height:100%;position: absolute;top: 0;left: 0;z-index: 0; }'.
			'.wcsr_maincontainer .advps-excerpt-block-one{position:relative;	 	padding:10px;width:auto;height:auto;z-index:9; }'.
			'.wcsr_maincontainer .advps-slide-field-three img {float:left;margin-right:20px; }'.
			'.wcsr_maincontainer .advs-title a{font-weight:bold;text-decoration:none; }'.
			'/* ---------------------  navigation -----------------*/'. 
			'.wcsr_maincontainer .advps-number{position:absolute;font-size:11px;font-family:Arial, Helvetica, sans-serif;z-index:9999; }'.
			'.wcsr_maincontainer .advps-number ul{margin:0;padding:0; }'.
			'.wcsr_maincontainer .advps-number ul li{position:relative;list-style:none;float:left;display:inline;margin:0; }'.
			'.wcsr_maincontainer .advps-number li a {margin: 2px 2px 2px 0;padding:5px 8px 5px 8px;text-decoration:none;width:auto;display:block;color:#FFFFFF;font-size:12px;font-weight:bold;text-shadow: 0px 1px 1px #666666;background-color:#333333;background: -webkit-gradient(linear, 0 top, 0 bottom, from(#666666), to(#000000));background: -moz-linear-gradient(#555555, #000000);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#666666", endColorstr="#000000",GradientType=0 );background-image: -ms-linear-gradient(top, #666666 0%, #000000 100%);background-image: -o-linear-gradient(top, #666666 0%, #000000 100%);background-repeat:no-repeat !important;background-position:center !important;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px; }'.
			'.wcsr_maincontainer .advps-number li a:hover { color:#000000;text-shadow: 0 1px 0 #FFFFFF;background-color:#FFFFFF;background:-moz-linear-gradient(#FFFFFF, #E0E0E0);background:-webkit-gradient(linear, 0 top, 0 bottom, from(#FFFFFF), to(#E0E0E0));filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#FFFFFF", endColorstr="#E0E0E0",GradientType=0 );background-image: -ms-linear-gradient(top, #FFFFFF 0%, #E0E0E0 100%);background-image: -o-linear-gradient(top, #FFFFFF 0%, #E0E0E0 100%); }'.
			'.wcsr_maincontainer .advps-number li.activeSlide a{color:#000000;text-shadow: 0 1px 0 #FFFFFF;background-color:#FFFFFF;background:-moz-linear-gradient(#FFFFFF, #E0E0E0);background:-webkit-gradient(linear, 0 top, 0 bottom, from(#FFFFFF), to(#E0E0E0));filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#FFFFFF", endColorstr="#E0E0E0",GradientType=0 );background-image: -ms-linear-gradient(top, #FFFFFF 0%, #E0E0E0 100%);background-image: -o-linear-gradient(top, #FFFFFF 0%, #E0E0E0 100%);cursor:default; } '.
			'.wcsr_maincontainer .advps-bullet{width:auto;position:absolute;z-index:9999; }'.
			'.wcsr_maincontainer .advps-bullet li {display:inline;list-style:none;margin:0px !important; }'.
			'.wcsr_maincontainer .advps-bullet li a{display:block;width:18px;height:18px;float:left;background:url(images/advps-bullet-two.png) no-repeat;margin-left:2px; }'.
			'.wcsr_maincontainer .advps-bullet li a:hover{background:url(images/advps-bullet-active-two.png) no-repeat;cursor:pointer; }'.
			'.wcsr_maincontainer .advps-bullet li.activeSlide a{  background:url(images/advps-bullet-active-two.png) no-repeat; }'.
			'.wcsr_maincontainer .advps-slide-container .advs-title {line-height:30px; }'. 
			'</style>';
			define('WCSR_P2_ALREADY_CALLED', true);
		}
		//======================= END OF -- Initial Cycle ===============
		
		

		$out .= '
		<div id="advps_container3" class="advps-slide-container Fid1_'.$GLOBALS['wcsr_tempid'].'" style="">
			<div style="width: 100%; overflow: hidden; position: relative; " class="bx-viewport">
				<div id="advpsslideshow_3">';	$counting = 1;	foreach ($allPosts as $post){	$out .= ' 
					<div class="advps-slide">'.$post['adminEditUrl'].'
						<div class="advps-slide-field-three" >
							<a target="_blank" href="'.$post['permalinkk'].'/"> 
								<img src="'.$post['thumbb'].'" class="attachment-medium wp-post-image" alt="slide-4" height="199" width="300">
							</a> 
							<div>
								<h2 class="advs-title"><a target="_blank" href="'.$post['permalinkk'].'" >'.$post['titlee'].'</a></h2>
								<p>'. cut__WCSR( $post['excerptt'], 450, "...").'</p>
							</div>
						</div>
					</div>';	$counting = $counting + 1; 
																							} $out .= '
				</div>
			</div>
		</div>';
	}
	
	
	
	// final out
	return $out.'</div>';
}











































add_action('wp_footer','check_scripts433242',99);function check_scripts433242(){ 

	if (defined('CHOSENTYPE__WSCR_1') || defined('CHOSENTYPE__WSCR_2')) { $out =
		'<div class="Scripts_for_jSLIDERSHOW_1">';
			//check if jQuery Loaded
			$out .= 
			'<script type="text/javascript">
				if(!window.jQuery){  
				var script = document.createElement("script");   script.type = "text/javascript";  
				script.src = "'.PLUGIN_URL__WCSR.'/js/jquery.min.js";   //http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js
				document.getElementsByTagName("head")[0].appendChild(script);}
			</script>';
		
		
	
			// ========================== SLIDER_TYPE_1 =========================//
		if (defined('CHOSENTYPE__WSCR_1')){
			//check if Jquery-CYCLE function already exists
			if (!defined('wcsr_jmsg1') ){ define('wcsr_jmsg1', true);
				if (!get_option('wcsr__Jquery_Cycle_Warning')){
					$message='Warning. plugin '.basename(__DIR__).'/'.basename(__FILE__).' is using jqeury-cycle, an older version, and it seems, that you are already using this plugin and ensure, that there wont be a conflict, and everything works correctly. \r\nAfter checking, if you will see, that everything works correctly, then hide this alert window forever,by accessing this page again, just in the URL address add the parameter :\r\n\r\n'.home_url().'/?wcsr_ok4\r\n\r\nAnd this alert message will never happen again... or edit this simple plugin file';
					$out .= '<script>if (jQuery.isFunction(jQuery.fn.cycle)) {alert("'.$message.'");}</script>';
				}
			}
				
			$out .= '
			<script type="text/javascript" src="'.PLUGIN_URL__WCSR.'/js/jquery.cycle.all.2.72.js"></script>';
			$out .= '	
			<script type="text/javascript">';
				// Tutorial by http://ooyes.net/
				
				foreach ($GLOBALS['wcsr_All_tempids'] as $eachId){ $out .='
					$slideshow'.$eachId.' = {context: false,tabs: false,timeout: 8000,	fx: "fade",  slideSpeed: 900,tabSpeed: 900,     
						init:             function() { this.context = jQuery("#jtarget_wcsr_singl_'.$eachId.'");  this.tabs = jQuery("ul.jtarget_wcsr_navigwind_'.$eachId.' li", this.context);  this.tabs.remove(); this.startSlideshow(); },
						startSlideshow:   function() { var sldd= $slideshow'.$eachId.';
							jQuery("div.jtarget_wcsr_b1_'.$eachId.' > ul", $slideshow'.$eachId.'.context).cycle({
								fx: sldd.fx,  pager:jQuery("ul.jtarget_wcsr_navigwind_'. $eachId.'", sldd.context),   pagerAnchorBuilder:sldd.startTabs,	before:sldd.Tabactive,   timeout: sldd.timeout,   speed:sldd.slideSpeed,   fastOnEvent: sldd.tabSpeed,   pauseOnPagerHover:true,	pause: true
							});       
						},
						startTabs:    function(i, slide) {return $slideshow'.$eachId.'.tabs.eq(i); },
						Tabactive:    function(currentSlide, nextSlide) {
							var activeTab = jQuery("a[href=\'#" + nextSlide.id + "\']", $slideshow'.$eachId.'.context);
							if(activeTab.length) { $slideshow'.$eachId.'.tabs.removeClass("on");    activeTab.parent().addClass("on"); }            
						}            
					};
					jQuery(document).ready(function($) {  $slideshow'.$eachId.'.init(); }); 
					';
				}
				$out .= '
			</script>';
			$out .= '
			<script type="text/javascript"> //change them onmouseover
				function My_WCSR_clicker(idd){
					var al_parent=document.getElementById("jtarget_wcsr_singl_"+idd);		var allAhrefs=al_parent.getElementsByClassName("wcsr_navig_a");
					for (var i=0; i <allAhrefs.length; i++){
						allAhrefs[i].addEventListener("mouseover", function(e) {        this.click();				}, false);
					}
				}';
				foreach ($GLOBALS['OnMouseOver__WCSR'] as $nm=>$val){	if ($val) { $out .="\r\n".'window.onload=My_WCSR_clicker('.$nm.');';}	}
				$out .='
			</script>';
		}
		
		
		
		// ========================== SLIDER_TYPE_2 =========================//
		if (defined('CHOSENTYPE__WSCR_2')){	
			//check if Jquery-CYCLE function already exists
			if (!defined('wcsr_jmsg2') ){ define('wcsr_jmsg2', true);
				if (!get_option('wcsr__Jquery_bxSlider_Warning')){
					$message='Warning. plugin '.basename(__DIR__).'/'.basename(__FILE__).' is using jqeury-bxSlider, an older version, and it seems, that you are already using this plugin and ensure, that there wont be a conflict, and everything works correctly. \r\nAfter checking, if you will see, that everything works correctly, then hide this alert window forever,by accessing this page again, just in the URL address add the parameter :\r\n\r\n'.home_url().'/?wcsr_ok5\r\n\r\nAnd this alert message will never happen again... or edit this simple plugin file';
					$out .= '<script>if (jQuery.isFunction(jQuery.fn.bxSlider)) {alert("'.$message.'");}</script>';
				}
			}
				
			$out .= '
			<script type="text/javascript" src="'.PLUGIN_URL__WCSR.'/js/bxslider/jquery.bxslider.min.js?ver=4.2.2"></script>';
			$out .= '	
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$("#advpsslideshow_3").bxSlider({
						useCSS:1, slideMargin:0, speed:400, mode:"fade", auto:1, autoHover:1, pause:3000, easing:"linear", captions:true, pagerType:"full", controls:1, pager:1,	autoControls:1					
						});
					$("#advpsslideshow_3 .advs-title a").hover(	function(){	$(this).css("color","#000000");	},
																function(){ $(this).css("color","#565656");	}
															  );
					$("#advpsslideshow_3 .advps-slide").hover(	function(){		},
																function(){		}
															  );
				});
			</script>';
			$out .= '
			<script type="text/javascript">
			//my customs
			</script>';
		}	

		echo $out.'</div>';
	}
}	
		
 ?>
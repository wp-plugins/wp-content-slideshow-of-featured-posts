<?php
//create temporary ID
$GLOBALS['wcsr_tempid'] = $GLOBALS['wcsr_tempid']? $GLOBALS['wcsr_tempid'] +1 : 1;
?>
<div class="wcsr_maincontainer"><?php
if (!defined('WCSR_JSFUNCS_ALREADY_CALLED')) { 

	//check if already exists the Jquery function
	if (!get_option('wcsr_JqueryCycle_warning')){
		
		$message='Warning. plugin '.basename(__DIR__).'/'.basename(__FILE__).' is using jqeury-cycle, an older version, and it seems, that you are already using this plugin and ensure, that there wont be a conflict, and everything works correctly. \r\nAfter checking, if you will see, that everything works correctly, then hide this alert window forever,by accessing this page again, just in the URL address add the parameter :\r\n\r\n'.home_url().'?wcsr_ok4\r\n\r\nAnd this alert message will never happen again... or edit this simple plugin file';
		if( 
			wp_script_is( 'jquery.cycle', 'registered' ) || wp_script_is( 'jquery.cycle', 'enqueued' ) || wp_script_is( 'jquery.cycle', 'done' ) ||
			wp_script_is( 'jquery-cycle', 'registered' ) || wp_script_is( 'jquery-cycle', 'enqueued' ) || wp_script_is( 'jquery-cycle', 'done' )
		) { echo '<script>alert("'.$message.'");</script>'; }
		echo '<script>if (jQuery.isFunction(jQuery.fn.cycle)) {alert("'.$message.'");}</script>';
	}
	
	
	echo '<script type="text/javascript" src="'.plugin_dir_url(__FILE__).'/jquery.cycle.all.2.72.js"></script>';
?><script type="text/javascript">
// Tutorial by http://ooyes.net/
$slideshow = {context: false,tabs: false,timeout: 8000,	fx: 'fade',  slideSpeed: 900,tabSpeed: 900,     
    init:             function() { this.context = jQuery('#jtarget_wcsr_singl_<?PHP echo $GLOBALS['wcsr_tempid'];?>');  this.tabs = jQuery('ul.jtarget_wcsr_navigwind_<?PHP echo $GLOBALS['wcsr_tempid'];?> li', this.context);  this.tabs.remove(); this.startSlideshow(); },
    startSlideshow:   function() {
        jQuery('div.jtarget_wcsr_b1_<?PHP echo $GLOBALS['wcsr_tempid'];?> > ul', $slideshow.context).cycle({
            fx: $slideshow.fx,
            pager: jQuery('ul.jtarget_wcsr_navigwind_<?PHP echo $GLOBALS['wcsr_tempid'];?>', $slideshow.context),
            pagerAnchorBuilder: $slideshow.startTabs,
            before: $slideshow.Tabactive,
			timeout: $slideshow.timeout,
            speed: $slideshow.slideSpeed,
            fastOnEvent: $slideshow.tabSpeed,
            pauseOnPagerHover: true,
            pause: true
        });            
    },
    startTabs:    function(i, slide) {return $slideshow.tabs.eq(i); },
    Tabactive:    function(currentSlide, nextSlide) {
        var activeTab = jQuery('a[href="#' + nextSlide.id + '"]', $slideshow.context);
        if(activeTab.length) {
            $slideshow.tabs.removeClass('on');
            activeTab.parent().addClass('on');
        }            
    }            
};

jQuery(document).ready(function($) {  $slideshow.init(); }); 
</script>

<script type="text/javascript">
function My_WCSR_clicker(){
	var allAhrefs=document.getElementsByClassName("wcsr_navig_a");
	for (var i=0; i <allAhrefs.length; i++){
		allAhrefs[i].addEventListener('mouseover', function(e) 
		{
			this.click();
		}, false);
	}
}
//window.onload=My_WCSR_clicker();
</script>

<style>
.wcsr_maincontainer{clear: both;}
.wcsr_single  {width: <?php $width = get_option('wcsr_content_width'); if(!empty($width)) {echo $width;} else {echo "100%";}?>;
padding:0px !important;background-color: #<?php $bg = get_option('wcsr_content_bg'); if(!empty($bg)) {echo $bg;} else {echo "FFF";}?>;
height: <?php $height = get_option('wcsr_content_height'); if(!empty($height)) {echo $height;} else {echo "310px";}?>;
overflow:hidden;border: 9px solid #CCC;position: relative;border-radius: 4px; margin:0px;}
.wcsr_single  ul {background:transparent !important;margin: 0 !important;border: none !important;padding: 0 !important;list-style-type: none !important;position: relative;}          
.wcsr_single  .wcsr_big_area ul {float:left;overflow: hidden;width:100%;margin: 0px !important;padding: 0px !important;height: 300px;position: relative;}
.wcsr_single  .wcsr_big_area ul li {overflow: hidden;display:none; width:100%; height: 278px !important;display:block;position:relative;top: 0px !important;left: 0px !important;float: left;margin: 0px !important;padding: 10px !important;z-index:1;border:solid 1px transparent;}
.wcsr_single  .wcsr_big_area ul li .span6 img {width: 40px;height: 40px;float: left;}
.wcsr_single  .wcsr_big_area{	float:left;	width:69.5%;}
.wcsr_single   ul.wcsr_navig_window {height: 100%; xx: <?php $height = get_option('wcsr_content_height'); if(!empty($height)) {echo $height;} else {echo "250px";}?>;width: 29.5%; xx:<?php $content_nav_width = get_option('wcsr_content_nav_width'); if(!empty($content_nav_width)) {echo $content_nav_width;} else {echo "270px";}?>;margin:0;padding: 0;float:left;overflow:auto;}
.wcsr_maincontainer .slideme {font-size: 9px;float: right;}
.wcsr_maincontainer .slideme a {font-size: 8px;text-decoration: none;color: #CCC;}
.wcsr_single  .wcsr_navig_window li {background-color: #<?php $content_nav_bg = get_option('wcsr_content_nav_bg'); if(!empty($content_nav_bg)) {echo $content_nav_bg;} else {echo "EEE";}?>; display:block;margin:0; padding: 2px 2px 2px 2px; list-style-type:none;display:block; height:73px;  width:100%; xx:<?php $content_nav_width = get_option('wcsr_content_nav_width'); if(!empty($content_nav_width)) {echo $content_nav_width;} else {echo "270";}?>px; display:block; border: 1px solid; overflow: hidden; float: left;}
.wcsr_single  .wcsr_navig_window li a {height: 100%;xxheight:<?php $content_nav_height = get_option('wcsr_content_nav_height'); if(!empty($content_nav_height)) {echo $content_nav_height;} else {echo "62";}?>px;  width: 100%; xxwidth: <?php $content_nav_width = get_option('wcsr_content_nav_width'); if(!empty($content_nav_width)) {echo $content_nav_width;} else {echo "270";}?>px; display:block; margin:0; padding:0px; list-style-type:none; display:block; color:#<?php $content_nav_color = get_option('wcsr_content_nav_color'); if(!empty($content_nav_color)) {echo $content_nav_color;} else {echo "333";}?>;overflow:hidden;font-size: 14px; font-weight: bold; line-height:1.3em;}
.wcsr_single  .wcsr_navig_window li.on a {background-color: #<?php $nav_bg_active_color = get_option('wcsr_content_nav_active_bg'); if(!empty($nav_bg_active_color)) {echo $nav_bg_active_color;} else {echo "CCC";}?>;color:#fff;}
.wcsr_single  .wcsr_navig_window li a:hover,.wcsr_single  .wcsr_navig_window li a:active {color:#<?php $nav_color = get_option('wcsr_content_nav_active_color'); if(!empty($nav_color)) {echo $nav_color;} else {echo "FFF";}?>;background-color: #<?php $nav_bg_active_color = get_option('wcsr_content_nav_active_bg'); if(!empty($nav_bg_active_color)) {echo $nav_bg_active_color;} else {echo "CCC";}?>;}
.<?php echo "Slide_content_ID_".$GLOBALS['post']->ID;?> {font-size: 10px;float: right;clear: both;position: relative;top: -2px;background-color: #CCC;padding: 3px 3px;line-height: 10px !important;}
.wcsr_single  .wcsr_navig_window li .wcsr_contnt {height: 86px; float: none;font-size: 12px;font-weight: normal;padding-top: 1px;}
.wcsr_single  .wcsr_dclass1{width: 300px; height: 100px; margin-top: 40px;}
.wcsr_single  a.wcsr_bigimg_a{float: left; margin-left: 20px;   margin-bottom: 4px;}
.wcsr_single  h1.wcsr_bigimg_h1{font-size:25px; margin-top: 1px;}
.wcsr_single  p.wcsr_bigimg_p{ margin-top: 2px;}
.wcsr_single  span.wcsr_span6{width: 40px; height: 40px; float: left; margin-top: 2px;}
.wcsr_single  a {color:blue; text-decoration:none;}
.wcsr_single  .wcsr_div2class{ margin-left: 10px; height: 100%;  overflow-y: hidden; xxoverflow: hidden;}
.wcsr_single  .wcsr_thumgImgContainer{ margin: 0px ;height: 70px; float: left;  max-width:70px; width: 50%;}
.wcsr_single  img.wcsr_thumbimage{width:100%;height:100%;}
.wcsr_single  .wcsr_bigimg_contents{position: relative; height:300px; margin: 0 2% 0 0; float: left;width: 49%;} 
.wcsr_single  .wcsr_bigimg_container {float:left; width:49%; max-width:300px; xx: <?php $img_width = get_option('wcsr_content_img_width'); if(!empty($img_width)) {echo $img_width;} else {echo "300px";}?>; height: 100%; xx:<?php $height = get_option('wcsr_content_height'); if(!empty($height)) {echo $height;} else {echo "300px";}?>;}
.wcsr_single  .wcsr_big_area ul li img.wcsr_bigimg {max-width: 100%; height:100%; border: none !important; }
.wcsr_single  .wcsr_adminEdit{position: absolute; left:0px;top:0px;   z-index: 44; background-color:#D3F5CB; cursor:pointer;border-radius: 5px;padding: 1px;}
.wcsr_empty{background-color:red;padding:10px;} 
</style>
<?php 
	define('WCSR_JSFUNCS_ALREADY_CALLED', true);
}







define('is_adminn_444442', (current_user_can('edit_post')?true:false) ) ;
function WCSR_cut($text, $chars, $points = "...") {
	$text = strip_tags($text);	if( strlen($text) <= $chars) { return $text;} else { return mb_strimwidth($text,0,$chars, $points,'utf-8'); }
}
$sort = get_option('wcsr_content_sort'); if(empty($sort)){$sort = "post_date";}
$order = get_option('wcsr_content_order'); if(empty($order)){$order = "DESC";}
$args = array( 'meta_key'=>'wcsr_slider', 'meta_value'=>'1', 'post_type'=>$post_types, 'suppress_filters' => 0, 'orderby' => $sort, 'order' => $order);
$myposts = get_posts( $args );
if (empty($myposts)) {echo '<div class="wcsr_empty">WP CONTENT SLIDESHOW REVISITED: NO POSTS INCLUDED!!!!!!!!!!!!!</div>'; return;}
foreach( $myposts as $post ) { 
	$allPosts[$post->ID]['ID']= $post->ID;
	$allPosts[$post->ID]['permalinkk']= get_the_permalink($post->ID);
	$allPosts[$post->ID]['titlee']=  $post->post_title;
	$allPosts[$post->ID]['miniTitle']= WCSR_cut($post->post_title,  30 , "..."); //preg_replace('/(\s*)([^\s]*)(.*)/', '$2', $post->post_title);
	$allPosts[$post->ID]['excerptt']= $post->post_content;
	$allPosts[$post->ID]['authoridd']= $post->post_author;	
	$allPosts[$post->ID]['adminEditUrl'] = !is_adminn_444442 ? '': 
		'<span onclick="window.open(\''.get_edit_post_link($post->ID).'\',\'_blank\');" class="wcsr_adminEdit">You can edit this post</span>';
		//this bugs with jquery: 'a href="'.get_edit_post_link($post->ID).'" target="_blank" class="wcsr_adminEdit">You can edit this post</a>';  //admin_url('post.php?post='.$post->ID.'&action=edit';
	$thumbnail_id = get_post_thumbnail_id($post->ID);
	
	if (!empty($thumbnail_id)){	$allPosts[$post->ID]['thumbb']= wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' )[0]; } //fullsize gets streched, not good !!
	else{$allPosts[$post->ID]['thumbb']= 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Coats_of_arms_of_None.svg/41px-Coats_of_arms_of_None.svg.png';}	

	
	//$allPosts[$post->ID]['authorlinkk']= the_author_posts_link($post->ID);
	//$allPosts[$post->ID]['authoravatarr']= get_avatar( get_the_author_meta('user_email', $post->post_author ), apply_filters('twentytwelve_author_bio_avatar_size', 62 ) );
}
?>
	<div id="jtarget_wcsr_singl_<?php echo $GLOBALS['wcsr_tempid'];?>" class="wcsr_single ">
		<div class="wcsr_big_area jtarget_wcsr_b1_<?php echo $GLOBALS['wcsr_tempid'];?>">
			<ul>
			<?php $counting = 1;	foreach ($allPosts as $post){	?>
				<li id="main-post-<?php echo $counting;?>" class="wcsr_each_slide postid-<?php echo $post['ID'];?>" onclick="location.href='<?php $post['permalinkk']; ?>';" title="<?php _e("Permanent Link to ");?><?php $post['titlee']; ?>">
					<?php echo $post['adminEditUrl'];?>
					<div class="wcsr_bigimg_container">
						<img src="<?php echo $post['thumbb'];?>" class="wcsr_bigimg" alt="<?php echo $post['miniTitle'];?>" />
					</div>
					<div class="wcsr_bigimg_contents">
						<a class="wcsr_bigimg_a" href="<?php echo $post['permalinkk']; ?>" target="_blank" >
							<h1 class="wcsr_bigimg_h1"><?php echo $post['titlee']; ?></h1>
							<p class="wcsr_bigimg_p"><?php echo WCSR_cut( $post['excerptt'], 450, "..."); ?> </p> 
						</a>
					</div>
					
				</li> <?php  $counting = $counting + 1; 
			} ?>
			</ul>
		</div>

		<ul class="wcsr_navig_window jtarget_wcsr_navigwind_<?php echo $GLOBALS['wcsr_tempid'];?>">
			<?php
			$counting = 1;	
			foreach ($allPosts as $post){ 	
				?>
				<li id="post-<?php echo $counting; ?>" class="wcsr_navig_each_li postid-<?php echo $post['ID'];?> <?php echo ($counting==1)? 'on' :'';?> clearfix" >
					<a href="#main-post-<?php echo $counting; ?>" class="wcsr_navig_a postThumb-<?php echo $post['ID']; ?>" title="<?php echo WCSR_cut($post['titlee'],  30 , "...") ?>">
						<div class="wcsr_thumgImgContainer">
							<img src="<?php echo $post['thumbb'];?>" class="wcsr_thumbimage" alt="<?php echo $post['miniTitle'];?>" />
						</div>
						<div class="wcsr_div2class">
							<div class="wcsr_titl"><?php echo WCSR_cut($post['titlee'], ($TrimEnabled ? $TrimEnabled : 30 ) , "..."); ?></div>
							<?php if ($DescrEnabled){ ?> <div class="wcsr_contnt"><?php echo WCSR_cut($post['excerptt'], 120, "...");  ?></div> <?php } ?>
						</div>
					</a>
				</li><?php 
				$counting = $counting + 1;
			} ?>
		</ul>
	</div>

</div>
<div class="WCSR_MainContainer"><?php
 if (!defined('ALREADY_CALLED_WCSR_55')) : 




	if( 
		wp_script_is( 'jquery.cycle', 'registered' ) || !wp_script_is( 'jquery.cycle', 'enqueued' ) || !wp_script_is( 'jquery.cycle', 'done' ) ||
		wp_script_is( 'jquery-cycle', 'registered' ) || !wp_script_is( 'jquery-cycle', 'enqueued' ) || !wp_script_is( 'jquery-cycle', 'done' )
	) {
		echo '<script>alert("Warning. You seem to be using jQuery-cycle plugin. However, a plugin '.basename(__DIR__).'/'.basename(__FILE__).' is using jqeury-cycle plugin too, an older version, and ensure, that there wont be a conflict, and everything works correctly. \r\nAfter checking, if you will see, that everything works correctly, then hide this alert window forever,by accessing this page again, just in the URL address add the parameter :\r\n\r\n'.home_url().'?remove_jquery_cycle_warning\r\n\r\nAnd this alert message will never happen again... or edit this simple plugin file")</script>';
	}
	echo '<script type="text/javascript" src="'.plugin_dir_url(__FILE__).'/jquery.cycle.all.2.72.js"></script>';
?><script type="text/javascript">
// Tutorial by http://ooyes.net/

$slideshow = {context: false,tabs: false,timeout: 8000,	fx: 'fade',  slideSpeed: 900,tabSpeed: 900,     
    init: function() {
        this.context = jQuery('#content-slideshow');  this.tabs = jQuery('ul.slideshow-nav li', this.context);  this.tabs.remove(); this.startSlideshow();
    },
    
    startSlideshow: function() {
        jQuery('div.content_slideshow > ul', $slideshow.context).cycle({
            fx: $slideshow.fx,
            pager: jQuery('ul.slideshow-nav', $slideshow.context),
            pagerAnchorBuilder: $slideshow.startTabs,
            before: $slideshow.Tabactive,
	    timeout: $slideshow.timeout,
            speed: $slideshow.slideSpeed,
            fastOnEvent: $slideshow.tabSpeed,
            pauseOnPagerHover: true,
            pause: true
        });            
    },
    
    startTabs: function(i, slide) {
        return $slideshow.tabs.eq(i);
    },

    Tabactive: function(currentSlide, nextSlide) {
        var activeTab = jQuery('a[href="#' + nextSlide.id + '"]', $slideshow.context);
        if(activeTab.length) {
            $slideshow.tabs.removeClass('on');
            activeTab.parent().addClass('on');
        }            
    }            
};

jQuery(document).ready(function($) {
    $slideshow.init();
});  
</script>







<script type="text/javascript">
function My_WCSR_clicker(){
	var allAhrefs=document.getElementsByClassName("csr_postThumb");
	for (var i=0; i <allAhrefs.length; i++){
		allAhrefs[i].addEventListener('mouseover', function(e) 
		{
			this.click();
		}, false);
	}
}
window.onload=My_WCSR_clicker();
</script>

<style>
.WCSR_MainContainer{clear: both;}
#content-slideshow {width: <?php $width = get_option('content_width'); if(!empty($width)) {echo $width;} else {echo "100%";}?>;
padding:0px !important;background-color: #<?php $bg = get_option('content_bg'); if(!empty($bg)) {echo $bg;} else {echo "FFF";}?>;
height: <?php $height = get_option('content_height'); if(!empty($height)) {echo $height;} else {echo "310px";}?>;
overflow:hidden;border: 9px solid #CCC;position: relative;border-radius: 4px; margin:0px;}
#content-slideshow ul {background:transparent !important;margin: 0 !important;border: none !important;padding: 0 !important;list-style-type: none !important;position: relative;}          
#content-slideshow .content_slideshow ul {float:left;overflow: hidden;width:100%;margin: 0px !important;padding: 0px !important;height: 300px;position: relative;}
#content-slideshow .content_slideshow ul li {overflow: hidden;display:none; width:100%; height: 278px !important;display:block;position:relative;top: 0px !important;left: 0px !important;float: left;margin: 0px !important;padding: 10px !important;z-index:1;border:solid 1px transparent;}
#content-slideshow .content_slideshow ul li .span6 img {width: 40px;height: 40px;float: left;}
 #content-slideshow .content_slideshow{	float:left;	width:69.5%;}
#content-slideshow  ul.slideshow-nav {height: 100%; xx: <?php $height = get_option('content_height'); if(!empty($height)) {echo $height;} else {echo "250px";}?>;width: 29.5%; xx:<?php $content_nav_width = get_option('content_nav_width'); if(!empty($content_nav_width)) {echo $content_nav_width;} else {echo "270px";}?>;margin:0;padding: 0;float:left;overflow:auto;}
.slideme {font-size: 9px;float: right;}
.slideme a {font-size: 8px;text-decoration: none;color: #CCC;}
#content-slideshow .slideshow-nav li {background-color: #<?php $content_nav_bg = get_option('content_nav_bg'); if(!empty($content_nav_bg)) {echo $content_nav_bg;} else {echo "EEE";}?>; display:block;margin:0;padding:0;list-style-type:none;display:block; height:73px;  width:99%; xx:<?php $content_nav_width = get_option('content_nav_width'); if(!empty($content_nav_width)) {echo $content_nav_width;} else {echo "270";}?>px;display:block;border: 1px solid;overflow: hidden;margin: 0px;float: left;padding: 0px;margin-left: 0px;}
#content-slideshow .slideshow-nav li a {height: 100%; width: <?php $content_nav_width = get_option('content_nav_width'); if(!empty($content_nav_width)) {echo $content_nav_width;} else {echo "270";}?>px;display:block;margin:0;padding:2px;list-style-type:none;display:block;height:<?php $content_nav_height = get_option('content_nav_height'); if(!empty($content_nav_height)) {echo $content_nav_height;} else {echo "62";}?>px;color:#<?php $content_nav_color = get_option('content_nav_color'); if(!empty($content_nav_color)) {echo $content_nav_color;} else {echo "333";}?>;overflow:hidden;font-size: 14px;font-weight: bold;border-bottom: 1px solid #CCC;line-height:1.35em;}
#content-slideshow .slideshow-nav li p {height: 86px; float: none;font-size: 12px;font-weight: normal;padding-top: 1px;}
#content-slideshow .slideshow-nav li.on a {background-color: #<?php $nav_bg_active_color = get_option('content_nav_active_bg'); if(!empty($nav_bg_active_color)) {echo $nav_bg_active_color;} else {echo "CCC";}?>;color:#fff;}
#content-slideshow .slideshow-nav li a:hover,#content-slideshow .slideshow-nav li a:active {color:#<?php $nav_color = get_option('content_nav_active_color'); if(!empty($nav_color)) {echo $nav_color;} else {echo "FFF";}?>;background-color: #<?php $nav_bg_active_color = get_option('content_nav_active_bg'); if(!empty($nav_bg_active_color)) {echo $nav_bg_active_color;} else {echo "CCC";}?>;}
.<?php echo REVISITEDD_c_slideshow_get_dynamic_class();?> {font-size: 10px;float: right;clear: both;position: relative;top: -2px;background-color: #CCC;padding: 3px 3px;
line-height: 10px !important;}

#content-slideshow .dclass1{width: 300px; height: 100px; margin-top: 40px;}

#content-slideshow a.aclass2{float: left; margin-left: 20px;   margin-bottom: 4px;}
#content-slideshow h1.hclass1{font-size:25px; margin-top: 1px;}
#content-slideshow p.pcalss{ margin-top: 2px;}
#content-slideshow span.span6{width: 40px; height: 40px; float: left; margin-top: 2px;}
#content-slideshow a {color:blue; text-decoration:none;}
#content-slideshow .div2class{ margin-left: 10px; height: 100%;  overflow-y: hidden; xxoverflow: hidden;}
#content-slideshow  .thumgImgContainer{ margin: 0px ;height: 70px; float: left;  max-width:70px; width: 50%;}
#content-slideshow  img.thumbimage{width:100%;height:100%;}
#content-slideshow .mypostcontent{position: relative; height:300px; margin: 0 2% 0 0; float: left;width: 49%;} 
#content-slideshow .imgContainer {float:left; width:49%; max-width:300px; xx: <?php $img_width = get_option('content_img_width'); if(!empty($img_width)) {echo $img_width;} else {echo "300px";}?>; height: 100%; xx:<?php $height = get_option('content_height'); if(!empty($height)) {echo $height;} else {echo "300px";}?>;}
#content-slideshow .content_slideshow ul li img.imageclass1 {max-width: 100%; height:100%; border: none !important; }
#content-slideshow  .adminEdit{position: absolute; left:0px;top:0px;   z-index: 44; background-color:#D3F5CB; cursor:pointer;border-radius: 5px;padding: 1px;} 
</style>
<?php define('ALREADY_CALLED_WCSR_55', true);
endif; ?>


<?php
function REVISITEDD_cut_content_feat($text, $chars, $points = "...") {
	$text = strip_tags($text);	if( strlen($text) <= $chars) { return $text;} else { return mb_strimwidth($text,0,$chars, $points,'utf-8'); }
}
$sort = get_option('content_sort'); if(empty($sort)){$sort = "post_date";}
$order = get_option('content_order'); if(empty($order)){$order = "DESC";}
$args = array( 'meta_key'=>'content_slider', 'meta_value'=>'1', 'post_type'=>$post_types, 'suppress_filters' => 0, 'orderby' => $sort, 'order' => $order);
$myposts = get_posts( $args );
define('is_adminn_444442', (current_user_can('edit_post')?true:false) ) ;
foreach( $myposts as $post ) { 
	$allPosts[$post->ID]['ID']= $post->ID;
	$allPosts[$post->ID]['permalinkk']= get_the_permalink($post->ID);
	$allPosts[$post->ID]['titlee']=  $post->post_title;
	$allPosts[$post->ID]['excerptt']= $post->post_content;
	$allPosts[$post->ID]['authoridd']= $post->post_author;	
	$allPosts[$post->ID]['adminEditUrl'] = !is_adminn_444442 ? '': 
		'<span onclick="window.open(\''.get_edit_post_link($post->ID).'\',\'_blank\');" class="adminEdit">You can edit this post</span>';
		//this bugs with jquery: 'a href="'.get_edit_post_link($post->ID).'" target="_blank" class="adminEdit">You can edit this post</a>';  //admin_url('post.php?post='.$post->ID.'&action=edit';
	$thumbnail_id = get_post_thumbnail_id($post->ID);
	
	
	if (!empty($thumbnail_id)){	$allPosts[$post->ID]['thumbb']= wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' )[0]; } //fullsize gets streched, not good !!
	else{$allPosts[$post->ID]['thumbb']= 'http://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Coats_of_arms_of_None.svg/41px-Coats_of_arms_of_None.svg.png';}	

	
	//$allPosts[$post->ID]['authorlinkk']= the_author_posts_link($post->ID);
	//$allPosts[$post->ID]['authoravatarr']= get_avatar( get_the_author_meta('user_email', $post->post_author ), apply_filters('twentytwelve_author_bio_avatar_size', 62 ) );
}
?>
	<div id="content-slideshow">
		<div class="content_slideshow">
			<ul>
			<?php $counting = 1;	foreach ($allPosts as $post){	?>
				<li id="main-post-<?php echo $counting;?>" class="slidedClass postid-<?php echo $post['ID'];?>" onclick="location.href='<?php $post['permalinkk']; ?>';" title="<?php _e("Permanent Link to ");?><?php $post['titlee']; ?>">
					<?php echo $post['adminEditUrl'];?>
					<div class="imgContainer">
						<img src="<?php echo $post['thumbb'];?>" class="imageclass1" />
					</div>
					<div class="mypostcontent">
						<a class="aclass2" href="<?php echo $post['permalinkk']; ?>" title="<?php $post['titlee']; ?>" target="_blank" >
							<h1 class="hclass1"><?php echo $post['titlee']; ?></h1>
							<p class="pcalss"><?php echo REVISITEDD_cut_content_feat( $post['excerptt'], 450, "..."); ?> </p> 
						</a>
						<div class="dclass1">
							<!-- <div class="span6">	<?php echo $post['authoravatarr']; ?>	</div>
								<div class="span6" style="float: left; width:60px; margin-top: 20px; margin-left: 10px; ">	<?php //echo $post['authorlinkk']; ?></div> -->
						</div>
					</div>
					
				</li>
			<?php $counting = $counting + 1; } ?>
			</ul>
		</div>

		<ul class="slideshow-nav">
			<?php
			$counting2 = 1;	
			foreach ($allPosts as $post){ 	
				?>
				<li id="post-<?php echo $counting2; ?>" class="csr_thumbClass posdid-<?php echo $post['ID'];?> <?php echo ($counting2==1)? 'on' :'';?> clearfix" >
					<a href="#main-post-<?php echo $counting2; ?>" class="csr_postThumb postThumb-<?php echo $post['ID']; ?>" title="<?php echo REVISITEDD_cut_content_feat($post['titlee'], 30, "...") ?>">
						<div class="thumgImgContainer">
							<img src="<?php echo $post['thumbb'];?>" class="thumbimage"/>
						</div>
						<div class="div2class">
							<?php echo REVISITEDD_cut_content_feat($post['titlee'], 30, "..."); ?><br />
							<p><?php echo REVISITEDD_cut_content_feat($post['excerptt'], 120, "...");  ?> </p>
						</div>
					</a>
				</li>
				<?php 
				$counting2 = $counting2 + 1;
			} ?>
		</ul>
	</div>

</div>
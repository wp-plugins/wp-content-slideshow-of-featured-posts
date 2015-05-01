<?php
/*
Plugin Name: WP Content Slideshow - REVISITED
Plugin URI: http://www.uziiuzair.net
Description: A modified version of the modified <a href="http://wordpress.org/plugins/wp-content-slideshow-reborn/">WP Content Slideshow Reborn</a>
Version: 1.0
Author: Selnomeria, Uzair Hayat (@uziiuzair), IWEBIX
Author URI: ###
*/
//REDIRECT SETTINGS PAGE (after activation)
add_action( 'activated_plugin', 'activat_redirect__WCSR' ); function activat_redirect__WCSR( $plugin ) { if( $plugin == plugin_basename( __FILE__ ) ) { exit( wp_redirect( admin_url( 'admin.php?page=my-wcrs-pageslug' ) ) ); } }



add_action("add_meta_boxes", "REVISITEDD_content_init");
function REVISITEDD_content_init(){
	foreach (get_post_types() as $each){
		add_meta_box("content_slider", "WP Content Slideshow Reborn Options", "REVISITEDD_content_meta", $each, "normal", "high");
	}
}
	function REVISITEDD_content_meta(){
		global $post;
		$custom = get_post_custom($post->ID);
		$content_slider = $custom["content_slider"][0];
	?>
		<div class="inside">
			<table class="form-table">
				<tr>
					<th><label for="content_slider">Feature in WP Content Slideshow REVISITED?</label></th>
					<td><input type="checkbox" name="content_slider" value="1" <?php if($content_slider == 1) { echo "checked='checked'";} ?></td>
				</tr>
			</table>
		</div>
	<?php
	}
	
	
add_action('save_post', 'REVISITEDD_save_content');
function REVISITEDD_save_content($post_id){
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )  {  return $post_id; }
    global $post;
	if (isset($_POST['content_slider'])){
		if (in_array($post->post_type,  get_post_types())) { 
			update_post_meta($post->ID, "content_slider", $_POST["content_slider"]);
		}
	}
}

add_action('wp_enqueue_scripts', 'REVISITEDD_add_content_scripts');
function REVISITEDD_add_content_scripts() {
	if ( !is_admin() ) {
	wp_enqueue_script('jquery.cycle',  plugin_dir_url(__FILE__).'/jquery.cycle.all.2.72.js', array('jquery'), '1.3' );
	}
}

function REVISITEDD_insert_content($atts, $content = null) {
	//i.e.  [contentSlideshow post_types='post,page,mycustomm']
	if (!empty($atts['post_types'])) { $post_types = array_filter(explode(',',$atts['post_types'])); }
	else							 { $post_types = get_post_types(); }
    include_once(__DIR__.'/content-slideshow.php');
}
add_shortcode("contentSlideshow", "REVISITEDD_insert_content");



$img_width = get_option('content_img_width'); if(empty($img_width))		{ $img_width = 300;}
$img_height = get_option('content_height');   if(empty($img_height))	{ $img_height = 250;}
if (function_exists('add_image_size')) { 
	add_image_size( 'content_slider', $img_width, $img_height, true ); 
}

//Check for Post Thumbnail Support
add_theme_support( 'post-thumbnails' );
function REVISITEDD_c_slideshow_get_dynamic_class() {
	return "Slide_content_ID_".$GLOBALS['post']->ID;
}






















// ===================================================================================================================================
// ============================================================== OPTIONS PAGE =======================================================
// ===================================================================================================================================
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
								<option value="post_date" <?php if(get_option('content_sort') == "post_date") {echo "selected=selected";} ?>>Date</option>
								<option value="title" <?php if(get_option('content_sort') == "title") {echo "selected=selected";} ?>>Title</option>
								<option value="rand" <?php if(get_option('content_sort') == "rand") {echo "selected=selected";} ?>>Random</option>
							</select>
						</td>
					</tr>
					<tr>
						<th><label for="content_order">Choose Order of Posts/Pages</label></th>
						<td>
							<select name="content_order">
								<option value="ASC" <?php if(get_option('content_order') == "ASC") {echo "selected=selected";} ?>>Ascending</option>
								<option value="DESC" <?php if(get_option('content_order') == "DESC") {echo "selected=selected";} ?>>Descending</option>
							</select>
						</td>
					</tr>
					<tr>
						<th><label for="content_width">Set Slideshow Width(i.e. 960px or 90%)</label></th>
						<td><input type="text" name="content_width" value="<?php $width = get_option('content_width'); if(!empty($width)) {echo $width;} else {echo "960px";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_height">Set Slideshow Height(i.e. 300px or 10%)</label></th>
						<td><input type="text" name="content_height" value="<?php $height = get_option('content_height'); if(!empty($height)) {echo $height;} else {echo "310px";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_bg">Set BG Color (hexadecimal)</label></th>
						<td><input type="text" name="content_bg" value="<?php $bg = get_option('content_bg'); if(!empty($bg)) {echo $bg;} else {echo "FFF";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_img_width">Set Image Width</label></th>
						<td><input type="text" name="content_img_width" value="<?php $img_width = get_option('content_img_width'); if(!empty($img_width)) {echo $img_width;} else {echo "300px";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_img_height">Set Image Height</label></th>
						<td><input type="text" name="content_img_height" value="<?php $height = get_option('content_height'); if(!empty($height)) {echo $height;} else {echo "300px";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_nav_width">Set Navigation Width</label></th>
						<td><input type="text" name="content_nav_width" value="<?php $content_nav_width = get_option('content_nav_width'); if(!empty($content_nav_width)) {echo $content_nav_width;} else {echo "270px";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_nav_height">Set Navigation Height</label></th>
						<td><input type="text" name="content_nav_height" value="<?php $content_nav_height = get_option('content_nav_height'); if(!empty($content_nav_height)) {echo $content_nav_height;} else {echo "62px";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_nav_bg">Set Navigation Background Color</label></th>
						<td><input type="text" name="content_nav_bg" value="<?php $content_nav_bg = get_option('content_nav_bg'); if(!empty($content_nav_bg)) {echo $content_nav_bg;} else {echo "EEE";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_nav_active_bg">Set Navigation Background Active Color</label></th>
						<td><input type="text" name="content_nav_active_bg" value="<?php $nav_bg_active_color = get_option('content_nav_active_bg'); if(!empty($nav_bg_active_color)) {echo $nav_bg_active_color;} else {echo "CCC";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_nav_color">Set Navigation Color</label></th>
						<td><input type="text" name="content_nav_color" value="<?php $content_nav_color = get_option('content_nav_color'); if(!empty($content_nav_color)) {echo $content_nav_color;} else {echo "333";}?>"></td>
					</tr>
					<tr>
						<th><label for="content_nav_active_color">Set Navigation Hover Color</label></th>
						<td><input type="text" name="content_nav_active_color" value="<?php $nav_color = get_option('content_nav_active_color'); if(!empty($nav_color)) {echo $nav_color;} else {echo "FFF";}?>"></td>
					</tr>
					
				</table>
			</div>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="content_nav_active_bg, content_sort, content_order, content_width, content_height, content_bg, content_img_width, content_img_height, content_nav_width, content_nav_height, content_nav_bg, content_nav_color, content_nav_active_color" />
			<p class="submit"><input type="submit" name="Submit" value="<?php _e('Update Options') ?>" /></p>
		</form>
		-->
	</div>
	<h2>(modified version of WP CONTENT SLIDESHOW REBORN)</h2>
	<br/>(this plugin provides framework, and is primarily intended for re-use by you/your developer. Style it from your .css files).
	<br/><br/>
	<p>USAGE: on Edit Page/Post, check the checkbox "FEATURE THIS POST", so, it will be listed in FEATURED POSTS lists.</p>

	<div style="margin-top: 15px;">
			<li>Then, Add shortcode in posts/pages/homepage: <code>[contentSlideshow posttype="post,page,custom" content_order="ASC" content_sort="post_date"]</code>  </li>
			<table>
				<tr><td><b>posttype</b></td><td> specify one or several(comma delimited) post types, and that shortcode will get ALL FEATURED MARKED POSTS from them</td></tr>
				<tr><td><b>content_order</b></td><td> ASC or DESC </td></tr>
				<tr><td><b>content_sort</b></td><td>  post_date OR title OR rand </td></tr>
			</table>
			<br/>
			<br/>
			<br/>p.s.
			<br/>1) in template files, you can use: <code>&lt;?php do_shortcode('[contentSlideshow...]'); ?&gt;</code>
			<br/>2) When you are logged in, you will see <b>"EDIT THIS POST"</b> in the top of the slideshow.
	</div>
</div>

<?php } ?>
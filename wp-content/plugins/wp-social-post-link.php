<?php
/*
Plugin Name: WP Social Post Link
Plugin URI: http://vnwebmaster.com
Description: Tự động tạo các hình đại diện, tiêu đề và phần mô tả nội dung bài viết cho các mạng xã hội như FaceBook, Google, Linkhay...dựa trên nội dung bài.
Author: Nguyen Duy Nhan
Version: 1.0.0
Author URI: http://nhanweb.com
*/

function nhanweb_insert_meta_image(){
	if(get_option('pstlinkimg_activated') == '1'){
		
		if(is_single() || is_page()){
			$id=intval($post->ID);
			$post = get_post($id);
			$thumbs = nhanweb_pstlinkgf_get_thumbnail();
			if(get_option('pstlinkimg_simple_link')){
				if(has_post_thumbnail($id)) {
					echo "<link rel=\"image_src\" href=\"".$thumbs['thumb']."\" />";
				}
			}else{
				if(get_option('pstlinkimg_advance_information')==0){
					$the_description = nhanweb_auto_exceprt(strip_tags($post->post_content), 200);
					
					echo "<meta property=\"og:image\" content=\"".$thumbs['thumb']."\"/>";
					echo "<meta property=\"og:title\" content=\"".$post->post_title."\"/>";
					echo "<meta property=\"og:site_name\" content=\"".get_bloginfo('name')."\"/>";
					echo "<meta property=\"og:url\" content=\"".get_permalink($id)."\"/>";
					echo "<meta property=\"og:description\" content=\"".$the_description."\" />";
				}else{
					echo "<meta property=\"og:image\" content=\"".$thumbs['thumb']."\" />";
				}
			}
		}else{
			if(get_option('pstlinkimg_default_img')==''){
				$imgsrc = "http://www.n2dgroup.com/templates/2009/images/forum.jpg";
				echo "<meta property=\"og:image\" content=\"".$imgsrc."\"/>";
			}else{
				echo "<meta property=\"og:image\" content=\"".get_option('pstlinkimg_default_img')."\"/>";
			}
		}
	}
}

add_filter('wp_head', 'nhanweb_insert_meta_image');


/* this function gets thumbnail from Post Thumbnail or Custom field or First post image */
function nhanweb_pstlinkgf_get_thumbnail($width=100, $height=100, $custom_field='', $post='')
{
	if ( $post == '' ) global $post;
	global $shortname, $posts;
	
	$thumb_array['thumb'] = '';
	
	if ( function_exists('has_post_thumbnail') ) {
		if ( has_post_thumbnail( $post->ID ) ) {
			
			$thumb_array['thumb'] = get_the_post_thumbnail( $post->ID, array($width,$height) );
			if ($thumb_array['thumb'] <> '') { 
				$thumb_array['thumb'] = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $thumb_array['thumb'], $matches);
				$thumb_array['thumb'] = trim($matches[1][0]);
			}
		}
	}
	
	if ($thumb_array['thumb'] == '') {
		if ($custom_field == '') $thumb_array['thumb'] = get_post_meta($post->ID, 'Thumbnail', $single = true);
		else { 
			$thumb_array['thumb'] = get_post_meta($post->ID, $custom_field, $single = true);
			if ($thumb_array['thumb'] == '') $thumb_array['thumb'] = get_post_meta($post->ID, 'Thumbnail', $single = true);
		}
				
			if ($custom_field == '') 
				$thumb_array['thumb'] = apply_filters('et_fullpath', $thumb_array['thumb']);
			elseif ( $custom_field <> '' && get_post_meta($post->ID, 'Thumbnail', $single = true) ) 
				$thumb_array['thumb'] = apply_filters( 'et_fullpath', get_post_meta($post->ID, 'Thumbnail', $single = true) );
		}	
	return $thumb_array;
}
/**********************************************************
*	Function add admin menu
**********************************************************/
add_action('admin_menu', 'nhanweb_pstlink_add_menu');
function nhanweb_pstlink_add_menu() {
	if (function_exists('add_options_page')) {
		add_options_page(__('Social Link Setting', 'wp-social-post-link'), __('Social Link Setting', 'wp-social-post-link'), 'manage_options', 'wp-social-post-link/setting.php') ;
	}
}

/**********************************************************
*	Function install plugin
**********************************************************/
function nhanweb_pstlinkgf_run_install(){
		add_option('pstlinkimg_activated',1);
		add_option('pstlinkimg_simple_link',0);
		add_option('pstlinkimg_multi_img',0);
		add_option('pstlinkimg_default_img',"");
}
register_activation_hook(__FILE__, 'nhanweb_pstlinkgf_run_install');

if(!function_exists('nhanweb_auto_exceprt')){
	function nhanweb_auto_exceprt($str, $limit) {
		if ($limit < strlen($str)) {
		$str = substr($str, 0, $limit);
		$strarr = explode(' ', $str);
		unset($strarr[count($strarr) - 1]);
		$str = implode(' ', $strarr);
		}
		return $str;
	}
}

?>
<?php	

function get_film_meta($filmId) {
	global $wpdb;
	$q = " SELECT * 
	    FROM ".DATA_FILM_META."   
	    WHERE film_id = '$filmId'";
	$row = $wpdb->get_results($q);	
	if($row) {
		foreach ($row as $r) {
			return array(
			'film_id' => 			$r->film_id,
			'film_thumbnail' => 	$r->film_thumbnail,
			'film_ads_img' => 		$r->film_ads_img,
			'film_decu' => 			$r->film_decu,
			'film_hot' =>	 		$r->film_hot,
			'film_cinema' => 		$r->film_cinema,
			'film_drama' => 		$r->film_drama,
			'film_length' => 		$r->film_length,
			'film_year' =>			$r->film_year,
			'film_hd_download' => 	$r->film_hd_download,
			'film_trailer' => 		$r->film_trailer,
			'film_viewed' => 		$r->film_viewed,
			'film_viewed_d' => 		$r->film_viewed_d,
			'film_viewed_w' => 		$r->film_viewed_w,
			'film_viewed_m' => 		$r->film_viewed_m,
			'film_rating' => 		$r->film_rating,
			'film_rating_total' => 	$r->film_rating_total,
			);
		}
		
	} else  {
		return false;
	}
}
function add_film_meta ($film_id) {
	global $wpdb;
	if($_POST['film_drama'] != '') $drama = $_POST['film_drama'];
	else $drama = '0';
	$q = "INSERT INTO ".DATA_FILM_META." (
					film_id
					, film_thumbnail
					, film_ads_img
					, film_decu
					, film_hot
					, film_cinema
					, film_drama
					, film_length
					, film_year
					, film_hd_download
					, film_trailer
					) 
				VALUES (
					'".$film_id."'
					, '".$_POST['film_thumbnail']."'
					, '".$_POST['film_ads_img']."'
					, '".$_POST['film_decu']."'
					, '".$_POST['film_hot']."'
					, '".$_POST['film_cinema']."'
					, '".$drama."'
					, '".$_POST['film_length']."'
					, '".$_POST['film_year']."'
					,'".$_POST['film_hd_download']."'
					,'".$_POST['film_trailer']."'
					)";
	$r = $wpdb->query($q);
	if($r) {
		if($_POST ['film_thumbnail'] != '') {
			$q_post_meta = "INSERT INTO ".DATA_POSTMETA." (post_id, meta_key, meta_value) VALUES ('".$film_id."', 'vietpro_thumb', '".$_POST['film_thumbnail']."')";
			$r_post_meta = $wpdb->query($q_post_meta);
		}
		if($_POST ['film_episode'] != '') {
			$episode_post = $_POST ['film_episode'];
			$list_episode = explode ( "\n", $episode_post );
			$count_ep = count ( $list_episode );
			for($i = 0; $i < $count_ep; $i ++) {
				$tap [$i] = explode ( '#', trim ( $list_episode [$i] ) );
				$ten_tap [$i] = trim ( $tap [$i] [0] );
				$link_tap [$i] = trim ( $tap [$i] [1] );
				$thu_tu [$i] = trim ( $tap [$i] [2] );
				if(($link_tap [$i]!='') && $ten_tap [$i] != '')FilmEpisodeNewEpisode($ten_tap [$i],$film_id,$_POST['episode_server'],$link_tap [$i],$thu_tu [$i],time());
			}
		}
		
		return "Thêm film meta thành công";
	}
	else return "Éo thêm dc film meta";
}
function update_film_meta ($film_id) {
	global $wpdb;
	if($_POST['film_drama'] != '') $drama = $_POST['film_drama'];
	else $drama = '0';
	$q = "UPDATE ".DATA_FILM_META." SET 
					film_thumbnail = '".$_POST['film_thumbnail']."'
					, film_ads_img = '".$_POST['film_ads_img']."'
					, film_decu = '".$_POST['film_decu']."'
					, film_hot = '".$_POST['film_hot']."'
					, film_cinema = '".$_POST['film_cinema']."'
					, film_drama = '".$drama."'
					, film_length = '".$_POST['film_length']."'
					, film_year = '".$_POST['film_year']."'
					, film_hd_download = '".$_POST['film_hd_download']."'
					, film_trailer = '".$_POST['film_trailer']."'
				WHERE film_id = '".$film_id."'";
	$r = $wpdb->query($q);
	if($r) {
		if($_POST ['film_thumbnail'] != '') {
			if(get_post_meta($film_id,'vietpro_thumb',true) != '') {
				$q_post_meta = "UPDATE ".DATA_POSTMETA." SET meta_value = '".$_POST['film_thumbnail']."' 
									WHERE post_id = '".$film_id."' AND  meta_key =  'vietpro_thumb'";
				$r_post_meta = $wpdb->query($q_post_meta);
			} else {
				$q_post_meta = "INSERT INTO ".DATA_POSTMETA." (post_id, meta_key, meta_value) VALUES ('".$film_id."', 'vietpro_thumb', '".$_POST['film_thumbnail']."')";
				$r_post_meta = $wpdb->query($q_post_meta);
			}
		}
		if($_POST ['film_episode'] != '') {
			$episode_post = $_POST ['film_episode'];
			$list_episode = explode ( "\n", $episode_post );
			$count_ep = count ( $list_episode );
			for($i = 0; $i < $count_ep; $i ++) {
				$tap [$i] = explode ( '#', trim ( $list_episode [$i] ) );
				$ten_tap [$i] = trim ( $tap [$i] [0] );
				$link_tap [$i] = trim ( $tap [$i] [1] );
				$thu_tu [$i] = trim ( $tap [$i] [2] );
				if(($link_tap [$i]!='') && $ten_tap [$i] != '')FilmEpisodeNewEpisode($ten_tap [$i],$film_id,$_POST['episode_server'],$link_tap [$i],$thu_tu [$i],time());
			}
		}
		return "Cập nhật film meta thành công";
	}
	else return "Éo Cập nhật dc film meta";
}
function get_film_info_value($field,$value) {
	global $wpdb;
	if($field == 'post_name') $sql_where = " AND post_name = '".$value."'";
	elseif($field == 'ID') $sql_where = " AND ID = '".$value."'";
	$q = "SELECT ID, post_title, post_name 
			FROM ".DATA_POST." 
			WHERE post_type = 'film' 
			$sql_where";
	$r = $wpdb->get_row($q);
	if($r) {
		return array(
			'ID' 			=> $r->ID,
			'post_name' 	=> $r->post_name,
			'post_title' 	=> $r->post_title,
		);
	} else {
		return false;
	}
}
function clear_cached_play_page_via_film_id($film_id) {
	global $wpdb, $cache;
	$film_data = get_film_info_value('ID',$film_id);
	if($film_data != false) {
		$folder_film = 'film/';
	    $cache->clear("play_film_".$film_data['post_name'],$folder_film.'play');   
	}     
}

function get_excerpt_content($max_char = 55,$more_text = '', $printout = 1,$content = '') {
	if ($content == '')
		$content = get_the_content('');
		
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	$content = strip_tags($content);
	
	$words = explode(' ', $content, $max_char + 1);
	
	if (count($words) > $max_char) {
		array_pop($words);
		$content = implode(' ', $words);
		$content = $content . '...';
	}
	
	if ($more_text != '') $content = $content.' <a class="continuebox" href="'.get_permalink().'" title="Permanent Link to '.get_the_title().'">'.$more_text.'</a>';
	
	if ($printout==1)
		echo $content;
	else
		return $content;
}


function GetFilmToSelectBox ($filmId = '') {
	global $wpdb, $post;
	$q = "SELECT ID, post_title  
    FROM $wpdb->posts wposts 
    WHERE wposts.post_type = 'post' 
    AND wposts.post_status = 'publish' 
    ORDER BY ID DESC";
	$row = $wpdb->get_results($q);
	
	if ($row):
	$html .= "<select name='film_episode'><option value='0'>Vui lòng chọn phim</option>";
 	foreach ($row as $post):	
 		if ($post->ID == $filmId) $selected = "selected='selected'";
 		else $selected = '';
		$html .= "<option value='".$post->ID."' ".$selected.">".$post->post_title."</option>";
	endforeach;
	$html .= "</select>";
	else :
		$html .= "Không có phim nào - Vui lòng thêm phim mới trước khi thêm tập phim";
	endif;
	return $html;
}
function GetTrailerToSelectBox ($filmId = '') {
	global $wpdb, $post;
	$film_meta = get_film_meta($filmId);
	$q = "SELECT ID, post_title  
    FROM $wpdb->posts wposts 
    WHERE wposts.post_type = 'trailer' 
    AND wposts.post_status = 'publish' 
    ORDER BY ID DESC";
	$row = $wpdb->get_results($q);
	
	if ($row):
	$html .= "<select name='film_trailer'><option value='0'>Vui lòng chọn phim</option>";
 	foreach ($row as $post):	
 		if ($post->ID == $film_meta['film_trailer']) $selected = "selected='selected'";
 		else $selected = '';
		$html .= "<option value='".$post->ID."' ".$selected.">".$post->post_title."</option>";
	endforeach;
	$html .= "</select>";
	else :
		$html .= "Không có trailer nào.";
	endif;
	return $html;
}
function GetServerToSelectBox ($serverId = '') {
	global $wpdb, $post;
	$table_name= $wpdb->prefix . 'film_server';
	$q = "SELECT server_id, server_name  
    FROM $table_name  
    ORDER BY server_order ASC";
	$row = $wpdb->get_results($q);
	
	if ($row):
	$html .= "<select name='episode_server'>";
	$html .= "<option>Chọn sv</option>";
 	foreach ($row as $post):	
 		if ($post->server_id == $serverId) $selected = "selected='selected'";
 		else $selected = '';
		$html .=  "<option value='".$post->server_id."' ".$selected.">".$post->server_name."</option>";
	endforeach;
	$html .= "</select>";
	else :
		$html .=  "Không có server nào - Vui lòng thêm server mới trước khi thêm tập phim";
	endif;
	return $html;
}

function get_config_phimso() {
	$config = file_get_contents (  DOCUMENT_LIBRARY.'/config.phimso' );
	$arr = explode ( "\n", $config );
	if(md5($arr [0]) != '4a99af40a1023d09fbdd7e9df6a98947') {
		echo 'Design and code by nothingdngpt - admin@nothingdng.info - website: http://viet.pro';
		exit();
	}
	$month = explode ( ':', $arr [1] );
	$week = explode ( ':', $arr [2] );
	$day = explode ( ':', $arr [3] );
	return array ('current_month' => $month [1], 'current_week' => $week [1], 'current_day' => $day [1] );
}




/* nothingdngpt: general function */ 
function admin_pages($tt,$n,$link,$p){
	$pgt = $p-1;
	$html .= "<div class='tablenav'><div class='tablenav-pages'>Trang: ";
	if ($p<>1) $html.="<a class='prev page-numbers' href=$link title ='Xem trang đầu'><b>&laquo;&laquo;</b></a> <a class='prev page-numbers' href=$link&p=$pgt title='Xem trang trước'><b>&laquo;</b></a> ";
	for($l = 0; $l < $tt/$n; $l++) {
		$m = $l+1;
		if($m == $p) $html .= "<span class='page-numbers current'>$m</span> ";
		else $html .= "<a class='page-numbers' href=$link&p=$m title='Xem trang $m'>$m</a> ";
	}
	$pgs = $p+1;
	if ($p<>$m) $html.="<a class='next page-numbers' href=$link&p=$pgs title='Xem trang kế tiếp'><b>&raquo;</b></a> <a class='next page-numbers' href=$link&p=$m title='Xem trang cuối'><b>&raquo;&raquo;</b></a> ";
	$html .="</div></div>";
	return $html;
}
function un_htmlchars($str) {
	return str_replace ( array ('&lt;', '&gt;', '&quot;', '&amp;', '&#92;', '&#39;' ), array ('<', '>', '"', '&', chr ( 92 ), chr ( 39 ) ), $str );
}

function htmlchars($str) {
	return str_replace ( array ('\"','&', '<', '>', '"', chr ( 39 ) ), array ('"','&amp;', '&lt;', '&gt;', '&quot;', '&#39;' ), $str );
}
function mt_post($name) {
	if (isset ( $_POST ["$name"] )) {
		return addslashes($_POST ["$name"]);
	}
	return null;
}
function mt_get($name) {
	if (isset ( $_GET ["$name"] )) {
		return addslashes($_GET ["$name"]);
	}
	return null;
}
function show_success($str) {
	echo "<span class='success_box'>" . $str . "</span>";
}
function show_error($str) {
	echo "<span class='error_box'>" . $str . "</span>";
}
function getwords($str,$num)
{
	$limit = $num - 1 ;
    $str_tmp = '';
    //explode -- Split a string by string
    $arrstr = explode(" ", $str);
    if ( count($arrstr) <= $num ) { return $str; }
    if (!empty($arrstr))
    {
        for ( $j=0; $j< count($arrstr) ; $j++)    
        {
            $str_tmp .= " " . $arrstr[$j];
            if ($j == $limit) 
            {
                break;
            }
        }
    }
    return $str_tmp.'...';
}

function html2txt($document){
$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
               '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
               '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
               '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
);
$text = preg_replace($search, ' ', $document);
return $text;
}
function text(&$string) {	
    $string = trim($string);
	$string = str_replace("\\'","'",$string);
	$string = str_replace("'","''",$string);
	$string = str_replace('\"',"&quot;",$string);
	$string = str_replace("<", "&lt;", $string);
	$string = str_replace(">", "&gt;", $string);
	return $string;
}
function low_to_hight($string){
  $convert_from = array(
    "a", "c", "d", "g", "h", "j", "k", "l", "n", "p", "q", "r", "s", "t",
    "v", "x", "y");
  $convert_to = array(
    "A", "C", "D", "G", "H", "J", "K", "L", "N", "P", "Q", "R", "S", "T",
    "V", "X", "Y");
  return str_replace($convert_from, $convert_to, $string);
} 
function them_gach($str) {
	$c = str_split($str);
	for($i=0;$i<count($c);$i++) {
		$d .= $c[$i]."|";
	}
	return $d;
}


function encode_grap($str){
	$gkencode = new Gkencode();
	$secretKey = 'g0nfh3kj6hgjud4fpzmh';
	return $gkencode->encrypt($str,$secretKey);
}

function decode_grap($str)
{
	$arr[0] = "vp*".gkEncode($arr[0]);
	return ($str);
}

function resizeImg($img,$hsize) {
	if(strpos($img,'googleusercontent.com')) {
		$filename = basename($img);
		$newimg = str_replace($filename,'s'.$hsize.'/'.$filename,$img); 
		return $newimg;
	} else {
		return $img;
	}
}
function jwysiwyg(){
	echo '<link rel="stylesheet" href="'.TEMP_DIR.'/library/js/jwysiwyg/jquery.wysiwyg.css" type="text/css"/>
	<script type="text/javascript" src="'.TEMP_DIR.'/library/js/jwysiwyg/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="'.TEMP_DIR.'/library/js/jwysiwyg/controls/wysiwyg.image.js"></script>
	<script type="text/javascript" src="'.TEMP_DIR.'/library/js/jwysiwyg/controls/wysiwyg.link.js"></script>
	<script type="text/javascript" src="'.TEMP_DIR.'/library/js/jwysiwyg/controls/wysiwyg.table.js"></script>
		<script type="text/javascript">
		(function($) {
			$(document).ready(function() {
				$(".wysiwyg").wysiwyg();
			});
		})(jQuery);
		</script>';
}
?>

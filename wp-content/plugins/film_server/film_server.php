<?php
/*
Plugin Name: Phim - Server film
Plugin URI: http://alohot.net
Description: Cập nhật server graph phim cho theme alophim.
Author: nothingdng
Version: 1.0
Author URI: http://alohot.net
*/

add_action('admin_menu', 'FilmServerAddOpc'); 
register_activation_hook( __FILE__, 'FilmServerInstall' );
register_deactivation_hook (__FILE__, 'FilmServerUnInstall');



function FilmServerAddOpc(){   
      if (function_exists('add_options_page')) {
         add_options_page('Server phim', 'Server Phim', 8, basename(__FILE__), 'FilmServerMenu');
      }
   }

function FilmServerInstall(){
/* nothingdngpt : Creat table database */ 
	global $wpdb;
	 
	require_once(ABSPATH . 'wp-admin/upgrade-functions.php');

	
	$sql = " CREATE TABLE ".WP_FILM_SERVER."(
			`server_id` INT NOT NULL AUTO_INCREMENT,
			`server_name` VARCHAR( 100 ) NOT NULL ,
			`server_embed` TEXT NOT NULL ,
			`server_appendages` TEXT NOT NULL ,
			`server_grap` ENUM( 'YES', 'NO' ) NOT NULL DEFAULT 'YES',
			`server_order` INT NOT NULL DEFAULT '1'	,
			PRIMARY KEY ( `server_id` )
	) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = MYISAM ;";
	
	$wpdb->query($sql);

   }
   
function FilmServerUnInstall(){
	global $wpdb;	
	 
	require_once(ABSPATH . 'wp-admin/upgrade-functions.php');

	$sql = "DROP TABLE ".WP_FILM_SERVER;
	
	$wpdb->query($sql);
   
}

function FilmServerDeleteBD(){
	
	global $wpdb;	
	 
	require_once(ABSPATH . 'wp-admin/upgrade-functions.php');

	$sql = "DROP TABLE ".WP_FILM_SERVER;
	
	$wpdb->query($sql);
}

   
function FilmServerMenu(){  
	global $wpdb;	
	
	isset($_GET['acc']) ? $_acc=$_GET['acc']:$_acc="showServer";
	
	if($_POST['server_name']!=""){
		if($_POST['server_id']!=""){
			if(FilmServerUpdateServer($_POST['server_id'],$_POST['server_name'],htmlchars($_POST['server_embed']),htmlchars($_POST['server_appendages']),$_POST['server_grap'],$_POST['server_order']))
				echo '<div id="message" class="updated fade" style="background-color: rgb(255, 251, 204);"><b><br/>Cập nhật thành công!</b><br/><br/></div>';
			$_acc="showServer";
		}
		else{
			if(FilmServerNewServer($_POST['server_name'],htmlchars($_POST['server_embed']),htmlchars($_POST['server_appendages']),$_POST['server_grap'],$_POST['server_order']))
				echo '<div id="message" class="updated fade" style="background-color: rgb(255, 251, 204);"><b><br/>Thêm server mới thành công!</b><br/><br/></div>';
			else 
				echo '<div id="message" class="error fade" style="background-color: rgb(218, 79, 33);"><br/><b>Lỗi ! Server đã tồn tại</b><br/><br/></div>';
			$_acc="addServer";
		}
	}else{
		if($_GET['acc']=="del") {
			//FilmServerDeleteServer($_GET['server_id']); 
			echo '<br><div id="message" class="updated fade" style="background-color: rgb(255, 251, 204);"> <br/>Hiện tại không cho phép xóa server!<br/><br/></div>';
			$_acc="showServer";
		}
		else if($_GET['acc']=="delBD"){
			//FilmServerDeleteBD();
			echo '<br><div id="message" class="updated fade" style="background-color: rgb(255, 251, 204);"> <br/>Hiện tại không cho phép xóa DB server<br/><br/></div>';
			$_acc="dataBase";
		}
	}  
	
	
	
	

echo '<div class="wrap">
		<h2>Server Film Graph</h2>';
		
echo'<ul class="subsubsub">
		<li><a class="button" href="'.$PHP_SELF.'?page=film_server.php&acc=showServer">Danh sách server</a></li>
		<li><a class="button" href="'.$PHP_SELF.'?page=film_server.php&acc=addServer">Thêm server</a></li>
		<li><a class="button" href="'.$PHP_SELF.'?page=film_server.php&acc=dataBase">Database</a></li>
	</ul>
	<br/><br/>
	
	<script>
	function deleteLink(server_id){
		var opc = confirm("Bạn muốn xóa server này ?");
		if (opc==true) window.location.href="'.$PHP_SELF.'?page=film_server.php&acc=del&server_id="+server_id;
	}
	</script>
';  

if($_acc=="addServer"){

 if (FilmServerInfoDB()==false) {
		echo "<br/><b>Dữ liệu và database Server phim đã bị xóa</b>! Bạn cần active lại plugin trước khi thêm server mới.";
	  }
	  else{

echo '<h3>Thêm server</h3>

	<fieldset>

	<form method="post" action ="">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<label for="default_post_edit_rows"> Server name</label>
					</th>
					<td>
						<input type="text" name="server_name" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="default_post_edit_rows"> Embed</label>
					</th>
					<td>
						<textarea name="server_embed" style="width:500px; height:150px;"></textarea>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="default_post_edit_rows"> Server phụ hoặc text thông báo</label>
					</th>
					<td>
						<textarea name="server_appendages" style="width:500px; height:150px;"></textarea>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="default_post_edit_rows"> Server này có graph hay không (Chọn NO nếu play trực tiếp)</label>
					</th>
					<td>
						<select name="server_grap">
							<option value="YES">YES</option>
							<option value="NO">NO</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="default_post_edit_rows"> Thứ tự ưu tiên</label>
					</th>
					<td>
						<input type="text" name="server_order"/>
					</td>
				</tr>
			</tbody>
		</table>


		
		<p class="submit"><input type="submit" name="FilmServer" value="Thêm server" /></p>
	</form>
	</fieldset>';
	}
	}
	
	
	else if($_acc=="edit"){

 if (FilmServerInfoDB()==false) {
		echo "<br/><b>Dữ liệu và database Server phim đã bị xóa</b>! Bạn cần active lại plugin trước khi thêm hoặc sửa server mới.";
	  }
	  else{	  
	  $server_id = $_GET['server_id'];	
		$q = "select * from ".WP_FILM_SERVER." WHERE server_id = '".$server_id."'";
		$row = $wpdb->get_results($q);
		foreach($row as $r){
		  $server_name = $r->server_name;
		  $server_embed = $r->server_embed;
		  $server_appendages = $r->server_appendages;
		  $server_grap = $r->server_grap;
		  if($server_grap == 'YES') $check_graph = "checked='checked'";
		  else $un_check_graph = "checked='checked'";
		  $server_order = $r->server_order;

echo '<h3>Sửa server</h3>

	<fieldset>

	<form method="post" action ="">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<label for="default_post_edit_rows"> Server name</label>
					</th>
					<td>
						<input type="hidden" name="server_id" value="'.$server_id.'" />
						<input type="text" value="'.$server_name.'" name="server_name" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="default_post_edit_rows"> Embed</label>
					</th>
					<td>
						<textarea name="server_embed" style="width:500px; height:150px;">'.$server_embed.'</textarea>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="default_post_edit_rows"> Server phụ hoặc text thông báo</label>
					</th>
					<td>
						<textarea name="server_appendages" style="width:500px; height:150px;">'.$server_appendages.'</textarea>
					</td>
				</tr>				
				<tr valign="top">
					<th scope="row">
						<label for="default_post_edit_rows"> Server grap hay play trực tiếp</label>
					</th>
					<td>
						<select name="server_grap">
							<option value="YES" '.$check_graph.'>YES</option>
							<option value="NO" '.$un_check_graph.'>NO</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="default_post_edit_rows"> Thứ tự ưu tiên</label>
					</th>
					<td>
						<input type="text" name="server_order" value="'.$server_order.'"/>
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit"><input type="submit" name="FilmServer" value="Cập nhật" /></p>
	</form>
	</fieldset>';
	}
	}
	}
	
	else if($_acc=="showServer"){
	  
	   if (FilmServerInfoDB()==false) {
		echo "<br/><b>Dữ liệu và database Server phim đã bị xóa</b>! Bạn cần active lại plugin trước khi thêm hoặc sửa server mới.";
	  }
	  else{
	  
	 echo' 
	 <h3>Server graph</h3>
	 <table class="widefat">
		<thead>
			<tr>
				<th style="display:none" scope="col">Index</th>
				<th scope="col">Server Name</th>
				<th scope="col">Server Embed</th>
				<th scope="col">Server Phụ</th>
				<th scope="col">Graph</th>
				<th scope="col">Thứ tự ưu tiên (<a href="'.$PHP_SELF.'?page=film_server.php&acc=showServer&orderBy=server_order&order=asc">+</a>|<a href="'.$PHP_SELF.'?page=film_server.php&acc=showServer&orderBy=server_order&order=desc">-</a>)</th>
				<th scope="col">Edit</th>
				<th scope="col">Delete</th>
			</tr>
		</thead>
		<tbody id="the-comment-list" class="list:comment">
			<tr id="comment-1" class="">
				';
				if($_GET['orderBy']=="") $_GET['orderBy'] = "server_order";
				if($_GET['order']=="") $_GET['order'] = "asc";
				FilmServerGetServer($_GET['orderBy'],$_GET['order']);
				echo'
			</tr>
		</tbody>
		<tbody id="the-extra-comment-list" class="list:comment" style="display: none;"> </tbody>
		</table>

</div>';
}
}
else if($_acc=="dataBase"){
	  
	  if (FilmServerInfoDB()==false) {
		echo "<br/><b>Dữ liệu và database Server phim đã bị xóa</b>! Bạn cần active lại plugin trước khi thêm hoặc sửa server mới.";
	  }
	  else{
		  echo '<h3>Dữ liệu</h3>
		  Bạn không được phép xóa bất cứ server phim nào khi server đó đang có phim được graph. 
		  <b><a href="'.$PHP_SELF.'?page=film_server.php&acc=delBD">click here</a></b> and then desactivate it in plugins section.<br><br>';
	  }
   }
   
   }
   function FilmServerGetServer($orderBy="server_order",$order="desc"){
   
		global $wpdb;
		
		echo '<tbody id="the-comment-list" class="list:comment">
			';

		
				$q = "select * from ".WP_FILM_SERVER." order by ".$orderBy." ".$order;
				$row = $wpdb->get_results($q);

				foreach($row as $r){
					echo '<tr id="comment-1" class="">';
					echo '<td style="display:none">'; echo $r->server_id; echo'</td>';
					echo '<td>'; echo $r->server_name; echo'</td>';
					echo '<td>'; echo $r->server_embed; echo'</td>';
					echo '<td>'; echo $r->server_appendages; echo'</td>';
					echo '<td>'; echo $r->server_grap; echo'</td>';
					echo '<td>'; echo $r->server_order; echo'</td>';
					echo '<td><a href="'.$PHP_SELF.'?page=film_server.php&acc=edit&server_id='.$r->server_id.'">Edit</a></td>';
					echo '<td><a href="javascript:deleteLink('.$r->server_id.');">Delete</a></td>';	
					echo '</tr>';
				}
				
		echo '</tbody>';
   }

	
function FilmServerNewServer($server_name,$server_embed,$server_appendages,$server_grap,$server_order)
	{
		global $wpdb;


		$queryprev = "select `server_name` from ".WP_FILM_SERVER." where `server_name` = '$server_name'";
		$result = $wpdb->get_results($queryprev);

		if(count($result)>0) return false;
		
		$query = "INSERT INTO ".WP_FILM_SERVER." ( 
					`server_name`
					, `server_embed`
					, `server_appendages`
					,`server_grap`
					,`server_order` ) 
				VALUES 
					('".mysql_real_escape_string($server_name)."',
					'".$server_embed."',
					'".$server_appendages."',
					'".mysql_real_escape_string($server_grap)."',
					'".mysql_real_escape_string($server_order)."'
				)";
		$wpdb->query($query);
		return true;
	}
	
	function FilmServerUpdateServer($server_id,$server_name,$server_embed,$server_appendages,$server_grap,$server_order)
	{
		global $wpdb;
			
		$query = "UPDATE ".WP_FILM_SERVER." 
				set `server_name` = '".mysql_real_escape_string($server_name)."',
	         		`server_embed` = '".$server_embed."' ,
					`server_appendages` = '".$server_appendages."',
					`server_grap` = '".mysql_real_escape_string($server_grap)."',
					`server_order` = '".mysql_real_escape_string($server_order)."' 
				where server_id ='".mysql_real_escape_string($server_id)."' ";
		$wpdb->query($query);
		return true;
	}
	
function FilmServerInfoDB(){
	global $wpdb;
		
				
		($wpdb->get_var("SHOW TABLES LIKE '".WP_FILM_SERVER."'") != "") ? $back= true : $back= false;
		return $back;

}

function FilmServerDeleteServer($id){
	 global $wpdb;	 
	 
	require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
		
	$sql = "DELETE FROM ".WP_FILM_SERVER." where server_id = $id;";
	
	$wpdb->query($sql);

}
?>

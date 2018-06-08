<?php
define('DATA_POST', $wpdb->posts);
define('DATA_POSTMETA', $wpdb->prefix.'postmeta');
define('DATA_COMMENTS', $wpdb->prefix.'comments');
define('DATA_COMMENTMETA', $wpdb->prefix.'commentmeta');
define('DATA_TERMS', $wpdb->prefix.'terms');
define('DATA_TERM_TAXONOMY', $wpdb->prefix.'term_taxonomy');
define('DATA_TERM_RELATIONSHIPS', $wpdb->prefix.'term_relationships');
define('DATA_TERM_META', $wpdb->prefix.'term_meta');
define('DATA_FILM_EPISODE', $wpdb->prefix.'film_episode');
define('DATA_FILM_META', $wpdb->prefix.'film_meta');
define('DATA_FILM_SERVER', $wpdb->prefix.'film_server');
define('DATA_FILM_EPISODE', $wpdb->prefix.'film_episode');
register_sidebar(array(
 'name'=>'phimmoi',
 'id' => 'phimmoi',
 'description' => 'Phim moi',
 'before_widget' => '<div class="sidebar-block channel">',
 'after_widget'  => '<div class="clear-fix"></div> </div>',

));
register_sidebar(array(
 'name'=>'sidebar',
 'id' => 'sidebar',
 'description' => 'Top right Sidebar',
 'before_widget' => '<div id="%1$s" class="block">',
 'after_widget'  => '</div>',
 'before_title' => '<div class="title_bl"><h3>',
 'after_title' => '</h3></div>',
));
register_sidebar(array(
 'name'=>'hsidebar',
 'id' => 'hsidebar',
 'description' => 'Home Sidebar',
 'before_widget' => '<div class="sidebar-block sidebar-pri">',
 'after_widget'  => '</div>',
 'before_title' => '<h3 class="sidebar-block-title">',
 'after_title' => '</h3>',
));
register_sidebar(array(
 'name'=>'fsidebar',
 'id' => 'fsidebar',
 'description' => 'footer right Sidebar',
 'before_widget' => '<div class="block"><div class="blocktitle">
<div class="icon tag"></div>',
 'after_widget'  => '</div>',
 'before_title' => '<div class="title">',
 'after_title' => '</div>',
));
/********************************************************************
Category Widget
********************************************************************/
class cat extends WP_Widget {
	function cat() {
	//Constructor
		$widget_ops = array('classname' => '', 'description' => 'Category posts' );		
		$this->WP_Widget('widget_cat', 'Category Home', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$number = $instance['number'];
		echo $before_widget;
		
		?>
        <h3 class="sidebar-block-title"><a href="<?php echo get_category_link($category); ?>"><?php echo get_cat_name($category); ?></a></h3>
		<div style="margin-top:5px;"></div>			
<?php $feature = new WP_query('showposts='.$number.'&cat='.$category);  ?>
                <?php while ($feature->have_posts()) : $feature->the_post(); ?>
		<div class="content-item ">
		
		<div class="channel-img">
			<span class="status"><?php $id = get_the_ID();echo get_post_meta($id, "phim_tl", true);?></span>
			<div class="quality"><?php $id = get_the_ID();echo get_post_meta($id, "phim_hd", true);?></div>
			<a href="<?php the_permalink();?>" rel="<?php the_title();?>" class="screenshot img170" title="<?php excerpt('50');?>"  >
				<?php img2(150,190);?>
			</a>
		</div>
		<h2><a title="<?php the_title();?>" href="<?php the_permalink();?>"> <?php echo catchuoi(get_the_title(),20);?></a></h2>
		<p><span>Thể loại: <?php $cate=get_the_category($post->ID);foreach($cate as $cat) { echo $cat->name;} ?></span></p>
		<p><span>Lượt xem: <?php if(function_exists('the_views')) { the_views(); } ?></span></p>
	</div>
	
				<?php endwhile; //end first news ?>



<?php
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['category'] = ($new_instance['category']);
		$instance['number'] = strip_tags( $new_instance['number'] );		
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'post_number' => '', 'category' => '' ) );		
		$category = strip_tags($instance['category']);		
	?>
		<p><label for="<?php echo $this->get_field_id('category'); ?>">Select Category </label>      
        <select name="<?php echo $this->get_field_name('category'); ?>" id="<?php echo $this->get_field_id('category'); ?>" style="width:170px">
        <?php $categories = get_categories('hide_empty=1');
        foreach ($categories as $cat) {
        if ($category == $cat->cat_ID) { $selected = ' selected="selected"'; } else { $selected = ''; }
        $opt = '<option value="' . $cat->cat_ID . '"' . $selected . '>' . $cat->cat_name . '</option>';
        echo $opt; } ?>
        </select>
        </p>
			<p><label for="<?php echo $this->get_field_id('number'); ?>">Select number post:</label>
        <select name="<?php echo $this->get_field_name('number'); ?>" id="<?php echo $this->get_field_id('number'); ?>" style="width:50px">
			<option <?php if ( '0' == $instance['number'] ) echo ' selected="selected"'; ?>>0</option>
			<?php for($i=1;$i<9;$i++) { 
                if ($i == $instance['number']) {
                    echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
                } else {
                    echo '<option value="'.$i.'">'.$i.'</option>';
                }
                    
            } ?>
        </select> 
<?php
	}
}
register_widget('cat');
/********************************************************************
Magic Widget
********************************************************************/
class magic extends WP_Widget {
	function magic() {
	//Constructor
		$widget_ops = array('classname' => 'magic', 'description' => 'Magic Box widget' );		
		$this->WP_Widget('widget_magic', 'vPress Magic Box', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = apply_filters('widget_title', $instance['title'] );
		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$type = $instance['type'];
		$number = $instance['number'];
		echo $before_widget;
		if ( $title ){
			echo $before_title . $title . $after_title;}
		?>
        	<?php if($type =='photo'){ ?>
            	<div class="photo">
					<?php
                        $magic = new WP_query('showposts=1&cat='.$category); 
                        while ($magic->have_posts()) : $magic->the_post();
                    ?>
                    	<div class="img">
                        <h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
                        <?php img2(280,170) ?><br>
                        </div>
            		<?php  endwhile; ?>
                    <?php if ( $number !== '0' ) { ?>
                    <ul>
                    <?php $others = new WP_query('showposts='.$number.'&offset=1&cat='.$category) ?>
                    <?php while ($others->have_posts()) : $others->the_post();?>
                        <li>
                            <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                        </li>
                    <?php  endwhile;
					}?>
                    </ul>
              	</div>
        	<?php }else{ ?>
            	<div class="video">
					<?php
                        $magic = new WP_query('showposts=1&meta_key=video'); 
                        while ($magic->have_posts()) : $magic->the_post();
                    ?>
                    	<div>
                            <?php
							global $post;
							if( get_post_meta($post->ID, 'video', true)){ ?>
                            	<h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
                            	<embed width="300" height="250" src="<?php echo get_post_meta($post->ID, 'video', true) ?>"/>
                            <?php }else{ ?>
                            	<p>Bạn cần chọn chuyên mục mà bài viết có sử dụng custom field: video</p>
                            <?php } ?>
                       	</div>
            		<?php  endwhile; ?>
                    <?php if ( $number !== '0' ) { ?>
                    	<ul>
						<?php $others = new WP_query('showposts='.$number.'&offset=1&meta_key=video') ?>
                        <?php while ($others->have_posts()) : $others->the_post();?>
                            <li>
                                <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                            </li>
                        <?php  endwhile; ?>
                        </ul>
					<?php }?>
                    
              	</div>
            <?php }?>
		<?php
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['category'] = ($new_instance['category']);
		$instance['title'] = strip_tags( $new_instance['title'] );	
		$instance['type'] = strip_tags( $new_instance['type'] );
		$instance['number'] = strip_tags( $new_instance['number'] );
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$defaults = array( 'title' => __('Magic Box', 'genesis'),'number' => __('2', 'genesis'));
		$instance = wp_parse_args( (array) $instance, $defaults );
		$category = strip_tags($instance['category']);		
	?>
    	<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'genesis'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" />
		</p>
    	<p><label for="<?php echo $this->get_field_id('type'); ?>">Select type:</label>     
        <select name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>" style="width:170px">
            <option <?php if ( 'photo' == $instance['type'] ) echo ' selected="selected"'; ?>>photo</option>
            <option <?php if ( 'video' == $instance['type'] ) echo ' selected="selected"'; ?>>video</option>
        </select>   
        </p>  
		<p><label for="<?php echo $this->get_field_id('category'); ?>">Select Category        
        <select name="<?php echo $this->get_field_name('category'); ?>" id="<?php echo $this->get_field_id('category'); ?>" style="width:170px">
        <?php $categories = get_categories('hide_empty=1');
        foreach ($categories as $cat) {
        if ($category == $cat->cat_ID) { $selected = ' selected="selected"'; } else { $selected = ''; }
        $opt = '<option value="' . $cat->cat_ID . '"' . $selected . '>' . $cat->cat_name . '</option>';
        echo $opt; } ?>
        </select>
        </p>  
       
        <p><label for="<?php echo $this->get_field_id('number'); ?>">Select number post:</label>
        <select name="<?php echo $this->get_field_name('number'); ?>" id="<?php echo $this->get_field_id('number'); ?>" style="width:50px">
			<option <?php if ( '0' == $instance['number'] ) echo ' selected="selected"'; ?>>0</option>
			<?php for($i=1;$i<9;$i++) { 
                if ($i == $instance['number']) {
                    echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
                } else {
                    echo '<option value="'.$i.'">'.$i.'</option>';
                }
                    
            } ?>
        </select>   
<?php
	}
}
register_widget('magic');
function excerpt($num) {
	$link = get_permalink();
	$ending = get_option('wl_excerpt_ending');
	$limit = $num+1;
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	array_pop($excerpt);
	$excerpt = implode(" ",$excerpt).$ending;
	echo $excerpt;
	$readmore = get_option('wl_readmore_link');
	if($readmore!="") {
		$readmore = '<p class="readmore"><a href="'.$link.'">'.$readmore.'</a></p>';
		echo $readmore;
	}
}
function img2($width,$height) {
	global $post;
	$custom_field_value_2 = get_post_meta($post->ID, 'Image', true);
	$attachments = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'numberposts' => 1) );
	if(has_post_thumbnail()){
		$domsxe = simplexml_load_string(get_the_post_thumbnail($post->ID,'full'));
		$thumbnailsrc = $domsxe->attributes()->src;
		$img_url = parse_url($thumbnailsrc,PHP_URL_PATH);
	print '<img src="'.get_bloginfo('template_url').'/thumb.php?src='.$img_url.'&amp;w='.$width.'&amp;h='.$height.'&amp;q=100" alt="'.$post->post_title.'" title="'.$post->post_title.'" />';
	}
	elseif ($custom_field_value_2 == true) {
	print '<img src="'.$custom_field_value_2.'" width="'.$width.'" height="'.$height.'" alt="'.$post->post_title.'" title="'.$post->post_title.'" />';
	} 
	elseif ($attachments == true) {
		foreach($attachments as $id => $attachment) {
		$img = wp_get_attachment_image_src($id, 'full');
		$image = $image[0];
		$img_url = parse_url($img[0], PHP_URL_PATH);
		print '<img src="'.get_bloginfo('template_url').'/thumb.php?src='.$img_url.'&amp;w='.$width.'&amp;h='.$height.'&amp;q=70" alt="'.$post->post_title.'" title="'.$post->post_title.'" />';
		}
	}
	else {
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_img = $matches [1] [0];
		
		if($first_img){ 
			print '<img src="'.$first_img.'" width="'.$width.'" height="'.$height.'" alt="'.$post->post_title.'" title="'.$post->post_title.'" />';
		}
        else {
            print '<img src="http://rapphimviet.com/wp-content/uploads/2013/08/no-image.png" title="'.$post->post_title.'" alt="'.$post->post_title.'" width="'.$width.'" height="'.$height.'" />';
        }
	}
}
function img($width,$height) {
	global $post;
	$custom_field_value_2 = get_post_meta($post->ID, 'Image', true);
	$attachments = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'numberposts' => 1) );
	if(has_post_thumbnail()){
		$domsxe = simplexml_load_string(get_the_post_thumbnail($post->ID,'full'));
		$thumbnailsrc = $domsxe->attributes()->src;
		$img_url = parse_url($thumbnailsrc,PHP_URL_PATH);
	print get_bloginfo('template_url')."/thumb.php?src=$img_url&amp;w=$width&amp;h=$height&amp;q=100";
	}
	elseif ($custom_field_value_2 == true) {
	print $custom_field_value_2;
	} 
	elseif ($attachments == true) {
		foreach($attachments as $id => $attachment) {
		$img = wp_get_attachment_image_src($id, 'full');
		$image = $image[0];
		$img_url = parse_url($img[0], PHP_URL_PATH);
		print get_bloginfo('template_url')."/thumb.php?src=$img_url&amp;w=$width&amp;h=$height&amp;q=70";
		}
	}
	else {
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_img = $matches [1] [0];
		
		if($first_img){ 
			print "$first_img";
		}
        else {
            print "http://rapphimviet.com/wp-content/uploads/2013/08/no-image.png";
        }
	}
}

remove_action( 'wp_head', 'rel_canonical' );
add_action( 'wp_head', 'new_rel_canonical' );

function new_rel_canonical() {
     if ( !is_singular() )
          return;

      global $wp_the_query;
      if ( !$id = $wp_the_query->get_queried_object_id() )
          return;
		$ep=get_query_var('ep');
      $link = get_permalink( $id );
      
	  
	  if($ep==""){
	  echo "<link rel='canonical' href='$link' />\n";
	  }
      else{
	  echo "<link rel=\"canonical\" href=\"".$link."M".$ep."\"/>";
	  }
  }
function en_id($id) {
    $id = dechex($id + 241104185);
    $id = str_replace(1,'I',$id);
    $id = str_replace(2,'W',$id);
    $id = str_replace(3,'O',$id);
    $id = str_replace(4,'U',$id);
    $id = str_replace(5,'Z',$id); 
    return strtoupper($id);
}
function del_id($id) {
    $id = str_replace('Z',5,$id);
    $id = str_replace('U',4,$id);
    $id = str_replace('O',3,$id);
    $id = str_replace('W',2,$id);
	$id = str_replace('I',1,$id);
    $id = hexdec($id);
	$id = $id - 241104185;
    return strtoupper($id);
}
function catchuoi($chuoi,$gioihan){ 
    // nếu độ dài chuỗi nhỏ hơn hay bằng vị trí cắt 
    // thì không thay đổi chuỗi ban đầu 
    if(strlen($chuoi)<=$gioihan) 
    { 
        return $chuoi; 
    } 
    else{ 
        /*  
        so sánh vị trí cắt  
        với kí tự khoảng trắng đầu tiên trong chuỗi ban đầu tính từ vị trí cắt 
        nếu vị trí khoảng trắng lớn hơn 
        thì cắt chuỗi tại vị trí khoảng trắng đó 
        */ 
        if(strpos($chuoi," ",$gioihan) > $gioihan){ 
            $new_gioihan=strpos($chuoi," ",$gioihan); 
            $new_chuoi = substr($chuoi,0,$new_gioihan)."..."; 
            return $new_chuoi; 
        } 
        // trường hợp còn lại không ảnh hưởng tới kết quả 
        $new_chuoi = substr($chuoi,0,$gioihan)."..."; 
        return $new_chuoi; 
    } 
}


function new_brek() {
     if ( !is_singular() )
          return;

      global $wp_the_query;
      if ( !$id = $wp_the_query->get_queried_object_id() )
          return;
		$ep=get_query_var('ep');
      $name = get_the_title( $id );
      $tap =get_name($ep);
	  $link = get_permalink( $id );
	  
	  if($ep==""){
	  echo "$name";
	  }
      else{
	  echo "$name tập $tap";
	  }
  }
function new_title() {
     if ( !is_singular() )
          return;

      global $wp_the_query;
      if ( !$id = $wp_the_query->get_queried_object_id() )
          return;
		$ep=get_query_var('ep');
      $name = get_the_title( $id );
      $tap =get_name($ep);
	  
	  if($ep==""){
	  $title ="";
	  }
      else{
	  $title =" tập $tap";
	  }
	  return $title;
  }  
function new_desc() {
     if ( !is_singular() )
          return;

      global $wp_the_query;
      if ( !$id = $wp_the_query->get_queried_object_id() )
          return;
		$ep=get_query_var('ep');
      $name = get_the_title( $id );
      $tap =get_name($ep);
	  
	  if($ep==""){
	  $desc ="";
	  }
      else{
	  $desc =" $name tập $tap";
	  }
	  return $desc;
  }
function the_breadcrumb() {
		echo '';
	if (!is_home()) {
		echo '<div class="item" typeof="v:Breadcrumb"><a href="';
		echo get_option('home');
		echo '" rel="v:url" property="v:title">';
		echo 'Trang chủ';
		echo "</a></div>";
		if (is_category() || is_single()) {
			echo '';
			$categories = get_the_category();
$seperator = '';
$output = '';
if($categories){
	foreach($categories as $category) {
		$output .= '<div class="item" typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="'.get_category_link($category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a></div>'.$seperator;
	}
echo trim($output, $seperator);
}
echo '<h2 class="item last-child" typeof="v:Breadcrumb">';
			if (is_single()) {
			
				echo '<span itemprop="title">';
				new_brek();
				echo '</span>';
			}
		} elseif (is_page()) {
			echo '<div class="item" itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="">';
			echo the_title();
			echo '</div>';
		}
echo '</h2>';		
	}
	elseif (is_tag()) {single_tag_title();}
	elseif (is_day()) {echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';}
	elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'</li>';}
	elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'</li>';}
	elseif (is_author()) {echo"<li>Author Archive"; echo'</li>';}
	elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>';}
	elseif (is_search()) {echo"<li>Search Results"; echo'</li>';}
	echo '';
}
  require_once('function_func.php');
require_once('function_custom_type.php');  
include('priview.php');
define( 'DISALLOW_FILE_EDIT', true );
?>

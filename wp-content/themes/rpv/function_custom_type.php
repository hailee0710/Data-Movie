<?php
/* nothingdngpt : Custom menus */
add_theme_support('menus'); 
register_nav_menus(array(
	'top' => 'Top menu',
	'nav' => 'Nav menu',
	'footer' => 'Footer link'	
));
/* nothingdngpt : custom post thumbnail*/
add_theme_support('post-thumbnails');

//nếu bạn muốn chỉ dùng với post
add_theme_support('post-thumbnails', array('post'));
//Nếu bạn muốn chỉ dùng với page
//add_theme_support('post-thumbnails', array('page')); 



?>
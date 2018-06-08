<!DOCTYPE html>
<html lang="vi">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="1 days">
<link href="<?php bloginfo('template_directory');?>/css/style.css" type="text/css" rel="stylesheet" />
<script src="<?php bloginfo('template_directory');?>/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory');?>/js/light.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory');?>/js/rapphimviet.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory');?>/js/jwplayer.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory');?>/js/swfobject.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory');?>/js/alohot.js" type="text/javascript"></script>

<?php wp_head();?>
<meta name="google-site-verification" content="DmFiAYzlq-n4EBURnEHRZzquRLQnxOd9ai6jwzAvJvw" />
</head>
<body>
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<div id="fb-root"></div>
<script type="text/javascript">
    (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1&amp;appId=106049796202031";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<div id="wrapper">
<div id="header">
    <div class="container">
	<h1 id="logo">
            <a href="<?php bloginfo('siteurl');?>" title="Phim, Xem Phim Nhanh, Xem Phim Online chất lượng cao miễn phí">Xem phim</a>
	</h1>
            
        <div id="search">
            <form method="get" id="cse-search-box" name="search" action="<?php bloginfo('siteurl');?>/tim-kiem-phim">
                <input type="hidden" name="cx" value="016420794718014590513:WMX478417039"/>
                <input type="hidden" value="FORID:9" name="cof"/>
                <input type="hidden" value="UTF-8" name="ie"/>
                <input type="hidden" name="search_type" id="search_type" value="all" />
		<input type="text" name="q" placeholder="Từ khóa cần tìm..." class="keyword">
		<button type="submit" class="submit"></button>
            </form>
	</div>
    </div>
</div>
    
<div id="nav">
<?php $defaults = array(
	'theme_location'  => 'top',
	'menu'            => '', 
	'container'       => '', 
	'container_class' => '', 
	'container_id'    => '',
	'menu_class'      => '', 
	'menu_id'         => '',
	'echo'            => true,
	'fallback_cb'     => 'wp_page_menu',
	'items_wrap'      => '<ul id="%1$s" class="container menu">%3$s</ul>',
	'depth'           => 0,
	'walker'          => ''
); ?>
<?php wp_nav_menu( $defaults ); ?>
</div>

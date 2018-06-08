<?php get_header();?>

<div class="ad_location above_of_content container">
    <!--<img src="http://pagead2.googlesyndication.com/simgad/13079116716950328602" alt="Liên hệ quảng cáo"/>-->
</div>

<div id="body-wrap" class="container">
    <div id="content">
        <div id="movie-hot" class="viewport">
            <div class="prev"></div>

            <ul class="listfilm overview">
                <?php $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        query_posts('post_type=post&showposts=20&paged='.$page.'&order=desc');
                        while (have_posts()) : the_post(); ?>
                <li>
                    <a href="<?php the_permalink();?>" title="<?php the_title();?> - <?php echo get_post_meta($post->ID, "phim_en", true);?>">
                        <img alt="<?php the_title();?>" src="<? img(168,250);?>">
                    </a>
                    <div class="overlay">
                        <div class="name">
                            <a href="<?php the_permalink();?>" title="<?php the_title();?> - <?php echo get_post_meta($post->ID, "phim_en", true);?>"><?php the_title();?></a>
                                <?php echo get_post_meta($post->ID, "nsx", true);?>
                        </div>
                        <div class="name2"><?php echo get_post_meta($post->ID, "phim_en", true);?></div>
                    </div>
                    <div class="status"><?php echo get_post_meta($post->ID, "phim_hd", true);?></div>
                </li>
                <?php endwhile;?>
            </ul>
            
            <div class="next"></div>
            
        </div>
        <div class="divider"></div>
        <div class="block" id="movie-recommend">
            <div class="col1">
                <div class="blocktitle slide"><div class="icon movie1"></div><h2 class="title">BANNER QUẢNG CÁO</h2></div>
                <div class="blockbody">
                    <div style="display:block;height:250px;">
                        <?php include('ads/335x250.php');?>
                    </div>
                </div>
            </div>
            
            <div class="col2">
                <div class="blocktitle">
                    <div class="tabs" data-target="#phim-bo-hay">
                        <div class="tab active" data-name="phim-bo-moi">Phim đề cử</div>
                        <div class="tab" data-name="phim-bo-full">Phim bộ Đã hoàn thành</div>
                    </div>
                </div>
                
                <div class="blockbody" id="phim-bo-hay">
                    <ul class="list tab phim-bo-moi">
                        <?php $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        query_posts('post_type=post&meta_key=phim_tinhtrang&meta_value=phimdecu&showposts=10&paged='.$page.'&order=desc');
                        while (have_posts()) : the_post(); ?>
                        <li><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a><span><?php echo get_post_meta($post->ID, "phim_tl", true);?></span></li>
                        <?php endwhile;?>
                    </ul>
                    

                    <ul class="list tab phim-bo-full hide">
                        <?php $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        query_posts('post_type=post&meta_key=phim_tinhtrang&meta_value=hoanthanh&showposts=10&paged='.$page.'&order=desc');
                        while (have_posts()) : the_post(); ?>
                        <li><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a><span><?php echo get_post_meta($post->ID, "phim_tl", true);?></span></li>
                        <?php endwhile;?>
                    </ul>
                </div>
            
            </div>
        </div>
        
        <div class="divider"></div>
        
        <div class="block" id="movie-update">
            <div class="blocktitle">
                <div class="icon movie2"></div>
                <h2 class="title">Phim mới cập nhật</h2>
                <div class="types" data-target="#list-movie-update">
                    <div class="type"><span data-name="toan-bo" class="btn active">Toàn bộ</span></div>
                    <h3 class="type"><a data-name="phim-le" class="btn " href="danh-sach/phim-le/" title="Phim lẻ">Phim lẻ</a></h3>
                    <h3 class="type"><a data-name="phim-bo" class="btn" href="danh-sach/phim-bo/" title="Phim bộ">Phim bộ</a></h3>
                </div>
            </div>
            <div class="blockbody" id="list-movie-update">
                <div class="tab toan-bo">

                    <ul class="list-film tab toan-bo">
                        <?php $new = (get_query_var('paged')) ? get_query_var('paged') : 1;					
                        query_posts('post_type=post&showposts=20&paged='.$new);
                        while (have_posts()) : the_post(); ?>
                        <li><div class="inner"><a href="<?php the_permalink();?>" title="<?php the_title();?>"><img src="<?php img(146,195);?>" alt="<?php the_title();?>"></a><div class="info"><div class="name"><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a> </div><div class="name2"><?php echo get_post_meta($post->ID, "phim_en", true);?></div><div class="stats"></div></div><div class="status"><?php echo get_post_meta($post->ID, "phim_tl", true);?></div></div></li>
                        <?php endwhile;?>
                    </ul>
                </div>
                <div class="tab phim-le hide">
 
                    <ul class="list-film">
                        <?php $phimle = (get_query_var('paged')) ? get_query_var('paged') : 1;					
                        query_posts('post_type=post&showposts=20&meta_key=phim_loai&meta_value=phimle&paged='.$phimle);
                        while (have_posts()) : the_post(); ?> 
                        <li>
                            <div class="inner"><a href="<?php the_permalink();?>" title="<?php the_title();?>"><img src="<?php img(146,195);?>" alt="<?php the_title();?>"></a><div class="info"><div class="name"><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a> </div><div class="name2"><?php echo get_post_meta($post->ID, "phim_en", true);?></div><div class="stats"></div></div><div class="status"><?php echo get_post_meta($post->ID, "phim_tl", true);?></div></div></li>
                        <?php endwhile;?>
                    </ul>
                </div>
                
                <div class="tab phim-bo hide">
                    <ul class="list-film">
                        <?php $phimbo = (get_query_var('paged')) ? get_query_var('paged') : 1; $i=1;
                        query_posts('post_type=post&showposts=20&meta_key=phim_loai&meta_value=phimbo&paged='.$phimbo);
                        while (have_posts()) : the_post(); ?>
                        <li><div class="inner"><a href="<?php the_permalink();?>" title="<?php the_title();?>"><img src="<?php img(146,195);?>" alt="<?php the_title();?>"></a><div class="info"><div class="name"><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a> </div><div class="name2"><?php echo get_post_meta($post->ID, "phim_en", true);?></div><div class="stats"></div></div><div class="status"><?php echo get_post_meta($post->ID, "phim_tl", true);?></div></div></li>
                        <?php endwhile;?>
                    </ul>
                </div>
            </div>
        </div>
        <script type="text/javascript">Phim3s.Home.init();</script>
    </div>


<?php get_sidebar();?>
<?php get_footer();?>
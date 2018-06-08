<div class="info hreview-aggregate">

    <div class="poster">
        <img src="<?php img(300,400);?>" alt="<?php the_title();?> - <?php echo get_post_meta($post->ID, "phim_en", true); ?>" title="Phim <?php the_title();?>">
        <div class="like-stats">
            <span class="like-icon"></span>Lượt thích: <span class="votes"><?php if(function_exists('the_views')) { the_views(); } ?></span>
            <span class="rating"><span class="average">10</span>/<span class="best">10</span></span>
        </div>
    </div>
    
    <div class="col2">
        <h2 class="title fn">Phim <?php the_title();?></h2>
        <p style="padding-bottom: 10px; color: #666666;"><?php echo get_post_meta($post->ID, "phim_en", true); ?> (<?php echo get_post_meta($post->ID, "phim_nsx", true);?>)</p>
        <dl>
            <dt>Status:</dt>
            <dd class="red"><?php echo get_post_meta($post->ID, "phim_hd", true);?></dd>    
            <dt>Đạo diễn:</dt>
            <dd><?php echo get_post_meta($post->ID, "phim_dd", true);?></dd>
            <dt>Diễn viên:</dt>
            <dd><?php echo get_post_meta($post->ID, "phim_dv", true);?></dd>
            <dt>Thể loại:</dt>
            <dd><?php echo trim($output, $seperator);?></dd>
            <dt>Quốc gia:</dt>
            <dd><a href="<?php bloginfo('siteurl');?>/phim-<?php echo get_post_meta($post->ID, "phim_qg", true);?>" title="Phim <?php echo get_post_meta($post->ID, "phim_qg", true);?>"><?php echo get_post_meta($post->ID, "phim_qg", true);?></a></dd>
            <dt>Thời lượng:</dt>
            <dd><?php echo get_post_meta($post->ID, "phim_tl", true);?></dd>
            <!--<dt>Năm phát hành:</dt>
            <dd><?php //echo get_post_meta($post->ID, "phim_nsx", true);?></dd>-->
            <dt>Lượt xem:</dt>
            <dd><?php if(function_exists('the_views')) { the_views(); } ?></dd>
        </dl>
        
        <div class="btn-groups">
            <a href="<?php echo xemphim($idphim);?>" class="btn-watch"></a>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" title="Chia sẻ bộ phim này" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/facebook_share.png"></a>
        </div>
        

    </div>
</div>
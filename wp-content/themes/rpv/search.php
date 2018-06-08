<?php get_header();?>
<div id="media_0">
        <div class="block b" id="m">
        	<div class="title_bl p">
            	<s></s><?php the_breadcrumb(); ?>
            </div>
<div class="title_bl"><h1 class="seo"><?php echo get_cat_name($cat);?></h1></div>            
            <div class="content">


            <ul class="movies n_list">
				<?php $i=1; while (have_posts()) : the_post(); ?>
					<?php if($i%4==1 || $i==1)	{$class='class="f"';} else $class="";?>
			            	<li <?php echo $class;?>>
                	<div class="cover"><a href="<?php the_permalink();?>"><img width="120" height="160" src="<?php img(120,160);?>" alt="<?php the_title();?>"></a></div>
                    <div class="dt"><span><?php echo get_post_meta($post->ID, "phim_tl", true);?></span><?php echo get_post_meta($post->ID, "phim_nsx", true);?></div>
                    
					<div class="title">
                    	<h2><a href="<?php the_permalink();?>" title="<?php the_title();?> - <?php echo get_post_meta($post->ID, "phim_en", true);?>"><?php the_title();?></a></h2>
                        <p><?php the_title();?></p>
                    </div>
                    
                    
                    <div class="m-box">
                    	<div class="m-box-ct">
                    	<h2><?php the_title();?> - <?php echo get_post_meta($post->ID, "phim_en", true);?></h2>
                        <p>Năm sản xuất: <span><?php echo get_post_meta($post->ID, "phim_en", true);?></span></p>
                        
                        <p>Quốc gia: <span><?php echo get_post_meta($post->ID, "phim_qg", true);?></span></p>
                        <p>Nội dung: <strong><?php excerpt('100');?></strong></p>
						</div>
                    </div>
                </li>
			    <?php $i++;endwhile;?>        	
			            </ul>
            <div class="clear"></div>
            <?php wp_pagenavi(); ?>

            </div>
	</div>
			
</div>
    </div>
    <?php get_sidebar();?>
    <div class="clear"></div>
</div>
<?php get_footer();?>
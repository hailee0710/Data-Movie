<?php
/*
Template Name: Quốc gia
*/
?>
<?php $qg=get_the_title(); ?>
<?php get_header();?>
<div id="nav2">
    <div class="container">
        <h1 class="title">Dach sách phim <?php the_title();?></h1>
    </div>
</div>

<div class="ad_location above_of_content container">
    <center>ads here</center>
</div>

<div id="body-wrap" class="container">
    <div id="content">
        <div class="block" id="page-list">

            <div class="blocktitle breadcrumbs"><?php the_breadcrumb();?></div>

            <div class="blockbody">

                <ul class="list-film">
                    <?php $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    query_posts('post_type=post&showposts=32&meta_key=phim_qg&meta_value='.$qg.'&paged='.$page);
                    while (have_posts()) : the_post(); ?>
                    <li>
                        <div class="inner">
                            <a href="<?php the_permalink();?>" title="<?php the_title();?> - <?php echo get_post_meta($post->ID, "phim_en", true);?>"><img src="<?php img(146,195);?>" alt="<?php the_title();?> - <?php echo get_post_meta($post->ID, "phim_en", true);?>" /></a>
                            <div class="info">
                                <div class="name">
                                    <a href="<?php the_permalink();?>" title="<?php the_title();?> - <?php echo get_post_meta($post->ID, "phim_en", true);?>"><?php the_title();?></a>
                                        <?php echo get_post_meta($post->ID, "phim_nsx", true);?>
                                </div>
                                <div class="name2"><?php echo get_post_meta($post->ID, "phim_en", true);?></div>
                                <div class="stats"><span class="liked"></span></div>
                            </div>
                            <div class="status"><?php echo get_post_meta($post->ID, "phim_tl", true);?></div>
                        </div>
                    </li>
                    <?php endwhile;?>	
                </ul>
                <div><?php wp_pagenavi(); ?></div>
            </div>
        </div>
    </div>
<?php get_sidebar();?>
<?php get_footer();?>
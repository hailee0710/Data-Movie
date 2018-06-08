<div id="sidebar">
    <div class="block" id="chart">
        <div class="blocktitle">
            <div class="tabs" data-target="#topview">
                <div class="tab active" data-name="topviewday">Ngày</div>
                <div class="tab" data-name="topviewweek">Tuần</div>
                <div class="tab" data-name="topviewmonth">Tháng</div>
            </div>
        </div>

        <div class="blockbody" id="topview">
            <ul class="tab topviewday">
                <?php $new = (get_query_var('paged')) ? get_query_var('paged') : 1; $i=1;
                query_posts('post_type=post&showposts=10&paged='.$new);
                while (have_posts()) : the_post(); ?>
                <?php if($i==1 || $i==2 || $i==3){$class='class="st top"';} else $class='class="st"'; ?>
                <li>
                    <span <?php echo $class;?>><?php echo $i;?></span>
                    <div class="detail">
                        <div class="name">
                            <a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a>
                        </div>
                        <div class="views">Lượt xem <?php if(function_exists('the_views')) { the_views(); } ?></div>
                    </div>
                </li>
                <?php $i++; endwhile; ?>
            </ul>

            <ul class="tab topviewweek hide">
                <?php $i=1; $week = date('W'); $year = date('Y');					
                query_posts('post_type=post&posts_per_page=10&year='.$year.'&w='.$week.'&orderby=comment_count&order=DESC'); 
                while (have_posts()) : the_post(); ?>
                <?php if($i==1 || $i==2 || $i==3) {$class='class="st top"';} else $class='class="st"'; ?>
                <li>
                    <span <?php echo $class;?>><?php echo $i;?></span>
                    <div class="detail">
                        <div class="name">
                            <a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a>
                        </div>
                        <div class="views">Lượt xem <?php if(function_exists('the_views')) { the_views(); } ?></div>
                    </div>
                </li>
                <?php $i++; endwhile; ?>
            </ul>
            
            <ul class="tab topviewmonth hide">
                <?php $month = date('m'); $year = date('Y'); $i=1;					
                query_posts('post_type=post&posts_per_page=10&orderby=comment_count&order=DESC&year='.$year.'&monthnum='.$month);										
                while (have_posts()) : the_post(); ?>
                <?php if($i==1 || $i==2 || $i==3) {$class='class="st top"';} else $class='class="st"'; ?>
                <li>
                    <span <?php echo $class; ?>><?php echo $i; ?></span>
                    <div class="detail">
                        <div class="name">
                            <a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a>
                        </div>
                        <div class="views">Lượt xem <?php if(function_exists('the_views')) { the_views(); } ?></div>
                    </div>
                </li>
                <?php $i++; endwhile; ?>
            </ul>

        </div>
    </div>
    <div class="divider"></div>
<?php if ( ! dynamic_sidebar( 'fsidebar' ) ) : ?><?php endif;?>
</div>
</div>


</div>
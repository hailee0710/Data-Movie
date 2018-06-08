<div id="movie" class="block">

    <!--<div class="ad_location above_of_player">
        <a rel="nofollow" target="_blank" href="http://goo.gl/Yjju8">
            <img alt="" src="http://phim3s.net/ad/2s/bach_680x90.gif">
        </a>
    </div>-->
    
    <div class="blockbody">
        <div id="media">
            <?php echo getlinkphim($idphim,$idtap);?>
        </div>
    </div>
</div>

<div id="movie-info" class="block">
    <div class="blockbody">
        <div class="action">
    <div class="add-bookmark"><!--<i></i>Thêm vào hộp--> <fb:like href="<?php the_permalink(); ?>" layout="button_count" show_faces="false" send="false"></fb:like></div>
            <!--<div class="like"><i></i><span>Like phim</span></div>-->
            <div class="remove-ad">Tắt quảng cáo</div>
            <!--<div title="Chức năng tự động chuyển tập tiếp theo khi xem hết 1 tập" class="auto-next">AutoNext: On</div>-->
            <div class="resize-player">Phóng to</div>
            <div class="turn-light"><i></i><span>Tắt đèn</span></div>
        </div>

        <div class="ad_location below_of_player">
            <div align="center">
                <a rel="nofollow" target="_blank" href="#">
                    ads here
                </a>
            </div>
        </div>

        <div class="note">
            <ul>
                <li style="color:#4F6FC2">Chuc cac ban xem phim vui ve</li>
            </ul>
        </div>

        <?php echo episode_show($idphim);?>

    </div>
</div>

<div id="comment" class="block">
    <div class="blocktitle">
        <div class="title">Bình luận</div>
        <div data-target="#comment .tabs-content" class="tabs">
            <div data-name="fb-comment" class="tab active">Facebook</div>
        </div>
    </div>
    <div class="blockbody tabs-content">
        <div class="tab fb-comment">
            <div class="fb-comments" data-href="<?php the_permalink() ;?>" data-num-posts="15" data-width="670"></div>
        </div>
    </div>
</div>

<script type="text/javascript">function setActive(){aObj=document.getElementById("servers").getElementsByTagName("a");for(i=0;i<aObj.length;i++)0<=document.location.href.indexOf(aObj[i].href)&&(aObj[i].className="active")}window.onload=setActive;</script>	
<script type="text/javascript">Phim3s.Watch.init('<?php echo $post->ID;?>');</script>
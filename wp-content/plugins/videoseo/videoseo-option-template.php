<?php
$blog_url = get_bloginfo('url');
global $videoseo;
$x = WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
$nonce = wp_create_nonce('helloworld');

?>
<?php
$nextTime = getdate(wp_next_scheduled('my_hourly_event'));
$currentTime = getdate();
$lastran = get_option("videoseowtf");
?>

<div class='wrap'>
    <div id="icon-tools" class="icon32"></div>
    <h2>Video SEO Settings</h2>
    <div class="updated fade">
        <p><strong>Video SEO Pro</strong> extends all the great features the free version includes, and fully supports YouTube, DailyMotion, MetaCafe, MLSP, MySpace, Veoh, Viddler, Custom Players using mov, flv, f4v, mp4, m4v formats, Adds support for videos embedded by shortcodes with plugins like Viper Video Quicktags plugin, Automatically generates the video-sitemap.xml daily and pings google to register the update,  set the default video image overall and on a per post basis. <a href="http://www.creativemodules.com">Learn more here...</a></p>
    </div>
    <div style="width: 200px;float: right;">
        <a target="_blank" href="http://www.creativemodules.com"><img src="<?php echo $x ?>images/brandupsell.png" alt=""></a>
        <div style="margin-top: 20px;"><a target="_blank" href="http://tribepro.com?afid=bbc7af4b-8f84-4ede-9cc7-9f52e218a707"><img src="<?php echo $x ?>images/tpbrandupsell.png" alt=""></a></div>
    </div>



    <h3>Last generation time: <?php echo $videoseo->last_generate_time == null ? '<span class="attention">never</span>'
            : $videoseo->last_generate_time[weekday] . ', ' . $videoseo->last_generate_time[month] . ' ' . $videoseo->last_generate_time[mday] . ', ' . $videoseo->last_generate_time[year] . '  ' . $videoseo->last_generate_time[hours] . ':' . $videoseo->last_generate_time[minutes] . ':' . $videoseo->last_generate_time[seconds]; ?></h3>
    <a id="generate-video-sitemap" href="#" class="button-secondary">Regenerate Sitemap</a><span
        id="sitemap-generating" style="margin-left:10px;display: none;"><img
        src="<?php echo $x ?>images/ajax-loader.gif" alt=""/></span><br>
    <?php if ($videoseo->last_generate_time != null) { ?><br>You can review your video sitemap here: <a
        href="<?php echo content_url() ?>/uploads/sitemap-video.xml"><?php echo content_url() ?>
    /uploads/sitemap-video.xml</a><?php } ?><br>
    Relative url is: <code>/uploads/sitemap-video.xml</code>
    <br>
    <hr>
    <h4><i>Instructions:</i></h4>
    <ol>
        <li>Generate video sitemap by clicking the "Regenerate Sitemap" button.
        </li>
        <li>Register your video-sitemap.xml with:
            <p>
            <ul>
                <li><a target="_blank" href="https://www.google.com/webmasters/tools/home?hl=en">Google Webmaster
                    Tools</a></li>
                <li><a target="_blank" href="http://www.bing.com/toolbox/webmaster/">Bing Webmaster Central</a></li>
                </ul>
                </p>
                </li>
        <li>Add sitemap to robots.txt (optional but recommended)</li>
        <li>Done.</li>
    </ol>
</div>
<script type='text/javascript'>
    jQuery(document).ready(function() {
        jQuery('#generate-video-sitemap').click(function() {
            jQuery.ajax({
                type: "post",url: "admin-ajax.php",data: { action: 'gethello', _ajax_nonce: '<?php echo $nonce; ?>' },
                beforeSend: function() {
                    jQuery("#sitemap-generating").show();
                }, //show loading just when link is clicked
                complete: function() {
                    jQuery("#sitemap-generating").hide();
                }, //stop showing loading when the process is complete
                success: function(html) { //so, if data is retrieved, store it in html
                    location.reload();
                }
            }); //close jQuery.ajax(

        });
        jQuery('#ping-video-sitemap').click(function() {
            jQuery.ajax({
                type: "post",url: "admin-ajax.php",data: { action: 'gethello', _ajax_nonce: '<?php echo $nonce; ?>' },
                beforeSend: function() {
                    jQuery("#ping-sitemap-generating").show();
                }, //show loading just when link is clicked
                complete: function() {
                    jQuery("#ping-sitemap-generating").hide();
                }, //stop showing loading when the process is complete
                success: function(html) { //so, if data is retrieved, store it in html
                    location.reload();
                }
            }); //close jQuery.ajax(

        });
        jQuery('#upload_image_button').click(function() {
            formfield = jQuery('#upload_image').attr('name');
            tb_show('', 'media-upload.php?type=image&TB_iframe=true');
            return false;
        });

        window.send_to_editor = function(html) {
            imgurl = jQuery('img', html).attr('src');
            jQuery('#upload_image').val(imgurl);
            jQuery('#videoseo-default-image').attr("src",imgurl);
            tb_remove();
        }

    })
</script>


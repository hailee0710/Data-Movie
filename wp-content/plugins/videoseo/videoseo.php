<?php
/*
Plugin Name: Video SEO
Plugin URI: http://www.creativemodules.com
Description: Video SEO will generate a special video XML sitemap which will help search engines to better index this videos on your blog and increase your rankings.
Version: 1.0
Author: http://www.creativemodules.com
Author URI: http://www.creativemodules.com

*/
static $VIDEO_SEO_ID = 'videoseo';

require(dirname(__FILE__) . '/includes/YouTubeVL.php');

add_action('admin_menu', 'videoseo_menu');
register_activation_hook(__FILE__,'set_videoseo_options');
register_deactivation_hook(__FILE__,'unset_videoseo_options');


function videoseo_menu()
{
    add_options_page('Video SEO Options', 'Video SEO', 'manage_options', $VIDEO_SEO_ID, 'videoseo_plugin_options');
}

function set_videoseo_options(){
    add_option('videoseo_last_generate_time', null);
    add_option('videoseo_last_ping_time', null);

}
function unset_videoseo_options(){
    delete_option('videoseo_last_generate_time');
    delete_option('videoseo_last_ping_time');
}

function videoseo_plugin_options()
{
    $cdir = WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
    include('videoseo-option-template.php');

}

class videoseo
{
    public $last_generate_time;
    public $last_ping_time;
    public $majick;
    public $last_majick;
    public $majick_counter;
    public $automate_sitemap;
    public $automate_ping;
    public $membership_email;
    public $default_image;
    const MAX_VALIDATE_COUNT = 3;
    
    const PLUGIN_NAME = 'videoseo';
    const PLUGIN_VERSION = '1.0';

    function init(){
        $this->get_options();
    }
    function get_options(){
        $this->last_generate_time = get_option('videoseo_last_generate_time');
    }
    function update_options(){
        update_option('videoseo_last_generate_time', $this->last_generate_time);
    }
    function generate_sitemap()
    {
        check_ajax_referer("helloworld");
        $st = $this->videoseo_sitemap_loop();
        if (!$st) {
            echo '<br /><div class="error"><h2>Not Generated</h2><p>Doesn\'t look like any of your posts contain videos.</p></div>';
            exit();
        }else{
            $this->last_generate_time = getdate();
            $this->update_options();
        }
        ?>Generated successfully! <a href="<?php echo content_url() ?>/uploads/sitemap-video.xml">Click here to view
        your video sitemap.</a><?php
        die();
    }

    function initVideoLookUps()
    {
        $vl = array();
        $vl[0] = new YouTubeVL();
        return ($vl);
    }
    function videoseo_sitemap_loop()
    {
        $videoLookUps = $this->initVideoLookups();
        $my_query = new WP_Query(array('post_status' => 'publish', 'posts_per_page' => '-1') );

        if ( !$my_query->have_posts() ) {
            return false;
        }else{
            $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $xml .= '<!-- Created by VideoSEO sitemap -->' . "\n";
            $xml .= '<!-- Generated-on="' . date("F j, Y, g:i a") . '" -->' . "\n";
            $xml .= '<?xml-stylesheet type="text/xsl" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/videoseo/videoseo.xsl"?>' . "\n";
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">' . "\n";

            VideoLookup::resetProcessedPosts();
            while ( $my_query->have_posts() ) {
                $my_query->the_post();
                the_title();
                echo '<br>';
                foreach ($videoLookUps as $vl) {
                    $xml = $vl->appendXml($xml, get_the_content(), get_the_ID());
                }
                //echo the_content();
            }

            $xml .= "\n</urlset>";

        }
        wp_reset_postdata();

        $upload_dir = wp_upload_dir();
        $video_sitemap_url = $upload_dir['basedir'] . '/sitemap-video.xml';
        if ($this->IsVideoSitemapWritable($video_sitemap_url)) {
            if (file_put_contents($video_sitemap_url, $xml)) {
                return true;
            }
        }
        echo '<br /><div class="wrap"><h2>Error writing the file</h2><p>The XML sitemap was generated successfully but the  plugin was unable to save the xml to your WordPress root folder at <strong>' . $_SERVER["DOCUMENT_ROOT"] . '</strong> probably because the folder doesn\'t have appropriate <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank">write permissions</a>.</p><p>You can however manually copy-paste the following text into a file and save it as video-sitemap.xml in your WordPress uploads folder. </p><br /><textarea rows="30" cols="150" style="font-family:verdana; font-size:11px;color:#666;background-color:#f9f9f9;padding:5px;margin:5px">' . $xml . '</textarea></div>';
        exit();
    }
    function activate(){
        $this->update_options();
    }
    function deactivate(){
    }
    function IsVideoSitemapWritable($filename)
    {
        //can we write?
        if (!is_writable($filename)) {
            //no we can't.
            if (!@chmod($filename, 0666)) {
                $pathtofilename = dirname($filename);
                //Lets check if parent directory is writable.
                if (!is_writable($pathtofilename)) {
                    //it's not writeable too.
                    if (!@chmod($pathtofilename, 0666)) {
                        //darn couldn't fix up parrent directory this hosting is foobar.
                        //Lets error because of the permissions problems.
                        return false;
                    }
                }
            }
        }
        //we can write, return 1/true/happy dance.
        return true;
    }

}

$videoseo = new videoseo();
$videoseo->init();



add_action('wp_ajax_gethello', array($videoseo, 'generate_sitemap'));
register_activation_hook(__FILE__, array($videoseo, 'activate'));
register_deactivation_hook(__FILE__, array($videoseo, 'deactivate'));

?>
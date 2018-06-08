<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rgauny
 * Date: 11/18/11
 * Time: 11:41 AM
 * To change this template use File | Settings | File Templates.
 */

abstract class VideoLookup
{
    static  $processed_posts = array();
    static  $default_thumbnail = "";

    abstract public function getMatches($post);

    abstract public function getThumbnailUrl($match);

    abstract public function getPlayerLocUrl($match);
    abstract public function getID($match);
    public static function resetProcessedPosts(){
        VideoLookup::$processed_posts = array();
    }
    public static function setDefaultThumbnail($nthumb){
        if($nthumb && $nthumb!=""){
            VideoLookup::$default_thumbnail = $nthumb;
        }
    }
    public static function getDefaultThumbnail(){
        $thumb = WP_PLUGIN_URL . '/videoseo/images/click-to-play.png';
        if(VideoLookup::$default_thumbnail!="")
             $thumb = VideoLookup::$default_thumbnail;
        return($thumb);
    }
    public function appendXml($xml, $content, $postId)
    {
        try{

            $matches = $this->getMatches($content);
            if ($matches) {
                $post = get_post($postId);
                $excerpt = ($post->post_excerpt != "") ? $post->post_excerpt : $post->post_title;
                $permalink = get_permalink($post->id);
                foreach ($matches as $match) {
                    try{
                        $id = $this->getID($match);
                        if (in_array($permalink, VideoLookup::$processed_posts) || $permalink=="")
                                    continue;
                        array_push(VideoLookup::$processed_posts, $permalink);
                        $txml = "";
                        $txml .= "\n <url>\n";
                        $txml .= " <loc>$permalink</loc>\n";
                        $txml .= " <video:video>\n";
                        $txml .= "  <video:player_loc allow_embed=\"yes\" autoplay=\"autoplay=1\">" . $this->getPlayerLocUrl($match) . "</video:player_loc>\n";
                        $thumbnail = $this->getThumbnailUrl($match);
                        $postCustomThumb = get_post_custom_values("videoseo-thumbnail", $postId);
                        if(count($postCustomThumb)>0){
                            $thumbnail = $postCustomThumb[0];
                        }

                        $txml .= "  <video:thumbnail_loc>" . $thumbnail . "</video:thumbnail_loc>\n";
                        $txml .= "  <video:title>" . htmlspecialchars($post->post_title) . "</video:title>\n";
                        $txml .= "  <video:description>" . htmlspecialchars($excerpt) . "</video:description>\n";
                        $txml .= "  <video:publication_date>" . date(DATE_W3C, strtotime($post->post_date_gmt)) . "</video:publication_date>\n";

                        $posttags = get_the_tags($post->id);
                        if ($posttags) {
                            $tagcount = 0;
                            foreach ($posttags as $tag) {
                                if ($tagcount++ > 32) break;
                                $txml .= "   <video:tag>$tag->name</video:tag>\n";
                            }
                        }

                        $postcats = get_the_category($post->id);
                        if ($postcats) {
                            foreach ($postcats as $category) {
                                $txml .= "   <video:category>$category->name</video:category>\n";
                                break;
                            }
                        }
                        $txml .= " </video:video>\n </url>";
                        $xml .= $txml;

                    }catch(Exception $ex){
                        echo $ex;
                    }
                }
            }

        }catch(Exception $ex){
            echo $ex;
        }
        return ($xml);
    }
}

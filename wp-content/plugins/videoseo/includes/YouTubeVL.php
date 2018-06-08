<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rgauny
 * Date: 11/18/11
 * Time: 11:44 AM
 * To change this template use File | Settings | File Templates.
 */

require_once( dirname(__FILE__).'/VideoLookup.php' );
class YouTubeVL extends VideoLookup{

    public function getMatches($content)
    {
        if(preg_match_all ("/youtube.com\/(v\/|watch\?v=|embed\/)([a-zA-Z0-9\-_]*)/", $content, $matches, PREG_SET_ORDER)){
            return($matches);
        }
        return(null);
    }
    public function getID($match){
        return($match [2]);
    }

    public function getThumbnailUrl($match)
    {
        $id = $match [2];
        return('http://i.ytimg.com/vi/'.$id.'/2.jpg');
    }
    public function getPlayerLocUrl($match)
    {
        $id = $match [2];
        return('http://www.youtube.com/v/'.$id);
    }
}

<?php
function get_youtube_title($ref) {
    //$url = 'http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=' . $ref . '&format=json';
    //$url = 'https://www.youtube.com/watch?v=' . $ref . '&format=json';

    $url = "https://www.youtube.com/oembed?url=https://youtu.be/".$ref."&format=json";

    echo $url;

    $json = file_get_contents($url); //get JSON video details
    $details = json_decode($json, true); //parse the JSON into an array
    return $details['title']; //return the video title
}



function YoutubeVideoInfo($video_id, $key) {

    $url = 'https://www.googleapis.com/youtube/v3/videos?id='.$video_id.'&key='.$key.'&part=snippet,contentDetails';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response);
    //print_t($response_a); if you want to get all video details

    $contentDetails = $response_a->items[0]->contentDetails; //->duration; //get video duaration
    $snippet = $response_a->items[0]->snippet; //->duration; //get video duaration

    $duration = $contentDetails->duration;
    $title = $snippet->title;

    $duration = $duration;
    $title = $title;

    echo '<link itemprop="url" href="ссылка на видео-ролик"/>';
    echo '<meta itemprop="name" content="'.$title.'"/>';
    echo '<meta itemprop="duration" content="'.$duration.'"/>';
}


if (($fp = fopen("inlinks.csv", "r")) !== FALSE) {
    $count = 0;

    while (($data = fgetcsv($fp, 0, ";")) !== FALSE) {
        if($count != 0) {
            $str = $data[0];
            $array = explode(",", $str);
            $to = str_replace("\"", "", $array[2]);

            $to = str_replace("https://www.youtube.com/embed/", "", $to);
            $to = str_replace("http://www.youtube.com/embed/", "", $to);
            $to = str_replace("https://img.youtube.com/vi/", "", $to);

            $to = strtok($to,'?');
            $to = strtok($to,'/');

            $video_id = $to;
            echo $video_id;
            echo '<br>';
        }
        ++$count;
    }
    fclose($fp);
    //print_r($list);

    echo '</br> count:'.($count-1);
}


//passing youtube videoId to function
YoutubeVideoInfo('0ncKjicVBWk', "AIzaSyBLvS0_qXqYfuWo360syVrUJiaolS1oSA0");


function getDuration($url){
    parse_str(parse_url($url,PHP_URL_QUERY),$arr);
    $video_id=$arr['v'];
    $data=@file_get_contents('http://gdata.youtube.com/feeds/api/videos/'.$video_id.'?v=2&alt=jsonc');
    if (false===$data) return false;
    $obj=json_decode($data);
    return $obj->data->duration;
}
//echo getDuration('http://www.youtube.com/watch?v=0ncKjicVBWk');


function get_ydata_ref($ref) {
    $url = "https://www.youtube.com/oembed?url=https://youtu.be/".$ref."&format=json";

    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

//get_ydata_ref("0ncKjicVBWk");



//echo get_youtube_title("0ncKjicVBWk");

function parse2($video_id)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://youtube.com/get_video_info?video_id=" . $video_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    echo $response;
    curl_close($ch);
}

//parse2("0ncKjicVBWk");

function parse3($video_id){

    $html = file_get_contents('https://www.youtube.com/watch?v='. $video_id);
    $dom = new DomDocument();
    $ies = libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="UTF-8">' . $html);
    libxml_use_internal_errors($ies);
    echo $dom->getElementById('eow-title')->nodeValue; // Армянский прикол!

}

//$z = parse3("0ncKjicVBWk");
//echo $z;


function get_ydata($url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

//get_ydata("https://www.youtube.com/watch?v=0ncKjicVBWk");
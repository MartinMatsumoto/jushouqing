<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:46
 */
require_once '../../../entrance.php';

$type = $_POST["type"];
$url = $_POST["url"];
$title = $_POST["title"];
$author = $_POST["author"];
$create_date = $_POST["create_date"];
$sub_title = $_POST["sub_title"];


$dao = new video_dao();
$recentId = $dao->save($type, $url, $title, $author, $create_date, $sub_title);

if (!empty($content)) {
    $essay_content_dao = new essay_content_dao();
    foreach ($content as $key => $val) {
        $essay_content_dao->save($recentId, $val, $content_type[$key]);
    }
}

$content = new result($recentId, errorCode::$success);
$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);

echo $json_string;
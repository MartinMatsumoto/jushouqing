<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:46
 */
require_once '../../../entrance.php';

$id = $_POST["id"];
$type = $_POST["type"];
$title = $_POST["title"];
$author = $_POST["author"];
$create_date = $_POST["create_date"];
$sub_title = $_POST["sub_title"];
$url = $_POST["url"];

$dao = new video_dao();
$dao->modify($type, $url, $title, $author, $create_date, $sub_title, $id);

$content = new result($id, errorCode::$success);
$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);

echo $json_string;
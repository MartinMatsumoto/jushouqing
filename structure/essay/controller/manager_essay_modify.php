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

$content = $_POST["content"];
$content_type = $_POST["content_type"];

$dao = new essay_dao();
$dao->modify($type, $title, $author, $create_date, $sub_title, $id);
$essay_content_dao = new essay_content_dao();
$essay_content_dao->deleteAll($id);
if (!empty($content)) {
    foreach ($content as $key => $val) {
        $essay_content_dao->save($id, $val, $content_type[$key]);
    }
}

$content = new result($id, errorCode::$success);
$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);

echo $json_string;
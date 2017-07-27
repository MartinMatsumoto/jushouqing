<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:46
 */
require_once '../../../entrance.php';

$id = intval($_POST["id"]);

$dao = new essay_content_dao();

$result = $dao->listEssayContents($id);
$arr = array();
while ($row = $result->fetch()) {
    $essay_cotent = new essay_content($row);
    array_push($arr, $essay_cotent);
}
$content = new result($arr, errorCode::$success);

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;
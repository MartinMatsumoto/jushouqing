<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2017/1/3
 * Time: 16:55
 */
require_once '../../../entrance.php';

$id = intval($_POST["id"]);

$dao = new essay_dao();

$result = $dao->delete($id);
$content = new result(errorCode::$success, errorCode::$success);

$json_string = json_encode($content, JSON_UNESCAPED_UNICODE);
echo $json_string;
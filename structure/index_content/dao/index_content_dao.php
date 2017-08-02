<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:19
 */
class index_content_dao
{
    private $conn;

    private $modifyIndexContent = "UPDATE INDEX_CONTENT SET `content` = :content,`image_url` = :image_url,`href_url` = :href_url WHERE id = :id";
    private $getOne = "SELECT * FROM `INDEX_CONTENT` WHERE id = :id";
    private $listCompanyActive = "SELECT * FROM INDEX_CONTENT WHERE id > 1 AND id < 8 ";

    //构造函数
    function __construct()
    {
        $this->conn = new connection_mysql();
    }

    function getOne($id)
    {
        $stmt = $this->conn->pdo->prepare($this->getOne);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }

    function modify($id, $content, $image_url, $href_url)
    {
        try {
            $stmt = $this->conn->pdo->prepare($this->modifyIndexContent);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':image_url', $image_url);
            $stmt->bindParam(':href_url', $href_url);
            $stmt->execute();
        } catch (Exception  $e) {
            return false;
        }
        return true;
    }

    function listCompanyActive()
    {
        $stmt = $this->conn->pdo->prepare($this->listCompanyActive);
        $stmt->execute();
        return $stmt;
    }

}
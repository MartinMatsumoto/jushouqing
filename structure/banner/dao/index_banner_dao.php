<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:19
 */
class index_banner_dao
{
    private $conn;

    private $saveBanner = "INSERT INTO INDEX_BANNER(image_url,text1,text2,text3,text4) VALUES (:image_url,:text1,:text2,:text3,:text4)";
    private $modifyBanner = "UPDATE INDEX_BANNER SET `image_url` = :image_url,`text1` = :text1,`text2` = :text2,`text3` = :text3,`text4` = :text4 WHERE id = :id";
    private $listBanners = "SELECT * FROM INDEX_BANNER";
    private $delete = "DELETE FROM `INDEX_BANNER` WHERE id = :id";

    //构造函数
    function __construct()
    {
        $this->conn = new connection_mysql();
    }

    function save($image_url, $text1, $text2, $text3, $text4)
    {

        try {
            $stmt = $this->conn->pdo->prepare($this->saveBanner);
            $stmt->bindParam(':image_url', $image_url);
            $stmt->bindParam(':text1', $text1);
            $stmt->bindParam(':text2', $text2);
            $stmt->bindParam(':text3', $text3);
            $stmt->bindParam(':text4', $text4);
            $stmt->execute();
        } catch (Exception  $e) {
            return false;
        }
        return true;
    }

    function modify($image_url, $text1, $text2, $text3, $text4, $id)
    {

        try {
            $stmt = $this->conn->pdo->prepare($this->modifyBanner);
            $stmt->bindParam(':image_url', $image_url);
            $stmt->bindParam(':text1', $text1);
            $stmt->bindParam(':text2', $text2);
            $stmt->bindParam(':text3', $text3);
            $stmt->bindParam(':text4', $text4);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (Exception  $e) {
            return false;
        }
        return true;
    }

    function listBanners()
    {
        $stmt = $this->conn->pdo->prepare($this->listBanners);
        $stmt->execute();
        return $stmt;
    }

    function delete($id)
    {
        $stmt = $this->conn->pdo->prepare($this->delete);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}
<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:19
 */
class video_dao
{
    private $conn;

    private $saveVideo = "INSERT INTO VIDEO(title,author,create_date,sub_title,type,url) VALUES (:title,:author,:create_date,:sub_title,:type,:url)";
    private $modifyVideo = "UPDATE VIDEO SET `title` = :title,`author` = :author,`create_date` = :create_date,`sub_title` = :sub_title,`url` = :url,`type` = :type WHERE id = :id";
    private $getOne = "SELECT * FROM `VIDEO` WHERE id = :id";
    private $getPrev = "SELECT * FROM `VIDEO` WHERE id < :id AND delete_ = 0 ORDER BY ID DESC LIMIT 1";
    private $getNext = "SELECT * FROM `VIDEO` WHERE id > :id AND delete_ = 0 LIMIT 1";
    private $count = "SELECT COUNT(*) AS COUNT from `VIDEO`";
    private $delete = "UPDATE `VIDEO` SET delete_ = 1 WHERE id = :id";
    private $enable = "UPDATE `VIDEO` SET delete_ = 0 WHERE id = :id";

    //构造函数
    function __construct()
    {
        $this->conn = new connection_mysql();
    }

    function autOpenIdExist($openid)
    {
        $exist = false;
        $stmt = $this->getOne($openid);
        while ($row = $stmt->fetch()) {
            $exist = true;
        }

        return $exist;
    }

    function getOne($id)
    {
        $stmt = $this->conn->pdo->prepare($this->getOne);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }

    function getPrev($id)
    {
        $stmt = $this->conn->pdo->prepare($this->getPrev);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }

    function getNext($id)
    {
        $stmt = $this->conn->pdo->prepare($this->getNext);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }

    function save($type,$url, $title, $author, $create_date, $sub_title)
    {

        try {
            $stmt = $this->conn->pdo->prepare($this->saveVideo);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':url', $url);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':author', $author);
            $stmt->bindParam(':create_date', $create_date);
            $stmt->bindParam(':sub_title', $sub_title);
            $stmt->execute();

            $recentId = $stmt = $this->conn->pdo->lastInsertId();
            return $recentId;
        } catch (Exception  $e) {
            return false;
        }
    }

    function modify($type,$url, $title, $author, $create_date, $sub_title, $id)
    {
        try {
            $stmt = $this->conn->pdo->prepare($this->modifyVideo);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':url', $url);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':author', $author);
            $stmt->bindParam(':create_date', $create_date);
            $stmt->bindParam(':sub_title', $sub_title);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        } catch (Exception  $e) {
            return false;
        }
    }

    function listVideos($begin, $size, $delete_)
    {
        $listVideos = "SELECT * FROM VIDEO WHERE 1=1 ";

        if(isset($delete_)){
            $listVideos .= " AND delete_ = :delete_";
        }

        $listVideos .= " LIMIT :be ,:en ";
        $stmt = $this->conn->pdo->prepare($listVideos);
        $stmt->bindParam(':be', $begin, PDO::PARAM_INT);
        $stmt->bindParam(':en', $size, PDO::PARAM_INT);

        if(isset($delete_)){
            $stmt->bindParam(':delete_', $delete_, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt;
    }

    function count()
    {
        $stmt = $this->conn->pdo->prepare($this->count);
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

    function enable($id)
    {
        $stmt = $this->conn->pdo->prepare($this->enable);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
}
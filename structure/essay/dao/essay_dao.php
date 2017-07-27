<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:19
 */
class essay_dao
{
    private $conn;

    private $saveEssay = "INSERT INTO ESSAY(title,author,create_date,sub_title,type) VALUES (:title,:author,:create_date,:sub_title,:type)";
    private $modifyEssay = "UPDATE ESSAY SET `title` = :title,`author` = :author,`create_date` = :create_date,`sub_title` = :sub_title,`type` = :type WHERE id = :id";
    private $getOne = "SELECT * FROM `ESSAY` WHERE id = :id";
    private $getPrev = "SELECT * FROM `ESSAY` WHERE id < :id ORDER BY ID DESC LIMIT 1";
    private $getNext = "SELECT * FROM `ESSAY` WHERE id > :id LIMIT 1";
    private $count = "SELECT COUNT(*) AS COUNT from `ESSAY`";
    private $delete = "UPDATE `ESSAY` SET delete_ = 1 WHERE id = :id";
    private $enable = "UPDATE `ESSAY` SET delete_ = 0 WHERE id = :id";

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

    function save($type, $title, $author, $create_date, $sub_title)
    {

        try {
            $stmt = $this->conn->pdo->prepare($this->saveEssay);
            $stmt->bindParam(':type', $type);
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

    function modify($type, $title, $author, $create_date, $sub_title, $id)
    {
        try {
            $stmt = $this->conn->pdo->prepare($this->modifyEssay);
            $stmt->bindParam(':type', $type);
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

    function listEssays($begin, $size, $type, $delete_)
    {
        $listEssays = "SELECT * FROM ESSAY WHERE 1=1 ";
        if(!empty($type)){
            $listEssays .= " AND type = :type";
        }

        if(isset($delete_)){
            $listEssays .= " AND delete_ = :delete_";
        }

        $listEssays .= " LIMIT :be ,:en ";
        $stmt = $this->conn->pdo->prepare($listEssays);
        $stmt->bindParam(':be', $begin, PDO::PARAM_INT);
        $stmt->bindParam(':en', $size, PDO::PARAM_INT);
        if(!empty($type)){
            $stmt->bindParam(':type', $type, PDO::PARAM_INT);
        }

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
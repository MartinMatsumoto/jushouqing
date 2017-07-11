<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:19
 */
class message_dao
{
    private $conn;
    private $getOne = "select * from message where id = :id";
    private $count = "select count(*) AS COUNT from message";
    private $listAll = "SELECT * FROM message ORDER BY id DESC LIMIT :be ,:en";
    private $addMessage = "INSERT INTO message(openid,message,create_date) VALUES (:openId,:message,:createDate)";

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

    function listAll($pageSize, $currentPage)
    {
        $begin = ($currentPage - 1) * $pageSize;
        $stmt = $this->conn->pdo->prepare($this->listAll);
        $stmt->bindParam(':be', $begin, PDO::PARAM_INT);
        $stmt->bindParam(':en', $pageSize, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    function listMore($begin, $size)
    {
        $stmt = $this->conn->pdo->prepare($this->listAll);
        $stmt->bindParam(':be', $begin, PDO::PARAM_INT);
        $stmt->bindParam(':en', $size, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    function addMessage($message,$openId)
    {
        $datetime = date('Y-m-d H:i:s',time());
        $stmt = $this->conn->pdo->prepare($this->addMessage);
        $stmt->bindParam(':openId', $openId);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':createDate', $datetime);
        $stmt->execute();

        $recentId = $stmt = $this->conn->pdo->lastInsertId();
        return $recentId;
    }

    function count(){
        $stmt = $this->conn->pdo->prepare($this->count);
        $stmt->execute();
        return $stmt;
    }

}
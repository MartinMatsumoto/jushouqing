<?php

/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/9/20
 * Time: 10:19
 */
class message_reply_dao
{
    private $conn;
    private $getOne = "select * from message_reply where id = :id";
    private $listByMessage = "select * from message_reply where message_id = :messageId";
    private $replyMessage = "INSERT INTO message_reply(reply,openid,message_id) VALUES (:reply,:openId,:messageId)";

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

    function listByMessage($messageId)
    {
        $stmt = $this->conn->pdo->prepare($this->listByMessage);
        $stmt->bindParam(':messageId', $messageId);
        $stmt->execute();
        return $stmt;
    }

    function reply($reply,$openId,$messageId)
    {
        $stmt = $this->conn->pdo->prepare($this->replyMessage);
        $stmt->bindParam(':reply', $reply);
        $stmt->bindParam(':openId', $openId);
        $stmt->bindParam(':messageId', $messageId);
        $stmt->execute();
        return $stmt;
    }

}
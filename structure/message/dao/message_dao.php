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
    private $getOne = "select m.*,u.name AS `name`,u.sex AS sex,u.wx_headimgurl AS user_wx_headimgurl from message m LEFT JOIN `user` u ON u.openid = m.openid where m.id = :id";
    private $count = "select count(*) AS COUNT from message";
    private $delete = "UPDATE message SET delete_ = 1 WHERE id = :id AND openid = :openId";
    private $enable = "UPDATE message SET delete_ = 0 WHERE id = :id AND openid = :openId";
    private $updateMessage = "UPDATE message SET message = :message WHERE id = :id AND openid = :openId";
    private $listAll = "SELECT m.*,u.name AS `name`,u.sex AS sex,u.wx_headimgurl AS user_wx_headimgurl FROM message m LEFT JOIN `user` u ON u.openid = m.openid WHERE m.delete_ = 0 ORDER BY m.id DESC LIMIT :be ,:en";
    private $listManager = "SELECT m.*,u.name AS `name` FROM message m LEFT JOIN `user` u ON u.openid = m.openid ORDER BY m.id DESC LIMIT :be ,:en";
    private $addMessage = "INSERT INTO message(openid,message,create_date,wx_nickname,wx_headimgurl) VALUES (:openId,:message,now(),:wx_nickname,:wx_headimgurl)";

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

    function listManager($begin, $size){
        $stmt = $this->conn->pdo->prepare($this->listManager);
        $stmt->bindParam(':be', $begin, PDO::PARAM_INT);
        $stmt->bindParam(':en', $size, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    function addMessage($message, $openId, $wx_nickname, $wx_headimgurl)
    {
        $stmt = $this->conn->pdo->prepare($this->addMessage);
        $stmt->bindParam(':openId', $openId);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':wx_nickname', $wx_nickname);
        $stmt->bindParam(':wx_headimgurl', $wx_headimgurl);
        $stmt->execute();

        $recentId = $stmt = $this->conn->pdo->lastInsertId();
        return $recentId;
    }

    function count()
    {
        $stmt = $this->conn->pdo->prepare($this->count);
        $stmt->execute();
        return $stmt;
    }

    function delete($messageId, $openId)
    {
        $stmt = $this->conn->pdo->prepare($this->delete);
        $stmt->bindParam(':openId', $openId);
        $stmt->bindParam(':id', $messageId);
        $stmt->execute();
        return $stmt;
    }

    function enable($messageId, $openId)
    {
        $stmt = $this->conn->pdo->prepare($this->enable);
        $stmt->bindParam(':openId', $openId);
        $stmt->bindParam(':id', $messageId);
        $stmt->execute();
        return $stmt;
    }

    function updateMessage($messageId, $openId, $message)
    {
        $stmt = $this->conn->pdo->prepare($this->updateMessage);
        $stmt->bindParam(':openId', $openId);
        $stmt->bindParam(':id', $messageId);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
        return $stmt;
    }
}
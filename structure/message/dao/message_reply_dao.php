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
    private $getOne = "SELECT reply.*,u.`name` AS reply_name,u.wx_headimgurl AS reply_user_headimgurl FROM (SELECT reply.*,u.`name`,u.wx_headimgurl AS user_headimgurl FROM (SELECT mr1.*,mr2.openid AS reply_openid,mr2.wx_headimgurl AS reply_wx_headimgurl,mr2.wx_nickname AS reply_wx_nickname from message_reply mr1 LEFT JOIN message_reply mr2 ON mr1.reply_id = mr2.id WHERE mr1.id = :id) AS reply LEFT JOIN `user` u ON reply.openid = u.openid) AS reply LEFT JOIN `user` u ON reply.reply_openid = u.openid";
    private $listByMessage = "SELECT reply.*,u.`name` AS reply_name,u.wx_headimgurl AS reply_user_headimgurl FROM (SELECT reply.*,u.`name`,u.wx_headimgurl AS user_headimgurl FROM (SELECT mr1.*,mr2.openid AS reply_openid,mr2.wx_headimgurl AS reply_wx_headimgurl,mr2.wx_nickname AS reply_wx_nickname from message_reply mr1 LEFT JOIN message_reply mr2 ON mr1.reply_id = mr2.id WHERE mr1.message_id = :messageId AND mr1.delete_ = 0) AS reply LEFT JOIN `user` u ON reply.openid = u.openid) AS reply LEFT JOIN `user` u ON reply.reply_openid = u.openid ORDER BY reply.id ASC";
    private $listManager = "SELECT reply.*,u.`name` AS reply_name,u.wx_headimgurl AS reply_user_headimgurl FROM (SELECT reply.*,u.`name`,u.wx_headimgurl AS user_headimgurl FROM (SELECT mr1.*,mr2.openid AS reply_openid,mr2.wx_headimgurl AS reply_wx_headimgurl,mr2.wx_nickname AS reply_wx_nickname from message_reply mr1 LEFT JOIN message_reply mr2 ON mr1.reply_id = mr2.id WHERE mr1.message_id = :messageId) AS reply LEFT JOIN `user` u ON reply.openid = u.openid) AS reply LEFT JOIN `user` u ON reply.reply_openid = u.openid ORDER BY reply.id ASC";
    private $replyMessage = "INSERT INTO message_reply(reply,openid,message_id,reply_id,create_date,wx_nickname,wx_headimgurl) VALUES (:reply,:openId,:messageId,:replyId,now(),:wx_nickname,:wx_headimgurl)";
    private $delete = "UPDATE message_reply SET delete_ = 1 WHERE id = :id AND openid = :openId";

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

    function listManager($messageId){
        $stmt = $this->conn->pdo->prepare($this->listManager);
        $stmt->bindParam(':messageId', $messageId);
        $stmt->execute();
        return $stmt;
    }

    function reply($reply, $openId, $messageId, $replyId, $wx_nickname, $wx_headimgurl)
    {
        $emptyReply = 0;
        $stmt = $this->conn->pdo->prepare($this->replyMessage);
        $stmt->bindParam(':reply', $reply);
        $stmt->bindParam(':openId', $openId);
        $stmt->bindParam(':messageId', $messageId);
        $stmt->bindParam(':replyId', $replyId ? $replyId : $emptyReply);
        $stmt->bindParam(':wx_nickname', $wx_nickname);
        $stmt->bindParam(':wx_headimgurl', $wx_headimgurl);
        $stmt->execute();

        $recentId = $stmt = $this->conn->pdo->lastInsertId();
        return $recentId;
    }

    function delete($replyId, $openId)
    {
        $stmt = $this->conn->pdo->prepare($this->delete);
        $stmt->bindParam(':openId', $openId);
        $stmt->bindParam(':id', $replyId);
        $stmt->execute();
        return $stmt;
    }

}
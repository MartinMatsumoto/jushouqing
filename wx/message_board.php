<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>绵职院成都校友会-留言板</title>
    <link href="./css/message_board.css?2017" rel="stylesheet" type="text/css"/>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
require_once '../entrance.php';
require_once './include/get_open_id.php';
require_once './include/get_user_info.php';
require_once './include/user_secret_save.php';
$message_dao = new message_dao();
$message_reply_dao = new message_reply_dao();
?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand">留言板&nbsp;(<?php $result = $message_dao->count();
                $row = $result->fetch();
                echo $row["COUNT"]; ?>)</a>
        </div>
    </div>
</nav>

<div class="white_content"></div>
<?php
$result = $message_dao->listAll(10, 1);
while ($row = $result->fetch()) {
    $message = new message($row);
    $replyResult = $message_reply_dao->listByMessage($message->id);
    ?>
    <div class="media content">
        <input id="message_id" value="<?php echo $message->id ?>" type="hidden"/>
        <a class="media-left wx_header">
            <img class="media-object" src="<?php
                if(!empty($message->user_wx_headimgurl)){
                    echo $message->user_wx_headimgurl;
                }else if(!empty($message->wx_headimgurl)){
                    echo $message->wx_headimgurl;
                }
            ?>" alt="用户头像">
        </a>

        <div class="media-body">
            <h4 class="media-heading nickname"><?php
                    if(!empty($message->name)){
                        echo $message->name;
                    }else if (!empty($message->wx_nickname)){
                        echo $message->wx_nickname;
                    }
                ?></h4>

            <div class="message">
                <?php echo $message->message ?>
            </div>
            <div class="date"><?php echo $message->create_date ?><span class="reply">回复</span></div>

            <div class="line"></div>

            <?php
            while ($row = $replyResult->fetch()) {
                $message_reply = new message_reply($row);
                ?>
                <!-- 嵌套的媒体对象 -->
                <div class="media reply">
                    <a class="media-left wx_header_small">
                        <img class="media-object" src="./images/default_header.png" alt="用户头像">
                    </a>

                    <div class="media-body">
                        <span class="nickname_small">用户昵称</span>
                        <span>回复</span>
                        <span class="nickname_small">用户昵称</span>
                        <?php echo $message_reply->reply; ?>
                        <div class="date">2017-01-05 11:39<span class="reply">回复</span></div>
                    </div>
                </div>


                <?php
            }
            ?>


        </div>
        <img class="footer" src="./images/message_content_bottom.png"/>
    </div>
<?php } ?>

<div class="white_content"></div>

<nav class="navbar navbar-default navbar-fixed-bottom footer_input_margin_top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header footer_input_width">
            <form class="bs-example bs-example-form" role="form">
                <div class="row">
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-success" type="button">
                                发送
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</nav>
<img class="bg_img" src="./images/bg.jpg">
<script src="/libs/jquery.min.js"></script>
<script src="/libs/bootstrap.min.js"></script>
</body>
</html>
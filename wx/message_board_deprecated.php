<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>绵职院校友会-留言板</title>
    <link href="./css/message_board.css" rel="stylesheet" type="text/css"/>
    <link href="./css/mask.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/libs/jquery.min.js"></script>
</head>
<body>
<?php
require_once '../entrance.php';
require_once 'get_open_id.php';
$message_dao = new message_dao();
$message_reply_dao = new message_reply_dao();

//$openid = "oC00gxAxQ8KdPWbyEoOCOEGmbQiw";
?>
<?php include './include/dialog_mask.php'; ?>
<div class="mask" id="mask">
    <div class="background"></div>
    <div class="mask_content_container">
        <div id="close_say_sth" class="close_btn"></div>
        <textarea class="input_style" placeholder="想说点什么^_^" id="message_content"></textarea>

        <div class="submit_btn" id="add_message">发送</div>
    </div>
</div>
<div class="bg"></div>
<div class="header">
    <div class="content">共有<strong><?php $result = $message_dao->count();$row = $result->fetch();echo $row["COUNT"]; ?></strong>条留言
    </div>
</div>
<img class="say_sth" src="./images/say_sth.png" id="say_sth"/>

<div class="message" id="message_all_container">
    <?php
    $result = $message_dao->listAll(5, 1);
    while ($row = $result->fetch()) {
        $message = new message($row);
        $replyResult = $message_reply_dao->listByMessage($message->id);
        ?>
        <div id="message_exist">
            <input id="message_id" value="<?php echo $message->id ?>" type="hidden"/>

            <div class="message_tip">
                <table class="message_tip_container">
                    <td class="message_content"><?php echo $message->message ?></td>
                </table>
                <div class="message_answer_btn"></div>
            </div>
            <div>
                <div class="message_answer_container">
                    <div class="message_answer">
                        <?php
                        while ($row = $replyResult->fetch()) {
                            $message_reply = new message_reply($row);
                            ?>
                            <div class="message_answer_content_container">
                                <img src="./images/butterfly_tie.png">
                        <span>
                            <?php echo $message_reply->reply; ?>
                        </span>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="clear" id="clear"></div>
                    </div>
                    <input class="message_answer_input" id="reply_input" placeholder="想对TA说什么^_^"/>

                    <div class="message_answer_reply_btn" id="message_reply">回复</div>
                    <div class="clear"></div>
                </div>
                <img class="message_answer_pic" src="./images/answer_bottom.png">
            </div>
        </div>
    <?php } ?>

    <div style="display: none;" id="message_template">
        <input id="message_id" value="0" type="hidden"/>
        <div class="message_tip">
            <table class="message_tip_container">
                <td class="message_content" id="message_template_content"></td>
            </table>
            <div class="message_answer_btn"></div>
        </div>
        <div>
            <div class="message_answer_container">
                <div class="message_answer">
                    <div class="message_answer_content_container" id="message_answer_template" style="display: none">
                        <img src="./images/butterfly_tie.png">
                        <span id="message_answer_content"></span>
                    </div>
                    <div class="clear" id="clear"></div>
                </div>
                <input class="message_answer_input" id="reply_input" placeholder="想对TA说什么^_^"/>

                <div class="message_answer_reply_btn" id="message_reply">回复</div>
                <div class="clear"></div>
            </div>
            <img class="message_answer_pic" src="./images/answer_bottom.png">
        </div>
    </div>

</div>
</body>
<script type="text/javascript">
    $(function () {
        var saySth = $("#say_sth");
        var closeSaySth = $("#close_say_sth");
        var mask = $("#mask");
        var messageExists = $("div[id*='message_exist']");
        var messageAllContainer = $("#message_all_container");
        var openId = "<?php echo $openid ?>";

        var alertDialog = $("#alert_dialog");
        var alertDialogText = $("#alert_dialog_text");
        var waitingDialogText = $("#waiting_dialog_text");
        var alertConfirm = $("#alert_confirm");
        var waitingContainer = $("#waiting_container");
        var alertContainer = $("#alert_container");
        var maskshow = false;
        var loadingtext = "加载中，请稍后。";
        var errortext = "服务器错误，请重试。";

        var addMessage = $("#add_message");
        var messageContent = $("#message_content");

        var loadingmore = false;

        function showloading(text, confirm) {
            if (maskshow) {
                return;
            }
            maskshow = true;
            if (confirm) {
                waitingContainer.hide();
                alertContainer.show();
                alertDialogText.html(text);
            } else {
                waitingContainer.show();
                alertContainer.hide();
                waitingDialogText.html(text);
            }
            alertDialog.fadeIn(200, function () {

            });
        }

        var hideloading = function () {
            alertDialog.fadeOut(200, function () {
                maskshow = false;
            });
        }

        var changeloading = function (text, timeout) {
            waitingDialogText.html(text);
            if (!timeout) {
                timeout = 1000;
            }
            setTimeout(function () {
                hideloading();
            }, timeout);
        }

        saySth.bind("click", function () {
            mask.fadeIn();
        });

        closeSaySth.bind("click", function () {
            mask.fadeOut();
        });

        /**
         * 绑定php克隆出的数据
         */
        var bindExistMessages = function () {
            for (var i = 0; i < messageExists.length; i++) {
                var messageExist = $(messageExists[i]);
                bindReplyButtons(messageExist);
            }
        }

        /**
         * 绑定回复按钮点击
         * @param messageExist
         */
        var bindReplyButtons = function (messageExist) {
            messageExist.find("#message_reply").bind("click", function () {
                showloading(loadingtext);
                var reply = messageExist.find("#reply_input").val();
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: "/structure/message/controller/reply.php",
                    data: {
                        messageId: messageExist.find("#message_id").val(),
                        reply: reply,
                        openId: openId
                    },
                    success: function (data) {
                        if (data && data.errorCode == 1) {
                            messageExist.find("#reply_input").val("");
                            var template = $("#message_answer_template");
                            var templateClone = template.clone(true);

                            templateClone.find("#message_answer_content").html(reply);
                            templateClone.css("display","block");
                            messageExist.find("#clear").before(templateClone);
                            hideloading();
                        } else {
                            changeloading(errortext);
                        }
                    },
                    error: function () {
                        changeloading(errortext);
                    }
                });
            });
        }

        bindExistMessages();

        addMessage.bind("click", function () {
            showloading(loadingtext);
            var message = $("#message_content").val();
            $.ajax({
                type: "post",
                dataType: "json",
                url: "/structure/message/controller/add_message.php",
                data: {
                    message: message,
                    openId: openId
                },
                success: function (data) {
                    if (data && data.errorCode == 1) {
                        $("#message_content").val("");
                        hideloading();
                        mask.fadeOut();

                        cloneTemplate = bindMessageAdd(message, data.content);
                        messageAllContainer.prepend(cloneTemplate);
                        var currentScrollTop = $(window).scrollTop();
                        var timer = setInterval(function () {
                            currentScrollTop -= 50;
                            $(window).scrollTop(currentScrollTop);
                            if(currentScrollTop <= 50){
                                clearInterval(timer);
                            }
                        }, 20);
                    } else {
                        changeloading(errortext);
                    }
                },
                error: function () {
                    changeloading(errortext);
                }
            });
        });

        /**
         * 消息克隆
         */
        var bindMessageAdd = function (message, id) {
            var messageTemplate = $("#message_template");
            var cloneTemplate = messageTemplate.clone(true);
            cloneTemplate.find("#message_template_content").html(message);
            cloneTemplate.find("#message_id").val(id);

            bindReplyButtons(cloneTemplate);
            cloneTemplate.css("display", "block");

            return cloneTemplate;
        }

        /**
         * 滑动加载更多
         */
        $(window).scroll(function () {
            var scrollTop = $(this).scrollTop();
            var nScrollHight = $(this).scrollHeight;
            var windowHeight = $(this).height();
            var totalHeight = messageAllContainer.height();
            //console.log(scrollTop + "," + totalHeight + "," + windowHeight);
            if((scrollTop + windowHeight) >= totalHeight - 100){
                if(!loadingmore){
                    loadingmore = true;
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: "/structure/message/controller/list_more.php",
                        data: {
                            begin: messageAllContainer.children().length - 1,
                            pageSize: 5
                        },
                        success: function (data) {
                            if (data && data.errorCode == 1) {
                                if (data.content && data.content.length > 0) {
                                    for (var i = 0; i < data.content.length; i++) {
                                        var content = data.content[i];
                                        cloneTemplate = bindMessageAdd(content.message, content.id);
                                        $("#message_template").before(cloneTemplate);
                                    }
                                }
                            }
                            setTimeout(function(){
                                loadingmore = false;
                            },1000);
                        },
                        error: function () {
                            setTimeout(function(){
                                loadingmore = false;
                            },1000);
                        }
                    });
                }
            }
        });
    })
</script>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/12/16
 * Time: 10:15
 */

?>
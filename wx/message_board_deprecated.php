<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>绵职院成都校友会-留言板</title>
    <link href="./css/message_board.css?201701" rel="stylesheet" type="text/css"/>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .virtual_box{
            width: 100%;
        }
    </style>
</head>
<body>
<?php
require_once '../entrance.php';
require_once './include/get_open_id.php';
require_once './include/get_user_info.php';
require_once './include/user_secret_save.php';
$message_dao = new message_dao();
$message_reply_dao = new message_reply_dao();

/*$openid = "oC00gxAxQ8KdPWbyEoOCOEGmbQiw";
$nickname = "小强";
$headimgurl = "http://wx.qlogo.cn/mmhead/PiajxSqBRaEJnR6TvRzhjgI1Flx9Jaqns4C3mzRiaLrh6lHLMmGKPHHw/0";*/

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

<div class="white_content" id="white_content_after"></div>

<div id="content_template" style="display:none">
    <div class="content">
        <input id="message_id" value="" type="hidden">
        <a class="media-left wx_header">
            <img class="media-object" src="" alt="用户头像" id="message_header"/>
        </a>

        <div class="media-body" id="media_body">
            <h4 class="media-heading nickname" id="message_name"></h4>

            <div class="message" id="message">
            </div>
            <div class="date">
                <span id="message_createdate"></span>
                <span class="reply" id="reply_message">回复</span>
                <span class="delete" id="delete_message">删除</span>
            </div>
            <div class="line"></div>
        </div>
    </div>
    <img class="flower_footer" src="./images/message_content_bottom.png">
</div>

<div class="media reply" id="reply_template" style="display: none">
    <a class="media-left wx_header_small">
        <img class="media-object" id="reply_header" src="" alt="用户头像">
    </a>
    <div class="media-body">
        <span class="nickname_small" id="reply_name"></span>
        <span id="reply_text">回复</span>
        <span id="reply_nickname" class="nickname_small"></span>
        <span id="reply_message"></span>
        <div class="date">
            <span id="reply_date"></span>
            <span class="reply" id="reply_reply">回复</span>
            <span class="delete" id="delete_reply">删除</span>
        </div>
    </div>
</div>

<?php
$result = $message_dao->listAll(10, 1);
while ($row = $result->fetch()) {
    $message = new message($row);
    $replyResult = $message_reply_dao->listByMessage($message->id);
    ?>

    <div id="content" message_id="<?php echo $message->id ?>">
        <div class="content">
            <input id="message_id" value="<?php echo $message->id ?>" type="hidden"/>
            <a class="media-left wx_header">
                <img class="media-object" src="<?php
                if (!empty($message->user_wx_headimgurl)) {
                    echo $message->user_wx_headimgurl;
                } else if (!empty($message->wx_headimgurl)) {
                    echo $message->wx_headimgurl;
                }
                ?>" alt="用户头像">
            </a>

            <div class="media-body" id="media_body">
                <h4 class="media-heading nickname" id="message_name"><?php
                    if (!empty($message->name)) {
                        echo $message->name;
                    } else if (!empty($message->wx_nickname)) {
                        echo $message->wx_nickname;
                    }
                    ?></h4>

                <div class="message">
                    <?php echo $message->message ?>
                </div>
                <div class="date"><?php echo $message->create_date ?>
                    <span class="reply" id="reply_message">回复</span>
                    <?php
                    if ($message->openid == $openid) {
                        ?>
                        <span class="delete" id="delete_message">删除</span>
                        <?php
                    }
                    ?>

                </div>

                <div class="line"></div>

                <?php
                while ($row = $replyResult->fetch()) {
                    $message_reply = new message_reply($row);
                    ?>
                    <!-- 嵌套的媒体对象 -->
                    <div class="media reply" id="reply" reply_id="<?php echo $message_reply->id ?>">
                        <a class="media-left wx_header_small">
                            <img class="media-object" src="<?php
                            if (!empty($message_reply->user_headimgurl)) {
                                echo $message_reply->user_headimgurl;
                            } else if (!empty($message_reply->wx_headimgurl)) {
                                echo $message_reply->wx_headimgurl;
                            }
                            ?>" alt="用户头像">
                        </a>

                        <div class="media-body">
                        <span class="nickname_small" id="reply_name"><?php
                            if (!empty($message_reply->name)) {
                                echo $message_reply->name;
                            } else if (!empty($message_reply->wx_nickname)) {
                                echo $message_reply->wx_nickname;
                            }
                            ?></span>

                            <?php
                            if ($message_reply->reply_id) { ?>
                                <span>回复</span>
                                <span class="nickname_small"><?php
                                    if (!empty($message_reply->reply_name)) {
                                        echo $message_reply->reply_name;
                                    } else if (!empty($message_reply->reply_wx_nickname)) {
                                        echo $message_reply->reply_wx_nickname;
                                    }
                                    ?></span>
                            <?php } ?>
                            <?php echo $message_reply->reply; ?>
                            <div class="date"><?php echo $message_reply->create_date ?>
                                <span class="reply" id="reply_reply">回复</span>
                                <?php
                                if ($message_reply->openid == $openid) {
                                    ?>
                                    <span class="delete" id="delete_reply">删除</span>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

        </div>
        <img class="flower_footer" src="./images/message_content_bottom.png"/>
    </div>
<?php } ?>

<div class="white_content" id="white_content_before"></div>
</div>

<div style="clear:both;"></div>
<nav class="navbar navbar-default navbar-fixed-bottom footer_input_margin_top" role="navigation" id="input_nav">
    <div class="input-group" id="android_message_input">
        <input type="text" class="form-control" placeholder="说点什么吧" id="message_input">
        <span class="input-group-btn">
            <button class="btn btn-default btn-success" type="button" id="send">
                发送
            </button>
        </span>
    </div>

    <button class="btn btn-default virtual_box" type="button" id="virtual_input_box" style="display:none">
        说点什么
    </button>
</nav>

<!-- 加载框 -->
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal" aria-hidden="true"
     data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                加载中请稍等
            </div>
        </div>
    </div>
</div>

<!-- 确认框 -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">请确认</h4>
            </div>
            <div class="modal-body">是否确认删除?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="confirm_modal_confirm">确定</button>
            </div>
        </div>
    </div>
</div>

<!-- 回复框 -->
<div class="modal fade" id="messageInputModal" tabindex="-1" role="dialog" aria-labelledby="messageInputModal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="input-group" id="android_message_input">
                    <input type="text" class="form-control" placeholder="说点什么吧" id="message_input_ios">
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-success" type="button" id="send_ios">
                            发送
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<img class="bg_img" src="./images/bg.jpg">
<script src="/libs/jquery.min.js"></script>
<script src="/libs/bootstrap.min.js"></script>
<script type="text/javascript">
    $(function () {
        var loadingmore = false;
        var messageId = 0;
        var replyId = 0;
        var defaultplaceholder = "说点什么吧";

        var messageInput = $("#message_input");
        var contentTemplate = $("#content_template");
        var replyTemplate = $("#reply_template");
        var templateBefore = $("#white_content_before");
        var templateAfter = $("#white_content_after");
        var inputNav = $("#input_nav");
        var mediaContent;

        var init = function () {
            var contents = $("div[id=content]");
            if(contents && contents.length){
                for (var i = 0; i < contents.length; i++) {
                    bindContentClick($(contents[i]));
                }
            }

            if (isIphone()) {
                $("#android_message_input").remove();
                $("#virtual_input_box").show();
                $("#virtual_input_box").bind("click",function(){
                    clearMessageInput();
                    $('#messageInputModal').modal('show');
                });
                $("#message_input_ios").attr("id","message_input");
                $("#send_ios").attr("id","send");
                messageInput = $("#message_input");
            }

            $("#send").click(function () {
                var message = messageInput.val();
                if (!message) {
                    return;
                }
                $('#loadingModal').modal('show');
                //发送信息
                if (!messageId && !replyId) {
                    sendMessage(message);
                }

                //回复消息
                if (messageId && !replyId) {
                    reply(message, messageId);
                }

                //回复回复
                //https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx2301da7d30fe75e1&redirect_uri=http%3A%2F%2Fwww.jushouqing.top%2Fwx%2Fmessage_board_deprecated.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect
                if (messageId && replyId) {
                    reply(message, messageId, replyId);
                }
            });

        }

        var initReply = function() {
            var replies = $("div[id=reply]");
            if (replies && replies.length) {
                for (var i = 0; i < replies.length; i++) {
                    bindReplyClick($(replies[i]));
                }
            }
        }

        init();
        initReply();

        messageInput.blur(function () {
            if (!messageInput.val()) {
                clearMessageInput();
            }
        });

        function clearMessageInput() {
            messageInput.attr("placeholder", defaultplaceholder);
            messageInput.val("");
            messageId = 0;
            replyId = 0;
            if(isIphone()){
                $('#messageInputModal').modal('hide');
            }
        }

        function focusMessageInput(name, messageIdRe, replyIdRe) {
            messageInput.attr("placeholder", "回复" + name + "：");
            messageInput.focus();
            messageId = messageIdRe;
            replyId = replyIdRe;
        }

        var sendMessage = function (message) {
            $.ajax({
                type: "post",
                dataType: "json",
                url: "/structure/message/controller/add_message.php",
                data: {
                    message: message,
                    openId: "<?php echo $openid?>",
                    wx_nickname: "<?php echo $nickname?>",
                    wx_headimgurl: "<?php echo $headimgurl?>"
                },
                success: function (data) {
                    $('#loadingModal').modal('hide');
                    if (data && data.errorCode && data.content) {
                        cloneContent(data.content,true);
                    }

                    clearMessageInput();
                },
                error: function () {
                    $('#loadingModal').modal('hide');
                    clearMessageInput();
                }
            });
        }

        var cloneContent = function (data,after) {
            var contentClone = contentTemplate.clone(true);
            contentClone.attr("id", "content");
            contentClone.attr("message_id", data.id);
            contentClone.show();
            contentClone.find("#message_name").html(data.name ? data.name : data.wx_nickname);
            contentClone.find("#message_id").val(data.id);
            contentClone.find("#message_header").attr("src",data.user_wx_headimgurl ? data.user_wx_headimgurl : data.wx_headimgurl);
            contentClone.find("#message").html(data.message);
            contentClone.find("#message_createdate").html(data.create_date);
            mediaContent = contentClone.find("#media_body");
            if(data.openid == "<?php echo $openid?>") {
                contentClone.find("#delete_message").show();
            }else{
                contentClone.find("#delete_message").hide();
            }
            if (after) {
                templateAfter.after(contentClone);
            } else {
                templateBefore.before(contentClone);
            }

            var replies = data.replies;
            if (replies && replies.length) {
                for (var i = 0; i < replies.length; i++) {
                    cloneReply(replies[i]);
                }
            }

            bindContentClick(contentClone);
        }

        var reply = function (message, messageId, replyId) {
            $.ajax({
                type: "post",
                dataType: "json",
                url: "/structure/message/controller/reply.php",
                data: {
                    messageId: messageId,
                    reply: message,
                    replyId : replyId ? replyId : 0,
                    openId: "<?php echo $openid?>",
                    wx_nickname: "<?php echo $nickname?>",
                    wx_headimgurl: "<?php echo $headimgurl?>"
                },
                success: function (data) {
                    $('#loadingModal').modal('hide');
                    clearMessageInput();
                    cloneReply(data.content);
                },
                error: function () {
                    $('#loadingModal').modal('hide');
                    clearMessageInput();
                }
            });
        }

        var cloneReply = function(data){
            var replyClone = replyTemplate.clone(true);
            replyClone.attr("id","reply");
            replyClone.attr("reply_id",data.id);
            replyClone.show();
            replyClone.find("#reply_name").html(data.name ? data.name : data.wx_nickname);
            replyClone.find("#reply_header").attr("src",data.user_wx_headimgurl ? data.user_wx_headimgurl : data.user_headimgurl);
            replyClone.find("#reply_message").html(data.reply);
            replyClone.find("#reply_date").html(data.create_date);

            if (data.reply_id && data.reply_id != 0) {
                replyClone.find("#reply_text").show();
                replyClone.find("#reply_nickname").show();
                replyClone.find("#reply_nickname").html(data.reply_name ? data.reply_name : data.reply_wx_nickname);
            } else {
                replyClone.find("#reply_text").hide();
                replyClone.find("#reply_nickname").hide();
            }

            if(data.openid == "<?php echo $openid?>") {
                replyClone.find("#delete_reply").show();
            }else{
                replyClone.find("#delete_reply").hide();
            }

            mediaContent.append(replyClone);
            bindReplyClick(replyClone);
        }

        function bindReplyClick(content){
            var replyId = content.attr("reply_id");
            var replyReply = content.find("#reply_reply");
            var deleteReply = content.find("#delete_reply");
            var replyName = content.find("#reply_name").html();
            var parentContent = content.parents("#content");

            var messageId = parentContent.attr("message_id");

            replyReply.bind("click", function () {
                if(isIphone()){
                    $('#messageInputModal').modal('show');
                }
                mediaContent = content.parents("#media_body");
                focusMessageInput(replyName, messageId, replyId);
            });

            deleteReply.bind("click", function () {
                $("#confirm_modal_confirm").unbind('click').bind("click",function(){
                    deleteMessageReplyFunc(content,replyId);
                });
                $('#confirmModal').modal('show');
            });
        }

        function bindContentClick(content) {
            var replyMessage = content.find("#reply_message");
            var deleteMessage = content.find("#delete_message");

            var messageId = content.attr("message_id");
            var messageName = content.find("#message_name").html();
            replyMessage.bind("click", function () {
                if(isIphone()){
                    $('#messageInputModal').modal('show');
                }
                mediaContent = content.find("#media_body");
                focusMessageInput(messageName, messageId);
            });

            deleteMessage.bind("click", function () {
                $("#confirm_modal_confirm").unbind('click').bind("click",function(){
                    deleteMessageFunc(content);
                });
                $('#confirmModal').modal('show');
            });
        }

        function deleteMessageFunc(content){
            content.remove();
            $('#confirmModal').modal('hide');

            var messageId = content.attr("message_id");
            $.ajax({
                type: "post",
                dataType: "json",
                url: "/structure/message/controller/delete_message.php",
                data: {
                    messageId: messageId,
                    openId: "<?php echo $openid?>"
                },
                success: function (data) {

                },
                error: function () {
                    clearMessageInput();
                }
            });
        }

        function deleteMessageReplyFunc(content,replyId){
            content.remove();
            $('#confirmModal').modal('hide');

            $.ajax({
                type: "post",
                dataType: "json",
                url: "/structure/message/controller/delete_message_reply.php",
                data: {
                    replyId: replyId,
                    openId: "<?php echo $openid?>"
                },
                success: function (data) {

                },
                error: function () {
                    clearMessageInput();
                }
            });
        }

        /**
         * 滑动加载更多
         */
        $(window).scroll(function () {
            var scrollTop = $(this).scrollTop();
            var nScrollHight = $(this).scrollHeight;
            var windowHeight = $(this).height();
            var totalHeight = $("body").height();

            if ((scrollTop + windowHeight) >= totalHeight - 100) {
                if (!loadingmore) {
                    loadingmore = true;
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: "/structure/message/controller/list_more.php",
                        data: {
                            begin: getCount(),
                            pageSize: 10
                        },
                        success: function (data) {
                            if (data && data.errorCode == 1) {
                                if (data.content && data.content.length > 0) {
                                    for (var i = 0; i < data.content.length; i++) {
                                        var content = data.content[i];
                                        cloneContent(content);
                                    }
                                }
                            }
                            setTimeout(function () {
                                loadingmore = false;
                            }, 1000);
                        },
                        error: function () {
                            setTimeout(function () {
                                loadingmore = false;
                            }, 1000);
                        }
                    });
                }
            }
        });

        function getCount(){
            var contents = $("div[id=content]");
            return contents.length;
        }

        function isIphone() { //判断微信系统
            var u = navigator.userAgent;
            if (u.indexOf('iPhone') > -1) {
                return true;
            }
            return false;
        }


    });
</script>
</body>
</html>
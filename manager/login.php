<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>绵阳职业技术学院成都校友会-后台管理系统</title>

    <link rel="stylesheet" type="text/css" href="css/ext-all.css"/>

    <script type="text/javascript" src="js/ext-all.js"></script>
    <!-- </x-bootstrap> -->
    <script type="text/javascript">
        Ext.onReady(function () {

            var logf = Ext.create('Ext.form.Panel',{
                width: 330,
                height: 170,
                frame: true,
                defaultType: "textfield",
                items: [
                    {
                        fieldLabel: "用户名",
                        name : 'account',
                        allowBlank:false,
                        id : 'login_user_name',
                        enableKeyEvents :true
                    },
                    {
                        inputType: "password",
                        fieldLabel: "密码",
                        allowBlank:false,
                        name : 'password',
                        id : 'login_pass_word',
                        enableKeyEvents :true
                    }
                ],
                buttons: [{ text: "登录", handler: function () {
                    submitLongin(logf);
                }
                }, { text: "重置",handler:function(){
                    logf.getForm().reset();
                }}]
            });
            var loginWindow = Ext.create('Ext.window.Window', {
                closeAction : 'hide',
                layout: 'fit',
                items : [logf],
                title: '绵阳职业技术学院成都校友会-管理平台登录',
                border: false,
                closable: false,
                listeners : {
                    show :  function() {
                        Ext.getCmp('login_user_name').focus(false, 100);
                    }
                }
            }).show();
            Ext.getCmp('login_user_name').on('keypress',function(b,e){
                if(e.keyCode==13){
                    submitLongin(logf);
                }
            });
            Ext.getCmp('login_pass_word').on('keypress',function(b,e){
                if(e.keyCode==13){
                    submitLongin(logf);
                }
            });
        });

        //保持30天登录
        var submitLongin=function(logf){
            if(logf.getForm().isValid()){
                logf.getForm().submit(
                    {
                        url : '/structure/operator/controller/login.php',
                        submitEmptyText : false,
                        waitMsg : '登录中......',
                        success : function(re, v) { // 表单提交成功后,调用的函数.参数分为两个,一个是提交的表单对象,另一个是JSP返回的参数值对象
                            if(v && v.result && v.result.success == 1){
                                var content = v.result.content;
                                Ext.util.Cookies.set('jushouqing_manager_key', content.key);
                                Ext.util.Cookies.set('jushouqing_manager_name', content.real_name);
                                Ext.util.Cookies.set('jushouqing_manager_id', content.id);
                                document.location.href = "./index.php";
                            }else{
                                Ext.Msg.alert("信息", v.result.errorString);
                            }
                        },
                        failure : function(re, v) {
                            Ext.Msg.alert("信息", v.result.message); // 返回失败
                        }
                    });
            }
        }
    </script>
</head>

<body>

</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/12/28
 * Time: 16:23
 */

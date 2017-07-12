<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>绵阳职业技术学院校友调查问卷</title>
    <meta name="keywords" content="绵阳职业技术学院校友用人单位调查问卷">
    <meta name="description" content="绵阳职业技术学院校友用人单位调查问卷">

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/custom.css" rel="stylesheet">
    <link href="./css/animate.min.css" rel="stylesheet">
    <link href="./css/style.min.css" rel="stylesheet">
    <style type="text/css">

        .bg_img {
            position:fixed;
            width:100%;
            height:100%;
            top:0px;
            left:0px;
            z-index:-2;
        }

    </style>
</head>

<body class="gray-bg">
<?php
    require_once 'get_open_id.php';
?>
<div class="wrapper wrapper-content animated fadeInRight" align="center">

    <div class="row" style="max-width: 600px">
        <div class="col-sm-12">
            <img src="./images/header.png" width="100%" style="max-width: 600px">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3 align="center">成都校友会调查问卷</h3>
                </div>
                <div class="ibox-content">
                    <div class="alert alert-info">
                        <a class="alert-link" href="enterprise_questionnaire.php?openid=<?php echo "oC00gxAxQ8KdPWbyEoOCOEGmbQiw" ?>">企业调查问卷</a>
                    </div>
                    <div class="alert alert-info">
                        <a class="alert-link font_small" href="personal_questionnaire.php?openid=<?php echo $openid ?>">校友调查问卷</a>
                    </div>

                    <div class="font_footer">成都涪诚汇科技有限公司<br />Power By Zengguoqiang<br /></div>
                </div>
            </div>
        </div>
    </div>
</div>
<img class="bg_img" src="./images/bg.jpg">
<script src="/libs/jquery.min.js"></script>
<script src="/libs/bootstrap.min.js"></script>

</body></html>
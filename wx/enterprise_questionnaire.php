<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>绵阳职业技术学院企业调查问卷</title>
    <meta name="keywords" content="绵阳职业技术学院企业调查问卷">
    <meta name="description" content="绵阳职业技术学院企业调查问卷">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/custom.css" rel="stylesheet">
    <link href="./css/animate.min.css" rel="stylesheet">
    <link href="./css/style.min.css" rel="stylesheet">
    <link href="css/datepicker.css" rel="stylesheet">
    <style type="text/css">.bg_img {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            z-index: -2;
        }
    </style>
</head>
<body class="gray-bg">
<?php
require_once '../entrance.php';
$openid = $_GET["openid"];
$update = 0;
$dao = new company_dao();
$stmt = $dao->getOne($openid);
$row = $stmt->fetch();
if(!empty($row)){
    $company = new Company($row);
    $update = 1;
}
?>
<div class="wrapper wrapper-content animated fadeInRight" align="center">
    <div class="row" style="max-width: 600px">
        <div class="col-sm-12">
            <img src="./images/header.png" width="100%" style="max-width: 600px">

            <div class="ibox float-e-margins">
                <div class="ibox-title"><h3 align="center">成都校友会企业调查问卷</h3>

                    <div style="text-align: left">
                        尊敬的校友企业:<br>
                        　&nbsp;&nbsp;&nbsp; 您好！为了校友会公众号能更好的服务于大家，特邀请您参与企业调查问卷。我们保证将对贵单位的信息严格保密，并对您的积极参与表示衷心的感谢！
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="post" action="enterprise_questionnaire_save.php" class="form-horizontal">
                        <div class="form-group" style="text-align: left;margin-left: 0.5em">
                            企业全称<font color="red">*</font></div>
                        <div class="form-group">
                            <div class="col-sm-12"><input type="text" name="name" class="form-control" required="" value="<?php
                                if($update){
                                    echo $company->name;
                                }
                                ?>"/>
                            </div>
                        </div>
                        <div class="form-group" style="text-align: left;margin-left: 0.5em">
                            行业类别<font color="red">*</font></div>
                        <div class="form-group">
                            <div class="col-sm-12"><input type="text" name="career_type" class="form-control" required="" value="<?php
                                if($update){
                                    echo $company->career_type;
                                }
                                ?>"/>
                            </div>
                        </div>
                        <div class="form-group" style="text-align: left;margin-left: 0.5em">
                            企业性质<font color="red">*</font></div>
                        <div class="form-group">
                            <div class="col-sm-12"><input type="text" name="company_nature" class="form-control" required="" value="<?php
                                if($update){
                                    echo $company->company_nature;
                                }
                                ?>"/>
                            </div>
                        </div>
                        <div class="form-group" style="text-align: left;margin-left: 0.5em">
                            办公地址<font color="red">*</font></div>
                        <div class="form-group">
                            <div class="col-sm-12"><input type="text" name="location" class="form-control" required="" value="<?php
                                if($update){
                                    echo $company->location;
                                }
                                ?>"/>
                            </div>
                        </div>
                        <div class="form-group" style="text-align: left;margin-left: 0.5em">
                            联系人<font color="red">*</font></div>
                        <div class="form-group">
                            <div class="col-sm-12"><input type="text" name="contactor" class="form-control" required="" value="<?php
                                if($update){
                                    echo $company->contactor;
                                }
                                ?>"/>
                            </div>
                        </div>
                        <div class="form-group" style="text-align: left;margin-left: 0.5em">
                            联系电话<font color="red">*</font></div>
                        <div class="form-group">
                            <div class="col-sm-12"><input type="text" name="tel" class="form-control" required="" value="<?php
                                if($update){
                                    echo $company->tel;
                                }
                                ?>"/>
                            </div>
                        </div>
                        <div class="form-group" style="text-align: left;margin-left: 0.5em">
                            邮箱<font color="red">*</font></div>
                        <div class="form-group">
                            <div class="col-sm-12"><input type="text" name="email" class="form-control" required="" value="<?php
                                if($update){
                                    echo $company->email;
                                }
                                ?>"/>
                            </div>
                        </div>
                        <div class="form-group" style="text-align: left;margin-left: 0.5em">
                            您认为校友会能为贵单位做些什么：</div>
                        <div class="form-group">
                            <div class="col-sm-12"><textarea name="descript" class="form-control"><?php
                                    if($update){
                                        echo $company->descript;
                                    }
                                    ?></textarea>
                            </div>
                        </div>
                        <input value="<?php echo $openid?>" name="openid" type="hidden" />
                        <input value="<?php echo $update?>" name="update" type="hidden" />
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div style="text-align: center">
                                <button class="btn btn-primary" type="submit">提交</button>
                            </div>
                        </div>
                    </form>
                    <div class="font_footer">成都涪诚汇科技有限公司<br />Power By Zengguoqiang<br /></div>
                </div>
            </div>
        </div>
    </div>
</div>
<img class="bg_img" src="./images/bg.jpg">
<script src="/libs/jquery.min.js"></script>
<script src="/libs/bootstrap.min.js"></script>
<script src="/libs/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(function () {
        $("#data_2 .input-group.date").datepicker({
            startView: 1,
            todayBtn: "linked",
            keyboardNavigation: !1,
            forceParse: !1,
            autoclose: !0,
            format: "yyyy-mm-dd"
        });
    });
</script>
<!-- Mirrored from www.zi-han.net/theme/hplus/form_basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:19:15 GMT -->
</body>
</html>
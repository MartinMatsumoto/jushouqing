<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>绵阳职业技术学院-成都校友会</title>
    <meta name="Keywords" content="成都校友会,聚首情">
    <meta name="Description" content="绵阳职业技术学院-成都校友会">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/common.css" rel="stylesheet">
    <link href="/css/header.css" rel="stylesheet">
    <link href="/css/footer.css" rel="stylesheet">
    <link href="/css/navigator.css" rel="stylesheet">
    <link href="./css/essay.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/swiper-3.3.1.min.css?20160324">
</head>
<body>
<?php
require_once '../entrance.php';
?>
<!-- 顶部 开始 -->
<?php
include '../include/header.php'
?>
<!-- 顶部 结束 -->
<!-- 导航 开始 -->
<?php
include '../include/navigator.php';
$type = empty($_GET["type"]) ? 1 : $_GET["type"];
?>
<!-- 导航 结束 -->

<div class="essay_container">
    <div class="essay_content">
        <?php
        include './include/content_title.php'
        ?>

        <div class="content_content">
            <div class="title_container">
                公司动态&nbsp;&nbsp;&gt;&nbsp;&nbsp;发现
            </div>
            <ul>
                <?php
                $dao = new essay_dao();
                $result = $dao->listEssays(0, 100, $type, 0);
                while ($row = $result->fetch()) {
                    $essay = new essay($row);
                    ?>
                    <li>
                        <a href="/essay/content.php?id=<?php echo $essay->id?>&type=<?php echo $essay->type?>">
                            <p class="title"><?php echo $essay->title?></p>
                            <p class="time"><?php echo $essay->create_date?></p>
                            <p class="subtitle"><?php echo $essay->sub_title?></p>
                        </a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>

        <div class="clear"></div>
    </div>

</div>


<!-- footer 开始 -->
<?php
include '../include/footer.php'
?>
<!-- footer 结束 -->
<script type="text/javascript" src="/libs/jquery.min.js"></script>
<script type="text/javascript" src="/libs/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/index.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
</body>
</html>
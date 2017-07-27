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
include '../include/navigator.php'
?>
<!-- 导航 结束 -->
<?php
$type = empty($_GET["type"]) ? 1 : $_GET["type"];
$id = empty($_GET["id"]) ? 0 : $_GET["id"];
$dao = new essay_dao();
$essay_content_dao = new essay_content_dao();
if($id != 0){
    $result = $dao->getOne($id);
    $row = $result->fetch();
    $essay = new essay($row);

    $content_result = $essay_content_dao->listEssayContents($id);

    $prevResult = $dao->getPrev($id);
    $nextResult = $dao->getNext($id);
    $prevEssay = new essay($prevResult->fetch());
    $nextEssay = new essay($nextResult->fetch());
}else{
    $essay = new essay();
}

?>
<div class="essay_container">
    <div class="essay_content">
        <?php
        include './include/content_title.php'
        ?>

        <div class="content_content">
            <div class="title_container">
                公司动态&nbsp;&nbsp;&gt;&nbsp;&nbsp;发现
            </div>

            <div class="essay_title" >
                <?php echo $essay->title?>
            </div>

            <div class="essay_subtitle">
                作者:<span><?php echo $essay->author?></span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                发布时间: <span><?php echo $essay->create_date?></span>
            </div>

            <div class="essay_intro">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo $essay->sub_title?>
            </div>

            <div class="essay">
                <?php
                while ($row = $content_result->fetch()) {
                    $essay_content = new essay_content($row);
                    ?>
                    <?php
                    if($essay_content -> type == 1){
                        ?>
                        <div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo $essay_content->content?>
                        </div>
                        <?php
                    }
                    ?>

                    <?php
                    if($essay_content -> type == 2){
                        ?>
                        <div class="essay_image">
                            <img src="<?php echo $essay_content->content?>"/>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                }
                ?>
            </div>

            <div class="next_prev">
                <a href="<?php
                if(!empty($prevEssay->id)){
                    echo "/essay/content.php?id=".$prevEssay->id."&type=".$type;
                }
                ?>"><span class="next">上一篇</span>：<?php
                    if(empty($prevEssay->title)){
                        echo "没有了";
                    }else{
                        echo $prevEssay->title;
                    }
                    ?></a>
                <a href="<?php
                if(!empty($nextEssay->id)){
                    echo "/essay/content.php?id=".$nextEssay->id."&type=".$type;
                }
                ?>"><span class="next">下一篇</span>：<?php
                    if(empty($nextEssay->title)){
                        echo "没有了";
                    }else{
                        echo $nextEssay->title;
                    }
                    ?></a>
            </div>
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
<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2017/1/9
 * Time: 15:01
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>绵阳职业技术学院-成都校友会</title>
    <meta name="Keywords" content="成都校友会,聚首情">
    <meta name="Description" content="绵阳职业技术学院-成都校友会">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/index.css" rel="stylesheet">
    <link href="/css/header.css" rel="stylesheet">
    <link href="/css/navigator.css" rel="stylesheet">
    <link href="/css/footer.css" rel="stylesheet">
    <link href="/css/common.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/swiper-3.3.1.min.css">
</head>
<body>
<?php
require_once 'entrance.php';
$banner_dao = new index_banner_dao();
$index_content_dao = new index_content_dao();
?>
<!-- 顶部 开始 -->
<?php
include './include/header.php'
?>
<!-- 顶部 结束 -->
<!-- 导航 开始 -->
<?php
include './include/navigator.php'
?>
<!-- 导航 结束 -->
<!-- banner 开始 -->
<div class="swiper-container swiper_box">
    <div class="slider_box">
        <div class="swiper-wrapper">
        <?php
            $result = $banner_dao->listBanners();
            while ($row = $result->fetch()) {
                $banner = new index_banner($row);
                ?>
                <div class="swiper-slide">
                    <img src="<?php echo $banner->image_url?>" alt="" class="swiper-slide"/>
                    <div class="banner_text_container">
                        <span class="big"><?php echo $banner->text1?></span>
                        <span class="big"><?php echo $banner->text2?></span>
                        <span class="small"><?php echo $banner->text3?></span>
                        <span class="small"><?php echo $banner->text2?></span>
                    </div>
                </div>
                <?php
            }
        ?>
        </div>
        <!-- 如果需要导航按钮 -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>
<!-- banner 结束 -->
<?php
    $result = $index_content_dao->getOne(1);
    $aboutus_content = new index_content($row = $result->fetch());
?>
<!-- 关于我们 开始 -->
<div class="about_us_container">
    <div class="about_us">
        <div class="title">
            <span class="text">关于我们</span>
            <div class="decoration_line">
                <div class="decoration_line_left"></div>
                <div class="decoration_line_right"></div>
            </div>
        </div>
        <div class="content">
            <img src="<?php echo $aboutus_content->image_url?>" />
            <div class="right_content">
                <span class="text"><?php echo $aboutus_content->content?></span>
                <div class="read_more">
                    <a href="<?php echo $aboutus_content->href_url?>">
                        <div class="left_readmore">READ MORE</div>
                        <div class="right_readmore">+</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 关于我们 结束 -->
<!-- 公司动态 开始 -->
<?php
$result = $index_content_dao->listCompanyActive();
?>
<div class="company_action_container">
    <div class="company_action">
        <div class="title">
            <span class="text">公司动态</span>
            <div class="decoration_line">
                <div class="decoration_line_left"></div>
                <div class="decoration_line_right"></div>
            </div>
        </div>

        <?php
            $index = 0;
            while ($row = $result->fetch()) {
                $index ++;
                $index_content = new index_content($row);
                ?>
                    <div class="show<?php echo $index?>" id="index_show">
                        <a href="<?php echo $index_content->href_url?>">
                            <img src="<?php echo $index_content->image_url?>" alt=""/>
                            <div class="content<?php echo ($index == 1 || $index == 6) ? 1 : 2?>" id="index_show_content">
                                <div class="bg opacity">
                                    <div class="small"></div>
                                </div>
                                <div class="text_show"><?php echo $index_content->content?></div>
                            </div>
                        </a>
                    </div>
                <?php
            }
        ?>


        <!--<div class="show2" id="index_show">
            <a href="http://www.baidu.com">
                <img src="/images/pic02.jpg" alt=""/>
                <div class="content2" id="index_show_content">
                    <div class="bg opacity">
                        <div class="small"></div>
                    </div>
                    <div class="text_show">工业机械</div>
                </div>
            </a>
        </div>
        <div class="show3" id="index_show">
            <a href="http://www.baidu.com">
                <img src="/images/pic03.jpg" alt=""/>
                <div class="content2" id="index_show_content">
                    <div class="bg opacity">
                        <div class="small"></div>
                    </div>
                    <div class="text_show">工业机械</div>
                </div>
            </a>
        </div>
        <div class="show4" id="index_show">
            <a href="http://www.baidu.com">
                <img src="/images/pic04.jpg" alt=""/>
                <div class="content2" id="index_show_content">
                    <div class="bg opacity">
                        <div class="small"></div>
                    </div>
                    <div class="text_show">工业机械</div>
                </div>
            </a>
        </div>
        <div class="show5" id="index_show">
            <a href="http://www.baidu.com">
                <img src="/images/pic05.jpg" alt=""/>
                <div class="content2" id="index_show_content">
                    <div class="bg opacity">
                        <div class="small"></div>
                    </div>
                    <div class="text_show">工业机械</div>
                </div>
            </a>
        </div>
        <div class="show6" id="index_show">
            <a href="http://www.baidu.com">
                <img src="/images/pic06.jpg" alt=""/>
                <div class="content1" id="index_show_content">
                    <div class="bg opacity">
                        <div class="small"></div>
                    </div>
                    <div class="text_show">工业机械</div>
                </div>
            </a>
        </div>-->
        <div class="clear"></div>
    </div>
</div>
<!-- 公司动态 结束 -->
<!-- footer 开始 -->
<?php
include './include/footer.php'
?>
<!-- footer 结束 -->
<script type="text/javascript" src="/libs/jquery.min.js"></script>
<script type="text/javascript" src="/libs/bootstrap.min.js"></script>
<script type="text/javascript" src="/libs/swiper-3.3.1.min.js"></script>
<script type="text/javascript">
    var mySwiper = new Swiper ('.slider_box', {
        direction : 'horizontal',
        loop : true,
        paginationClickable: true,
        // 如果需要前进后退按钮
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        bulletActiveClass : 'swiper-now',
        autoplayDisableOnInteraction : false,
        autoplay : 5000
    });
</script>
<script type="text/javascript" src="/js/index.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
</body>
</html>
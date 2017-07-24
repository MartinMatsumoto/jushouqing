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
    <link rel="stylesheet" href="/css/swiper-3.3.1.min.css">
</head>
<body>
<?php
require_once 'entrance.php';
$banner_dao = new index_banner_dao();
?>
<!-- 顶部 开始 -->
<div class="header">
    <div class="header_content">
        <div class="contact_us">
            <img src="/images/tel.png"/>
            <em class="tel_text">咨询热线</em>
            <em class="tel_tel">65773655转833</em>
        </div>
    </div>
</div>
<!-- 顶部 结束 -->
<!-- 导航 开始 -->
<div class="nav">
    <div class="content">
        <ul class="nav_ul">
            <li class="nav_li" id="index_li_hover">网站首页</li>
            <ul class="menu child1 hide" id="index_ul">
                <li class="nav_li choose float"><a href="http://baidu.com" target="_blank">校友会</a></li>
                <li class="nav_li choose float"><a href="http://baidu.com" target="_blank">涪城汇</a></li>
            </ul>
            <li class="nav_li" id="index_li_hover">公司动态</li>
            <ul class="menu child2 hide" id="index_ul">
                <li class="nav_li choose float"><a href="http://baidu.com" target="_blank">文章</a></li>
                <li class="nav_li choose float"><a href="http://baidu.com" target="_blank">视频</a></li>
            </ul>
            <li class="nav_li" id="index_li_hover">公司产品</li>
            <ul class="menu child3 hide" id="index_ul">
                <li class="nav_li choose float"><a href="http://baidu.com" target="_blank">聚首情酒</a></li>
                <li class="nav_li choose float"><a href="http://baidu.com" target="_blank">溯源</a></li>
            </ul>
            <li class="nav_li"><a href="http://baidu.com" target="_blank">联系我们</a></li>
        </ul>
    </div>
</div>
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
                    <img src="<?php echo $banner->image_url?>" alt=""/>
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
            <!--<div class="swiper-slide">
                <img src="images/banner1.jpg" alt=""/>
                <div class="banner_text_container">
                    <span class="big">大字大字大字大字大字大字大字大字大字</span>
                    <span class="big">大字大字大字大字大字大字大字大字大字</span>
                    <span class="small">The pursuit of excellence, casting assured brand</span>
                    <span class="small">China is famous, renowned in the world, the same principle, not the same benefit</span>
                </div>
            </div>
            <div class="swiper-slide">
                <img src="images/banner2.jpg" alt=""/>
                <div class="banner_text_container">
                    <span class="big">大字大字大字大字大字大字大字大字大字</span>
                    <span class="big">大字大字大字大字大字大字大字大字大字</span>
                    <span class="small">The pursuit of excellence, casting assured brand</span>
                    <span class="small">China is famous, renowned in the world, the same principle, not the same benefit</span>
                </div>
            </div>-->
        </div>
        <!-- 如果需要导航按钮 -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>
<!-- banner 结束 -->
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
            <img src="/images/about.jpg" />
            <div class="right_content">
                <span class="text">公司技术力量雄厚，化验、检测设备优良，拥有较先进的生产设备。公司拥有员工21000人，其中专业技术人员4000余人。占地面积50万平方米，建筑面积23万平方米，是XX市“百强私营企业”“XX市重点发展十强私营企业”首批获得自营进口权的企业之一。1998年通过ISO9002国际质量体系认证2008年又通过转版获得ISO9001国际质量体系认证，2002年通过“CCC”国家产品强制认证，被中国农业银行XX市分行评为“AAA”级信用企业，XX省重合同，守信用企业。产品通过欧盟环保认证（ROHS REACH , PAHS）等。公司主要生产工业设备，车削机床，铣削机床，五金模具，工程机械，工业助剂等以及其它各种规格的橡胶制品、塑料制品、金属制品及轴承。产品远销100多个国家，高质量的产品赢得用户的好评。</span>
                <div class="read_more">
                    <div class="left_readmore">READ MORE</div>
                    <div class="right_readmore">+</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 关于我们 结束 -->
<!-- 公司动态 开始 -->
<div class="company_action_container">
    <div class="company_action">
        <div class="title">
            <span class="text">公司动态</span>
            <div class="decoration_line">
                <div class="decoration_line_left"></div>
                <div class="decoration_line_right"></div>
            </div>
        </div>
        <div class="show1" id="index_show">
            <a href="http://www.baidu.com" target="_blank">
                <img src="/images/pic01.jpg" alt=""/>
                <div class="content1" id="index_show_content">
                    <div class="bg opacity">
                        <div class="small"></div>
                    </div>
                    <div class="text_show">工业机械</div>
                </div>
            </a>
        </div>
        <div class="show2" id="index_show">
            <a href="http://www.baidu.com" target="_blank">
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
            <a href="http://www.baidu.com" target="_blank">
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
            <a href="http://www.baidu.com" target="_blank">
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
            <a href="http://www.baidu.com" target="_blank">
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
            <a href="http://www.baidu.com" target="_blank">
                <img src="/images/pic06.jpg" alt=""/>
                <div class="content1" id="index_show_content">
                    <div class="bg opacity">
                        <div class="small"></div>
                    </div>
                    <div class="text_show">工业机械</div>
                </div>
            </a>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!-- 公司动态 结束 -->
<!-- footer 开始 -->
<div class="footer">
    <div class="content">
        <div class="text_container">
            <span>咨询热线：65773655转833</span>&nbsp;&nbsp;&nbsp;&nbsp;
            <span>客服QQ：472742770</span>&nbsp;&nbsp;&nbsp;&nbsp;
            <span>联系人：刘亚兰</span>
            <br/>
            <span>公司地址：四川省成都市武侯区火炬时代B区102室</span>
            <br/>
            <span>Copyright © 2009-2017,www.jushouqing.top,All rights reserved  蜀ICP备17000647号</span>
        </div>
        <div class="wx_container">
            <img src="/images/er.jpg" alt=""/>
            <div>微信公众号</div>
        </div>
    </div>
</div>
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
</body>
</html>
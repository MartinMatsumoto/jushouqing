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
    <link rel="stylesheet" href="/css/swiper-3.3.1.min.css?20160324">
</head>
<body>
<!-- 顶部 开始 -->
<div class="header">
    <div class="header_content">
        <div class="contact_us">
            <img src="/images/tel.png"/>
            <em class="tel_text">咨询热线</em>
            <em class="tel_tel">400-000-00xxxx</em>
        </div>
    </div>
</div>
<!-- 顶部 结束 -->
<!-- 导航 开始 -->
<div class="nav">
    <div class="content">
        <ul>
            <li class="choose">网站首页</li>
            <li>网站首页</li>
            <li>网站首页</li>
            <li>网站首页</li>
        </ul>
    </div>
</div>
<!-- 导航 结束 -->
<!-- banner 开始 -->
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <img src="images/banner1.jpg" alt=""/>
        </div>
        <div class="swiper-slide">
            <img src="images/banner2.jpg" alt=""/>
        </div>
    </div>
    <!-- 如果需要分页器 -->
    <div class="focus_box swiper-pagination">
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
        <div class="show1">
            <img src="/images/pic01.jpg" alt=""/>
        </div>
        <div class="show2">
            <img src="/images/pic02.jpg" alt=""/>
        </div>
        <div class="show3">
            <img src="/images/pic03.jpg" alt=""/>
        </div>
        <div class="show4">
            <img src="/images/pic04.jpg" alt=""/>
        </div>
        <div class="show5">
            <img src="/images/pic05.jpg" alt=""/>
        </div>
        <div class="show6">
            <img src="/images/pic06.jpg" alt=""/>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!-- 公司动态 结束 -->
<!-- footer 开始 -->
<div class="footer">
    <div class="content">
        <div class="text_container">
            <span>咨询热线：400-000-000000</span>
            <span>客服QQ：1234XX987</span>
            <span>联系人：陈先生</span>
            <br/>
            <span>公司地址：中国上海市XXX区XXX路12号MOUMOU大厦5层5xx室</span>
            <br/>
            <span>Copyright © 2009-2011,www.jushouqing.top,All rights reserved  蜀ICP备17000647号</span>
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
<script type="text/javascript" src="/js/swiper-3.3.1.min.js"></script>
<script type="text/javascript">
    var mySwiper = new Swiper ('.swiper-container', {
        direction : 'horizontal',
        loop : true,
        paginationClickable: true,
        // 如果需要分页器
        pagination : '.swiper-pagination',
        bulletActiveClass : 'swiper-now',
        autoplayDisableOnInteraction : false,
        autoplay : 5000
    });
</script>
</body>
</html>
/**
 * Created by Acer on 2016/9/19.
 */
define(function(require, exports, module) {

    /** 主页url */
    exports.mainHref = "/";
    /** 题库url */
    exports.tikuHref = "/tiku.php";
    /** 个人空间url */
    exports.spaceHref = "/space.php";
    /** 免责声明url */
    exports.mianzeHref = "/mianze.php";
    /** 服务条款url */
    exports.fuwuHref = "/fuwu.php";
    /** 联系我们url */
    exports.contactHref = "/contact.php";

    /** 获取习题列表 */
    exports.listPraxis = "/xiti/structure/controller/list_praxis.php";
    /** 获取一道习题 */
    exports.getOnePraxis = "/xiti/structure/controller/get_one_praxis.php";
    /** 登录 */
    exports.login = "/xiti/structure/controller/user/login.php";
    /** 注册 */
    exports.register = "/xiti/structure/controller/user/register.php";
    /** 验证账号密码是否使用 */
    exports.authExist = "/xiti/structure/controller/user/auth_exist.php";
    /** 图片header */
    exports.imageHeader = "http://www.sosoti.com";
    /** 登录 */
    exports.addFavorite = "/xiti/structure/controller/user/add_favorite.php";
    /** 获取习题列表 */
    exports.listFavoritePraxis = "/xiti/structure/controller/user/list_favorite.php";
});

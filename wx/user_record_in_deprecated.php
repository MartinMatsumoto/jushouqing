<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>绵职院校友会-信息录入</title>
    <link href="./css/user_record_in.css" rel="stylesheet" type="text/css"/>
    <link href="./css/mask.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/libs/jquery.min.js"></script>
</head>
<body>
<?php
require_once '../entrance.php';
require_once './include/get_open_id.php';
require_once './include/get_user_info.php';
$area_dao = new area_dao();
$major_dao = new major_dao();
$department_dao = new department_dao();
$user_dao = new user_dao();

//$openid = "oC00gxAxQ8KdPWbyEoOCOEGmbQiw";

$result = $user_dao->getOne($openid);
while ($row = $result->fetch()) {
    $user = new user($row);
}
?>
<input id="open_id" value="<?php echo $openid ?>" type="hidden"/>

<div style="display: none;" id="divider_container">
    <?php
    $result = $department_dao->listDividers();
    while ($row = $result->fetch()) {
        $major = new major($row);
        echo "<input value='$row[name]' type=\"hidden\">";
    }
    ?>
</div>
<?php include './include/dialog_mask.php'; ?>

<div class="content_container">
    <div>
        <span class="logo_text">通讯录</span>
        <span class="logo_subtitle">绵职院成都校友会</span>
    </div>
    <input placeholder="请输入姓名" class="input_style" id="user_name" value="<?php
    if (!empty($user)) {
        echo $user->name;
    } ?>"/>

    <div class="sex_container">
        <span>请选择性别：</span>
        <input type="radio" id="male_radio" name="sex" value="1"
            <?php
            if (!empty($user) && $user->sex == 1) {
                ?>
                checked='checked'
                <?php
            }
            ?>
        /><label for="male_radio">男</label>
        <input type="radio" id="female_radio" name="sex" value="2"
            <?php
            if (!empty($user) && $user->sex == 2) {
                ?>
                checked='checked'
                <?php
            }
            ?>
        /><label for="female_radio">女</label>
    </div>
    <input placeholder="请输入联系方式" class="input_style" id="user_contact" value="<?php
    if (!empty($user)) {
        echo $user->contact;
    } ?>"/>
    <span class="sex_container">请选择工作所在地：</span>
    <select id="province_select" name='province_select' class="select_style" style="margin-right : 20px;">
        <?php
        if (!empty($user)) {
            $cityid = $user->area_id;
            $result = $area_dao->getCityProvince($cityid);
            while ($row = $result->fetch()) {
                $province = new area($row);
            }
        }

        if (!empty($province)) {
            $provinceId = $province->id;
        } else {
            $provinceId = $area_dao->sichuanId;
        }
        $result = $area_dao->listProvince();
        while ($row = $result->fetch()) {
            $area = new area($row);
            if ($area->id == $provinceId) {
                echo "<option id=\"$area->id\" value=\"$area->id\" selected='selected'>$area->name</option>";
            } else {
                echo "<option id=\"$area->id\" value=\"$area->id\">$area->name</option>";
            }
        }
        ?>
    </select>
    <select id='city_select' name='city_select' class="select_style">
        <?php
        $result = $area_dao->listByProvince($provinceId);

        if (empty($cityid)) {
            $cityid = $area_dao->sichuanId;
        }
        echo $cityid;

        while ($row = $result->fetch()) {
            $area = new area($row);
            if ($area->id == $cityid) {
                echo "<option id=\"$area->id\" value=\"$area->id\" selected='selected'>$area->name</option>";
            } else {
                echo "<option id=\"$area->id\" value=\"$area->id\">$area->name</option>";
            }
        }
        ?>
    </select>
    <span class="sex_container">请选择入学年份：</span>
    <select id="year_select" name='year_select' class="date_style year_style">
    </select>
    <span class="date_span">年</span>
    <select id="month_select" name='month_select' class="date_style month_style">
    </select>
    <span class="date_span">月</span>
    <select id="date_select" name='date_select' class="date_style month_style">
    </select>
    <span class="date_span">日</span>
    <span class="sex_container">请选择专业：</span>
    <select id="department_select" name='department_select' class="select_style" style="margin-right : 20px;
    <?php
    $yearArr = explode("-", $user->school_date);
    $currYear = intval($yearArr[0]);
    if (!empty($user) && $currYear < 2002) { ?>
        display:none
    <?php } ?>">
        <?php
        if (!empty($user)) {
            $departmentId = $user->department_id;
        } else {
            $departmentId = $department_dao->renwenkexueRoot;
        }
        $result = $department_dao->listUseful();
        while ($row = $result->fetch()) {
            $department = new department($row);
            ?>
            <option id="<?php echo $department->id ?>" value="<?php echo $department->id ?>"
                <?php if (!empty($departmentId) && $department->id == $departmentId) { ?>
                    selected='selected'
                <?php } ?>
            ><?php echo $department->name ?></option>
            <?php
        }
        ?>
        <option id="-2" value="-2"<?php if (!empty($departmentId) && -2 == $departmentId) { ?>
            selected='selected'
        <?php } ?>>自定义
        </option>
    </select>
    <select id='major_select' name='major_select' class="select_style">
        <?php
        if (!empty($user)) {
            $majorId = $user->major_id;
        }
        if (!empty($departmentId) && $departmentId == -1) {
            $result = $major_dao->listBySiblings($majorId);
        } else {
            $result = $major_dao->listByParent($departmentId);
        }

        while ($row = $result->fetch()) {
            $major = new major($row);
            ?>
            <option id="<?php echo $major->id ?>" value="<?php echo $major->id ?>"
                <?php if (!empty($majorId) && $major->id == $majorId) { ?>
                    selected='selected'
                <?php } ?>
            ><?php echo $major->name ?></option>
            <?php
        }
        ?>
        <option id="-2" value="-2" <?php if (!empty($majorId) && -2 == $majorId) { ?>
            selected='selected'
        <?php } ?>>自定义
        </option>
    </select>
    <select style="display:none" id='major_old_select' name='major_old_select' class="select_style major_old_style">
    </select>

    <input placeholder="请输入自定义系别" class="input_style" id="custom_department"
           style="<?php if (empty($departmentId) || -2 != $departmentId || $currYear < 2002) { ?>
               display:none
           <?php } ?>" value="<?php
    if (!empty($user)) {
        echo $user->custom_department;
    } ?>"/>
    <input placeholder="请输入自定义专业" class="input_style" id="custom_major"
           style="<?php if (empty($majorId) || -2 != $majorId) { ?>
               display:none
           <?php } ?>" value="<?php
    if (!empty($user)) {
        echo $user->custom_major;
    } ?>"/>

    <?php
    if (empty($user)) {
        ?>
        <div class="submit" id="submit">提交</div>
        <?php
    } else {
        ?>
        <div class="submit" id="modify">修改</div>
        <?php
    }
    ?>

</div>

<option id="option_hide" style="display:none"></option>
<script type="text/javascript">
    $(function () {
        <?php
            if(!empty($user)){
        ?>
        var globalDate = new Date(Date.parse(('<?php echo $user->school_date ?>').replace(/-/g, "/")));
        <?php
            }else{
        ?>
        var globalDate = new Date();
        <?php
            }
        ?>
        var currYear = <?php echo $currYear?>;

        var yearSelect = $("#year_select");
        var monthSelect = $("#month_select");
        var dateSelect = $("#date_select");
        var provinceSelect = $("#province_select");
        var citySelect = $("#city_select");
        var dividerContainer = $("#divider_container");

        var majorOldSelect = $("#major_old_select");
        var majorSelect = $("#major_select");
        var departmentSelect = $("#department_select");

        var alertDialog = $("#alert_dialog");
        var alertDialogText = $("#alert_dialog_text");
        var waitingDialogText = $("#waiting_dialog_text");
        var alertConfirm = $("#alert_confirm");
        var waitingContainer = $("#waiting_container");
        var alertContainer = $("#alert_container");

        var submitButton = $("#submit");
        var modifyButton = $("#modify");
        var sichuan = 2700;
        var chengdu = 2701;
        var defaultmajorId = 1;

        var old = false;
        var maskshow = false;
        var isCustomMajor = false;
        var isCustomDepartment = false;
        var dividerYears = [];
        var customDepartment = $("#custom_department");
        var customMajor = $("#custom_major");

        //var divideDate = new Date(Date.parse((2001 + "-" + 1 + "-" + 1).replace(/-/g, "/")));
        var divideYear = 2002;

        var loadingtext = "加载中，请稍后。";
        var errortext = "服务器错误，请重试。";

        var initDivider = function () {
            var dividerInputs = dividerContainer.children();
            for (var i = 0; i < dividerInputs.length; i++) {
                var dividerYear = $(dividerInputs[i]).val();
                if (!isNaN(dividerYear)) {
                    dividerYears.push(dividerYear);
                }
            }
        }
        initDivider();

        var getCurrentMonthLast = function (date) {
            var currentMonth = date.getMonth();

            var nextMonth = ++currentMonth;
            var nextMonthFirstDay = new Date(date.getFullYear(), nextMonth, 1);
            var oneDay = 1000 * 60 * 60 * 24;
            var dateResult = new Date(nextMonthFirstDay - oneDay);
            return dateResult.getDate();
        }

        var onDateChange = function () {
            var year = yearSelect.val();
            var month = monthSelect.val();
            //var date = dateSelect.val();
            //globalDate = new Date(year + "-" + month + "-" + 1);

            globalDate = new Date(Date.parse((year + "-" + month + "-" + 1).replace(/-/g, "/")));
            //alert(date11);
            initDate();
            changeMajor();
        }

        var initYear = function () {
            var yearStart = 1900;
            var cDate = new Date();
            var endYear = cDate.getFullYear();
            if (!currYear) {
                currYear = endYear;
            }
            monthSelect.empty();
            for (var i = yearStart; i <= endYear; i++) {
                var optionClone = $("#option_hide").clone(true);
                optionClone.html(i);
                optionClone.css("display", "block");
                optionClone.attr("id", "");
                optionClone.attr("value", i);
                if (i == currYear) {
                    optionClone.attr("selected", "selected");
                }
                yearSelect.append(optionClone);
            }

        }

        var initMonth = function () {
            var monthStart = 1;
            var monthEnd = 12;
            var thisMonth = globalDate.getMonth() + 1;
            monthSelect.empty();
            for (var i = monthStart; i <= monthEnd; i++) {
                var optionClone = $("#option_hide").clone(true);
                optionClone.html(i);
                optionClone.css("display", "block");
                optionClone.attr("id", "");
                optionClone.attr("value", i);
                if (i == thisMonth) {
                    optionClone.attr("selected", "selected");
                }
                monthSelect.append(optionClone);
            }
        }

        var initDate = function () {

            var dateStart = 1;
            var dateEnd = getCurrentMonthLast(globalDate);
            var thisDate = globalDate.getDate();
            dateSelect.empty();
            for (var i = dateStart; i <= dateEnd; i++) {
                var optionClone = $("#option_hide").clone(true);
                optionClone.html(i);
                optionClone.css("display", "block");
                optionClone.attr("id", "");
                optionClone.attr("value", i);
                if (i == thisDate) {
                    optionClone.attr("selected", "selected");
                }
                dateSelect.append(optionClone);
            }
        }

        yearSelect.bind("change", onDateChange);
        monthSelect.bind("change", onDateChange);
        dateSelect.bind("change", function () {
            var year = yearSelect.val();
            var month = monthSelect.val();
            var date = dateSelect.val();
            globalDate = new Date(year + "-" + month + "-" + date);
            changeMajor();
        });
        initYear();
        initMonth();
        initDate();

        /*var initProvince = function () {
         showloading(loadingtext);
         $.ajax({
         type: "post",
         dataType: "json",
         url: "/zengguoqiang/get_area_by_parent_id.htm",
         data: {parentId: 0},
         success: function (data) {
         if (data.errorCode == 1) {
         var contentArr = data.content;
         for (var i = 0; i < contentArr.length; i++) {
         var content = contentArr[i];
         var optionClone = $("#option_hide").clone(true);
         optionClone.html(content.name);
         optionClone.css("display", "block");
         optionClone.attr("id", content.id);
         optionClone.attr("value", content.id);
         if (content.id == sichuan) {
         optionClone.attr("selected", "selected");
         }
         provinceSelect.append(optionClone);
         }
         }
         provinceInit = true;
         authAllinit();
         },
         error: function () {

         }
         });
         }*/

        provinceSelect.bind("change", function () {
            var provinceId = provinceSelect.val();
            listCity(provinceId);
        });

        var listCity = function (parentId) {
            showloading(loadingtext);
            citySelect.empty();
            $.ajax({
                type: "post",
                dataType: "json",
                url: "/structure/maptree/controller/area_list_by_province.php",
                data: {
                    parentId: parentId
                },
                success: function (data) {
                    if (data.errorCode == 1) {
                        var contentArr = data.content;
                        for (var i = 0; i < contentArr.length; i++) {
                            var content = contentArr[i];
                            var optionClone = $("#option_hide").clone(true);
                            optionClone.html(content.name);
                            optionClone.css("display", "block");
                            optionClone.attr("id", content.id);
                            optionClone.attr("value", content.id);
                            if (content.id == sichuan) {
                                optionClone.attr("selected", "selected");
                            }
                            citySelect.append(optionClone);
                        }
                    }
                    cityInit = true;
                    hideloading();
                },
                error: function () {
                    changeloading(errortext);
                }
            });
        }

        var changeMajor = function () {
            var yearChoose = globalDate.getFullYear();
            if (divideYear > yearChoose) {
                //所选时间小于2002年
                majorOldSelect.show();
                majorSelect.hide();
                departmentSelect.hide();
                old = true;
                initMajorOld(getDivideYearDetail(yearChoose));
                customMajor.hide();
            } else {
                //所选时间大于等于2002年
                majorOldSelect.hide();
                majorSelect.show();
                departmentSelect.show();
                old = false;
                var majorId = majorSelect.val();
                changeMajorStatus(majorId);
            }
        }

        var changeMajorStatus = function (majorId) {
            if (majorId == -2) {
                customMajor.show();
                isCustomMajor = true;
            } else {
                customMajor.hide();
                isCustomMajor = false;
            }
        }

        var changeDepartmentStatus = function (departmentId) {
            if (departmentId == -2) {
                customDepartment.show();
                customMajor.show();
                isCustomMajor = true;
                isCustomDepartment = true;
            } else {
                customDepartment.hide();
                customMajor.hide();
                isCustomMajor = false;
                isCustomDepartment = false;
            }
        }


        //获得具体取哪一年的信息
        var getDivideYearDetail = function (yearChoose) {
            for (var i = 0; i < dividerYears.length; i++) {
                var divideYearGet = dividerYears[i];
                if (yearChoose >= divideYearGet) {
                    return divideYearGet;
                }
            }
            return dividerYears[dividerYears.length - 1];
        }

        /*var initDepartment = function () {
         showloading(loadingtext);
         departmentSelect.empty();
         $.ajax({
         type: "post",
         dataType: "json",
         url: "/zengguoqiang/get_department.htm",
         data: {},
         success: function (data) {
         if (data.errorCode == 1) {
         var contentArr = data.content;
         for (var i = 0; i < contentArr.length; i++) {
         var content = contentArr[i];
         var optionClone = $("#option_hide").clone(true);
         optionClone.html(content.name);
         optionClone.css("display", "block");
         optionClone.attr("id", content.id);
         optionClone.attr("value", content.id);
         if (content.id == sichuan) {
         optionClone.attr("selected", "selected");
         }
         departmentSelect.append(optionClone);
         }
         }
         departmentInit = true;
         authAllinit();
         },
         error: function () {

         }
         });
         }*/
        departmentSelect.bind("change", function () {
            var departmentId = departmentSelect.val();
            initMajor(departmentId);
            changeDepartmentStatus(departmentId);
        });

        majorOldSelect.bind("change", function () {
            var majorId = majorOldSelect.val();
            changeMajorStatus(majorId);
        });

        majorSelect.bind("change", function () {
            var majorId = majorSelect.val();
            changeMajorStatus(majorId);
        });

        var initMajor = function (parentId) {
            showloading(loadingtext);
            majorSelect.empty();
            $.ajax({
                type: "post",
                dataType: "json",
                url: "/structure/maptree/controller/major_list_by_department.php",
                data: {parentId: parentId},
                success: function (data) {
                    if (data.errorCode == 1) {
                        var contentArr = data.content;
                        addCustomeData(contentArr);
                        for (var i = 0; i < contentArr.length; i++) {
                            var content = contentArr[i];
                            var optionClone = $("#option_hide").clone(true);
                            optionClone.html(content.name);
                            optionClone.css("display", "block");
                            optionClone.attr("id", content.id);
                            optionClone.attr("value", content.id);
                            if (content.id == sichuan) {
                                optionClone.attr("selected", "selected");
                            }
                            majorSelect.append(optionClone);
                        }
                    }
                    majorInit = true;
                    hideloading();
                },
                error: function () {
                    changeloading(errortext);
                }
            });
        }

        var initMajorOld = function (parentId) {
            showloading(loadingtext);
            majorOldSelect.empty();
            $.ajax({
                type: "post",
                dataType: "json",
                url: "/structure/maptree/controller/major_list_by_department.php",
                data: {parentId: parentId},
                success: function (data) {
                    if (data.errorCode == 1) {
                        var contentArr = data.content;
                        addCustomeData(contentArr);
                        for (var i = 0; i < contentArr.length; i++) {
                            var content = contentArr[i];
                            var optionClone = $("#option_hide").clone(true);
                            optionClone.html(content.name);
                            optionClone.css("display", "block");
                            optionClone.attr("id", content.id);
                            optionClone.attr("value", content.id);
                            if (content.id == sichuan) {
                                optionClone.attr("selected", "selected");
                            }
                            majorOldSelect.append(optionClone);
                        }
                    }
                    hideloading();
                },
                error: function () {
                    changeloading(errortext);
                }
            });
        }

        submitButton.bind("click", function () {
            var requestObj = getUserData();
            if (!requestObj) {
                return;
            }
            showloading(loadingtext);
            $.ajax({
                type: "post",
                dataType: "json",
                url: "/structure/user/controller/user_save.php",
                data: requestObj,
                success: function (data) {
                    maskshow = false;
                    alertDialog.hide();
                    if (data.errorCode == 1 && data.content) {
                        showloading("保存成功");
                        window.location.reload();
                    } else {
                        showloading("保存失败，您已录入过。", true);
                    }
                },
                error: function () {
                    changeloading(errortext);
                }
            });
        });

        modifyButton.bind("click", function () {
            var requestObj = getUserData();
            if (!requestObj) {
                return;
            }
            showloading(loadingtext);
            $.ajax({
                type: "post",
                dataType: "json",
                url: "/structure/user/controller/user_modify.php",
                data: requestObj,
                success: function (data) {
                    maskshow = false;
                    alertDialog.hide();
                    if (data.errorCode == 1 && data.content) {
                        showloading("修改成功");
                        //window.location.reload();
                    } else {
                        showloading("修改失败", true);
                    }
                },
                error: function (data) {
                    changeloading(errortext);
                }
            });
        });

        function showloading(text, confirm) {
            if (maskshow) {
                return;
            }
            maskshow = true;
            if (confirm) {
                waitingContainer.hide();
                alertContainer.show();
                alertDialogText.html(text);
            } else {
                waitingContainer.show();
                alertContainer.hide();
                waitingDialogText.html(text);
            }
            alertDialog.fadeIn(200, function () {

            });
        }

        alertConfirm.bind("click", function () {
            hideloading();
        });

        var hideloading = function () {
            alertDialog.fadeOut(200, function () {
                maskshow = false;
            });
        }

        var changeloading = function (text, timeout) {
            waitingDialogText.html(text);
            if (!timeout) {
                timeout = 1000;
            }
            setTimeout(function () {
                hideloading();
            }, timeout);
        }

        var getUserData = function () {
            var name = $("#user_name").val();
            var sex = $('input:radio:checked').val();
            var contact = $("#user_contact").val();
            var provinceId = provinceSelect.val();
            var cityId = citySelect.val();
            var openId = $("#open_id").val();
            var departmentId = departmentSelect.val();

            if (!openId) {
                showloading("数据出错，请退出重试", true);
                return false;
            }

            if (!name) {
                showloading("请输入姓名", true);
                return false;
            }

            if (!sex) {
                showloading("请选择性别", true);
                return false;
            }

            if (!contact) {
                showloading("请输入联系方式", true);
                return false;
            }

            if (!cityId) {
                showloading("请选择市", true);
                return false;
            }

            var majorId;
            if (old) {
                departmentId = -1;
                majorId = majorOldSelect.val();
            } else {
                majorId = majorSelect.val();
                departmentId = departmentSelect.val();
            }

            var customMajorText = customMajor.val();
            var customDepartmentText = customDepartment.val();

            if (isCustomMajor) {
                if (!customMajorText) {
                    showloading("请输入自定义专业", true);
                    return false;
                }
            } else {
                if (!majorId) {
                    showloading("请选择专业", true);
                    return false;
                }
            }

            if (isCustomDepartment) {
                if (!customDepartmentText) {
                    showloading("请输入自定义系别", true);
                    return false;
                }
            } else {
                if (!departmentId) {
                    showloading("请选择系别", true);
                    return false;
                }
            }

            var requestObj = {
                name: name,
                sex: sex,
                contact: contact,
                cityId: cityId,
                globalDate: globalDate.getFullYear() + "-" + (globalDate.getMonth() * 1 + 1) + "-" + globalDate.getDate(),
                departmentId: departmentId,
                majorId: majorId,
                openId: openId,
                customMajor: customMajorText,
                customDepartment: customDepartmentText
            }
            return requestObj;
        }

        var addCustomeData = function (arr) {
            arr.push({
                id: -2,
                name: '自定义',
                department_id: -2
            });
        }

    });
</script>
</body>
</html>

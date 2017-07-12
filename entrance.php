<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 2016/12/12
 * Time: 17:47
 */
require_once dirname(__FILE__) . '/core/db/connection_mysql.php';
require_once dirname(__FILE__) . '/structure/maptree/dao/major_dao.php';
require_once dirname(__FILE__) . '/structure/maptree/dao/area_dao.php';
require_once dirname(__FILE__) . '/structure/maptree/domain/area.php';
require_once dirname(__FILE__) . '/structure/maptree/domain/major.php';
require_once dirname(__FILE__) . '/structure/maptree/domain/department.php';
require_once dirname(__FILE__) . '/structure/maptree/dao/department_dao.php';
require_once dirname(__FILE__) . '/structure/user/domain/user.php';
require_once dirname(__FILE__) . '/structure/user/dao/user_dao.php';
require_once dirname(__FILE__) . '/structure/company/domain/company.php';
require_once dirname(__FILE__) . '/structure/company/dao/company_dao.php';
require_once dirname(__FILE__) . '/structure/message/dao/message_dao.php';
require_once dirname(__FILE__) . '/structure/message/domain/message.php';
require_once dirname(__FILE__) . '/structure/operator/dao/operator_dao.php';
require_once dirname(__FILE__) . '/structure/operator/domain/operator.php';
require_once dirname(__FILE__) . '/structure/message/dao/message_reply_dao.php';
require_once dirname(__FILE__) . '/structure/message/domain/message_reply.php';
require_once dirname(__FILE__) . '/core/net/result.php';
require_once dirname(__FILE__) . '/core/net/manager_result.php';
require_once dirname(__FILE__) . '/core/net/error_code.php';
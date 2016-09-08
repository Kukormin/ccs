<?
$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/../..');
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS',true);
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

@set_time_limit(0);
@ignore_user_abort(true);

// Чтобы агенты корректно работали на кроне:
// 1) нужно добавить этот скрипт в крон
// 2) для того, чтоб выполнялись и периодические и нет:
//      COption::SetOptionString("main", "agents_use_crontab", "N");
// 3) чтобы отключить агенты на хитах
//      COption::SetOptionString("main", "check_agents", "N");
// 4) В dbconn.php убрать все упоминания BX_CRONTAB, BX_CRONTAB_SUPPORT, NO_AGENT_CHECK, DisableEventsCheck

\CAgent::CheckAgents();

<?php
/*================================================================+\
|| # PHPRetro - An extendable virtual hotel site and management
|+==================================================================
|| # Copyright (C) 2009 Yifan Lu. All rights reserved.
|| # http://www.yifanlu.com
|| # Parts Copyright (C) 2009 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|| # All images, scripts, and layouts
|| # Copyright (C) 2009 Sulake Ltd. All rights reserved.
|+==================================================================
|| # PHPRetro is provided "as is" and comes without
|| # warrenty of any kind. PHPRetro is free software!
|| # License: GNU Public License 3.0
|| # http://opensource.org/licenses/gpl-license.php
\+================================================================*/

define("IN_HOLOCMS", TRUE);

if(!isset($page) || !is_array($page)){ $page = array(); }
if(!isset($page['dir'])){ $page['dir'] = ''; }
if(!isset($page['no_ajax'])){ $page['no_ajax'] = false; }
if(!isset($page['housekeeping'])){ $page['housekeeping'] = false; }
if(!isset($page['bypass_user_check'])){ $page['bypass_user_check'] = false; }
if(!isset($page['id'])){ $page['id'] = ''; }
if(!isset($page['new_landing'])){ $page['new_landing'] = false; }

$page['dir'] = str_replace('\\','/',$page['dir']);
$cwd = str_replace('\\','/', getcwd());
chdir(str_replace($page['dir'], "", $cwd));

if(@ini_get('date.timezone') == null && function_exists("date_default_timezone_get")){ @date_default_timezone_set("America/Los_Angeles"); }

if(strpos($page['dir'],'habblet') && (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') && $page['no_ajax'] != true){ header('Location: ../'); exit; }

if(!include_once('./includes/config.php')){ if(file_exists('./install/config.php')){ echo "<h1>Please move ./install/config.php to ./includes/config.php to continue.</h1>"; }elseif(file_exists('./install/index.php')){ header('Location: ./install/'); }else{ echo "<h1>Cannot find config.php in includes folder. Cannot find the install folder either. Did you copy all the files?"; } exit; }
define("PREFIX", $conn['main']['prefix']);
require_once('./includes/classes.php');
$db = new $conn['main']['server']($conn['main']);
if($conn['server']['enabled'] == true){ $serverdb = new $conn['server']['server']($conn['server']); }else{ $serverdb = $db; }
if(!empty($db->error) || !empty($serverdb->error)){
	echo "<h1>Could not connect to the database.</h1>";
	if(defined('DEBUG')){
		if(!empty($db->error)){ echo htmlspecialchars($db->error, ENT_COMPAT, "UTF-8"); }
		if(!empty($serverdb->error) && $serverdb !== $db){ echo "<br />".htmlspecialchars($serverdb->error, ENT_COMPAT, "UTF-8"); }
	}
	exit;
}
$settings = new HoloSettings;
$input = new HoloInput;
$lang = new HoloLocale;

if(session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}

define("PATH", $settings->find("site_path"));
define("SHORTNAME", $settings->find("site_shortname"));
define("FULLNAME", $settings->find("site_name"));
//define("DEBUG", true); //Uncomment this line to show detailed database error messages.

$hotelServer = $settings->find("hotel_server");
if($hotelServer == "" || !file_exists('./includes/data/'.$hotelServer.'.php')){
	$hotelServer = 'holograph';
}
require('./includes/data/'.$hotelServer.'.php');
$core = new core_sql;
require('./includes/functions.php');
require('./includes/version.php');

if($page['housekeeping'] != true){
	if(isset($_SESSION['user']) && ($_SESSION['user'] instanceof HoloUser)){
		$user = $_SESSION['user'];
	}else{
		if(isset($_SESSION['user'])){ unset($_SESSION['user']); }
		$user = new HoloUser(null,null);
	}
}else{
	if(isset($_SESSION['hk_user']) && ($_SESSION['hk_user'] instanceof HoloUser)){
		$user = $_SESSION['hk_user'];
	}else{
		if(isset($_SESSION['hk_user'])){ unset($_SESSION['hk_user']); }
		$user = new HoloUser(null,null);
	}
}

if($user->error == 1 && $page['bypass_user_check'] != true && isset($_COOKIE['rememberme']) && $_COOKIE['rememberme'] == "true" && $page['housekeeping'] != true){ $_SESSION['page'] = $_SERVER["REQUEST_URI"]; header("Location: ".PATH."/security_check_token"); }

if($settings->find("site_closed") == "1" && $page['id'] != "maintenance" && $page['housekeeping'] != true && $user->user("rank") < 5){
	header("Location: ".PATH."/maintenance"); exit;
}
?>

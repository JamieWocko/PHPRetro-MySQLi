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

$page['dir'] = '\habblet';
require_once('../includes/core.php');
require_once('./includes/session.php');

$id = isset($_POST['widgetId']) ? $input->FilterText($_POST['widgetId']) : "";
$zindex = isset($_POST['zindex']) ? $input->FilterText($_POST['zindex']) : 1;

$pageEdit = isset($_SESSION['page_edit']) ? $_SESSION['page_edit'] : "home";
if($pageEdit == "home"){ $location = -2; $where = '> -1'; }else{ $location = "-".$pageEdit; $where = '< 1'; }

$sql = $db->query("SELECT data,`where` FROM ".PREFIX."homes_catalogue WHERE minrank <= '".$user->id."' AND `where` ".$where." AND id = '".$id."' LIMIT 1");
$widget = $db->result($sql);
$iswhere = $db->result($sql, 0, 1);

if($pageEdit == "home" && $iswhere == -1){ exit; }elseif($pageEdit != "home" && $iswhere == 1){ exit; }

$db->query("INSERT INTO ".PREFIX."homes (location,x,y,z,itemid,ownerid) VALUES ('".$location."','15','25','".$zindex."','".$id."','".$user->id."')");

$sql = $db->query("SELECT id FROM ".PREFIX."homes WHERE itemid = '".$id."' AND ownerid = '".$user->id."' AND location = '".$location."' LIMIT 1");
$placedid = $db->result($sql);

header('X-JSON: ["'.$input->HoloText($id).'"]');

$page['edit'] = true;
$widget = $placedid;

if($pageEdit == "home"){ require('./habblet/myhabbo_widgets.php'); }else{ require('./habblet/groups_widgets.php'); }
?>

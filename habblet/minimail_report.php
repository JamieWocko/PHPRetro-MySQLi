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
$data = new me_sql;
$lang->addLocale("minimail.report");

$id = isset($_POST['messageId']) ? $input->FilterText($_POST['messageId']) : "";
$start = isset($_POST['start']) ? $_POST['start'] : 0;
$label = isset($_POST['label']) ? $_POST['label'] : "inbox";

$sql = $db->query("SELECT * FROM ".PREFIX."minimail WHERE id = '".$id."' LIMIT 1");
$row = $db->fetch_assoc($sql);

if(!$row){ exit; }

$remoteAddr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "";
$db->query("INSERT INTO ".PREFIX."help (username,ip,message,date,picked_up,subject,roomid) VALUES ('".$user->name."', '".$remoteAddr."','".$lang->loc['minimail.message'].": ".$row['message']."','".time()."','0','".$lang->loc['reported.minimail.message'].": ".$row['subject']."','0')");
$data->delete1($user->id, $row['senderid']);
$data->delete1($row['senderid'], $user->id);
$db->query("DELETE FROM ".PREFIX."minimail WHERE id = '".$id."' LIMIT 1");

$page['bypass'] = true;
$startpage = $start;
$message = $lang->loc['report.message'];

require('./habblet/minimail_loadMessages.php');
?>

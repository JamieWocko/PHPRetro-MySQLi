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

require_once('./includes/core.php');
require_once('./includes/session.php');
$lang->addLocale("client.hotel");

if(isset($_SESSION['reauthenticate']) && $_SESSION['reauthenticate'] == "true"){
	$_SESSION['page'] = $_SERVER["REQUEST_URI"];
	header("Location: ".PATH."/account/reauthenticate"); exit;
}else{
	$user = new HoloUser($user->name,$user->password,true);
	$_SESSION['user'] = $user;
}

if(isset($_GET['wide']) && $_GET['wide'] == "false"){
	$wide = false;
	$width = "720";
	$height = "540";
}else{
	$wide = true;
	$width = "960";
	$height = "540";
}

require_once('./templates/client_header.php');

$forwardid = isset($_GET['forwardId']) ? $input->HoloText($_GET['forwardId']) : "";
$roomid = isset($_GET['roomId']) ? $input->HoloText($_GET['roomId']) : "";
$shortcut = isset($_GET['shortcut']) ? $_GET['shortcut'] : null;
switch($shortcut){
	case "roomomatic": $shortcut = "1"; break;
	default: unset($_GET['shortcut']); break;
}
?>
<body id="client"<?php if($wide == true){ ?> class="wide"<?php } ?>>

<div id="client-topbar" style="display:none">

  <div class="logo"><img src="<?php echo PATH; ?>/web-gallery/images/popup/popup_topbar_habbologo.gif" alt="" align="middle"/></div>
  <div class="habbocount"><div id="habboCountUpdateTarget">
<?php echo GetOnlineCount()." ".$lang->loc['members.online']; ?>
</div>
	<script language="JavaScript" type="text/javascript">
		setTimeout(function() {
			HabboCounter.init(600);
		}, 20000);
	</script>
</div>
  <div class="logout"><a href="<?php echo PATH; ?>/account/logout?origin=popup" onclick="self.close(); return false;"><?php echo $lang->loc['close.hotel']; ?></a></div>
</div>
<noscript>
  <img src="<?php echo PATH; ?>/clientlog/nojs" border="0" width="1" height="1" alt="" style="position: absolute; top:0; left: 0"/>
</noscript>

<div id="clientembed-container">
<div id="clientembed-loader" class="loader-image" style="display:none">
    <div class="loader-image-inner">
        <b class="loading-text"><?php echo $lang->loc['loading']; ?>...</b>
    </div>
</div>
<div id="clientembed">
<script type="text/javascript" language="javascript">
try {
var _shockwaveDetectionSuccessful = true;
_shockwaveDetectionSuccessful = ShockwaveInstallation.swDetectionCheck();
if (!_shockwaveDetectionSuccessful) {
    log(50);
}
if (_shockwaveDetectionSuccessful) {
  ShockwaveInstallation.removeInstallationCookie();
  HabboClientUtils.cacheCheck();
}
} catch(e) {
    try {
		HabboClientUtils.logClientJavascriptError(e);
	} catch(e2) {}
}

    HabboClientUtils.extWrite("<object classid=\"clsid:166B1BCA-3F9C-11CF-8075-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=10,0,0,0\" id=\"habbo\" width=\"<?php echo $width; ?>\" height=\"<?php echo $height; ?>\"\>\n<param name=\"src\" value=\"<?php echo $settings->find("client_dcr"); ?>\"\>\n<param name=\"swRemote\" value=\"swSaveEnabled=\'true\' swVolume=\'true\' swRestart=\'false\' swPausePlay=\'false\' swFastForward=\'false\' swTitle=\'<?php echo FULLNAME; ?>\' swContextMenu=\'true\' \"\>\n<param name=\"swStretchStyle\" value=\"stage\"\>\n<param name=\"swstretchVAlign\" value=\"bottom\"\>\n<param name=\"swText\" value=\"\"\>\n<param name=\"bgColor\" value=\"#000000\"\>\n   <param name=\"sw7\" value=\"external.variables.txt=<?php echo $settings->find("client_external_variables"); ?>;external.texts.txt=<?php echo $settings->find("client_external_texts"); ?>\"\>\n   <param name=\"sw6\" value=\"client.connection.failed.url=<?php echo PATH; ?>/client_connection_failed;external.hash=null\"\>\n   <param name=\"sw5\" value=\"client.reload.url=<?php echo PATH; ?>/account/reauthenticate?page=/client;client.fatal.error.url=<?php echo PATH; ?>/client_error\"\>\n   <param name=\"sw4\" value=\"site.url=<?php echo PATH; ?>;url.prefix=<?php echo PATH; ?>\"\>\n   <param name=\"sw9\" value=\"<?php if(isset($_GET['shortcut'])){ ?>shortcut.id=<?php echo $shortcut; ?>;<?php } ?>account_id=<?php echo $user->id; ?>\"\>\n   <param name=\"sw8\" value=\"use.sso.ticket=1;sso.ticket=<?php echo $user->user("ticket_sso"); ?><?php if(isset($_GET['forwardId']) && isset($_GET['roomId'])){ ?>;forward.type=<?php echo $forwardid; ?>;forward.id=<?php echo $roomid; } ?>\"\>\n   <param name=\"sw2\" value=\"connection.info.host=<?php echo $settings->find("hotel_ip"); ?>;connection.info.port=<?php echo $settings->find("hotel_port"); ?>\"\>\n   <param name=\"sw3\" value=\"connection.mus.host=<?php echo $settings->find("hotel_ip"); ?>;connection.mus.port=<?php echo $settings->find("hotel_mus"); ?>\"\>\n   <param name=\"sw1\" value=\"client.allow.cross.domain=0;client.notify.cross.domain=1\"\>\n   <param name=\"playerVersion\" value=\"11\"\>\n<embed src=\"<?php echo $settings->find("client_dcr"); ?>\" bgColor=\"#000000\" width=\"<?php echo $width; ?>\" height=\"<?php echo $height; ?>\" swRemote=\"swSaveEnabled=\'true\' swVolume=\'true\' swRestart=\'false\' swPausePlay=\'false\' swFastForward=\'false\' swTitle=\'<?php echo FULLNAME; ?>\' swContextMenu=\'true\'\" swStretchStyle=\"stage\" swstretchVAlign=\"bottom\" swText=\"\" type=\"application/x-director\" pluginspage=\"http://www.macromedia.com/shockwave/download/\" \n    sw7=\"external.variables.txt=<?php echo $settings->find("client_external_variables"); ?>;external.texts.txt=<?php echo $settings->find("client_external_texts"); ?>\"  \n    sw6=\"client.connection.failed.url=<?php echo PATH; ?>/client_connection_failed;external.hash=null\"  \n    sw5=\"client.reload.url=<?php echo PATH; ?>/account/reauthenticate?page=/client;client.fatal.error.url=<?php echo PATH; ?>/client_error\"  \n    sw4=\"site.url=<?php echo PATH; ?>;url.prefix=<?php echo PATH; ?>\"  \n    sw9=\"<?php if(isset($_GET['shortcut'])){ ?>shortcut.id=<?php echo $shortcut; ?>;<?php } ?>account_id=<?php echo $user->id; ?>\"  \n    sw8=\"use.sso.ticket=1;sso.ticket=<?php echo $user->user("ticket_sso"); ?><?php if(isset($_GET['forwardId']) && isset($_GET['roomId'])){ ?>;forward.type=<?php echo $forwardid; ?>;forward.id=<?php echo $roomid; } ?>\"  \n    sw2=\"connection.info.host=<?php echo $settings->find("hotel_ip"); ?>;connection.info.port=<?php echo $settings->find("hotel_port"); ?>\"  \n    sw3=\"connection.mus.host=<?php echo $settings->find("hotel_ip"); ?>;connection.mus.port=<?php echo $settings->find("hotel_mus"); ?>\"  \n    sw1=\"client.allow.cross.domain=0;client.notify.cross.domain=1\"  \n    playerVersion=\"11\" \></embed\>\n<noembed\>You need the Shockwave plugin (free and safe to download) to enter <?php echo FULLNAME; ?>. <a href=\"http://www.adobe.com/shockwave/download/\" target=\"_new\"\>Download here</a\></noembed\>\n</object\>");
</script>

<noscript>
<object classid="clsid:166B1BCA-3F9C-11CF-8075-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=10,0,0,0" id="habbo" width="<?php echo $width; ?>" height="<?php echo $height; ?>">
<param name="src" value="<?php echo $settings->find("client_dcr"); ?>">
<param name="swRemote" value="swSaveEnabled='true' swVolume='true' swRestart='false' swPausePlay='false' swFastForward='false' swTitle='<?php echo FULLNAME; ?>' swContextMenu='true' ">
<param name="swStretchStyle" value="stage">
<param name="swstretchVAlign" value="bottom">
<param name="swText" value="">
<param name="bgColor" value="#000000">
   <param name="sw7" value="external.variables.txt=<?php echo $settings->find("client_external_variables"); ?>;external.texts.txt=<?php echo $settings->find("client_external_texts"); ?>">
   <param name="sw6" value="client.connection.failed.url=<?php echo PATH; ?>/client_connection_failed;external.hash=null">
   <param name="sw5" value="client.reload.url=<?php echo PATH; ?>/account/reauthenticate?page=/client;client.fatal.error.url=<?php echo PATH; ?>/client_error">
   <param name="sw4" value="site.url=<?php echo PATH; ?>;url.prefix=<?php echo PATH; ?>">
   <param name="sw9" value="<?php if(isset($_GET['shortcut'])){ ?>shortcut.id=<?php echo $shortcut; ?>;<?php } ?>account_id=<?php echo $user->id; ?>">
   <param name="sw8" value="use.sso.ticket=1;sso.ticket=<?php echo $user->user("ticket_sso"); ?><?php if(isset($_GET['forwardId']) && isset($_GET['roomId'])){ ?>;forward.type=<?php echo $forwardid; ?>;forward.id=<?php echo $roomid; } ?>">
   <param name="sw2" value="connection.info.host=<?php echo $settings->find("hotel_ip"); ?>;connection.info.port=<?php echo $settings->find("hotel_port"); ?>">
   <param name="sw3" value="connection.mus.host=<?php echo $settings->find("hotel_ip"); ?>;connection.mus.port=<?php echo $settings->find("hotel_mus"); ?>">
   <param name="sw1" value="client.allow.cross.domain=0;client.notify.cross.domain=1">
   <param name="playerVersion" value="11">
<!--[if IE]><?php echo $lang->loc['need.shockwave'] ?> <a href="http://www.adobe.com/shockwave/download/" target="_new"><?php echo $lang->loc['download.here']; ?></a><![endif]-->
<embed src="<?php echo $settings->find("client_dcr"); ?>" bgColor="#000000" width="<?php echo $width; ?>" height="<?php echo $height; ?>" swRemote="swSaveEnabled='true' swVolume='true' swRestart='false' swPausePlay='false' swFastForward='false' swTitle='<?php echo FULLNAME; ?>' swContextMenu='true'" swStretchStyle="stage" swstretchVAlign="bottom" swText="" type="application/x-director" pluginspage="http://www.macromedia.com/shockwave/download/" 
    sw7="external.variables.txt=<?php echo $settings->find("client_external_variables"); ?>;external.texts.txt=<?php echo $settings->find("client_external_texts"); ?>"  
    sw6="client.connection.failed.url=<?php echo PATH; ?>/client_connection_failed;external.hash=null"  
    sw5="client.reload.url=<?php echo PATH; ?>/account/reauthenticate?page=/client;client.fatal.error.url=<?php echo PATH; ?>/client_error"  
    sw4="site.url=<?php echo PATH; ?>;url.prefix=<?php echo PATH; ?>"  
    sw9="<?php if(isset($_GET['shortcut'])){ ?>shortcut.id=<?php echo $shortcut; ?>;<?php } ?>account_id=<?php echo $user->id; ?>"  
    sw8="use.sso.ticket=1;sso.ticket=<?php echo $user->user("ticket_sso"); ?><?php if(isset($_GET['forwardId']) && isset($_GET['roomId'])){ ?>;forward.type=<?php echo $forwardid; ?>;forward.id=<?php echo $roomid; } ?>"  
    sw2="connection.info.host=<?php echo $settings->find("hotel_ip"); ?>;connection.info.port=<?php echo $settings->find("hotel_port"); ?>"  
    sw3="connection.mus.host=<?php echo $settings->find("hotel_ip"); ?>;connection.mus.port=<?php echo $settings->find("hotel_mus"); ?>"  
    sw1="client.allow.cross.domain=0;client.notify.cross.domain=1"  
    playerVersion="11" ></embed>
<noembed><?php echo $lang->loc['need.shockwave'] ?> <a href="http://www.adobe.com/shockwave/download/" target="_new"><?php echo $lang->loc['download.here']; ?></a></noembed>
</object>
</noscript>

</div>
<script type="text/javascript">
HabboClientUtils.loaderTimeout = 10 * 1000;
HabboClientUtils.showLoader(["<?php echo $lang->loc['loading']; ?>", "<?php echo $lang->loc['loading']; ?>.", "<?php echo $lang->loc['loading']; ?>..", "<?php echo $lang->loc['loading']; ?>..."]);
</script>
</div>
<?php require_once('./templates/client_footer.php');

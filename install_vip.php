﻿<?php


error_reporting(E_ALL ^ E_NOTICE);
@ini_set('display_errors', true);
@ini_set('html_errors', false);
@ini_set('error_reporting', E_ALL ^ E_NOTICE);

define('DATALIFEENGINE', true);
define('ROOT_DIR', dirname (__FILE__));
define('ENGINE_DIR', ROOT_DIR.'/engine');

$config['charset'] = "utf8";

include ('engine/api/api.class.php');
require_once(ENGINE_DIR.'/inc/include/functions.inc.php');
require_once(ENGINE_DIR.'/skins/default.skin.php');

extract($_REQUEST, EXTR_SKIP);

echoheader("","");

if($_REQUEST['action']=="setup"){
	
	
define ("PREFIX", $dbprefix);
define ("COLLATE", $dbcollate);

$tableSchema = array();



$tableSchema[] = "
CREATE TABLE IF NOT EXISTS `" . PREFIX . "_vip_gorup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `plantime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

";
$tableSchema[] = "
INSERT INTO `" . PREFIX . "_vip_gorup` (`id`, `name`, `plantime`) VALUES
(1, '3 ماهه', 3),
(2, '6 ماهه', 6),
(3, '1 ساله', 1),
(4, '2 ساله', 2);

";
$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_vip_panel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `plantme` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$tableSchema[] = "CREATE TABLE IF NOT EXISTS `" . PREFIX . "_vip_sn` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `vip_panel` int(11) NOT NULL,
  `res` varchar(90) NOT NULL,
  `au` varchar(90) NOT NULL,
  `price` varchar(90) NOT NULL,
  `date` varchar(155) NOT NULL,
  `vip_time` varchar(90) NOT NULL,
  `show` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$tableSchema[] = " CREATE TABLE IF NOT EXISTS `" . PREFIX . "_vip_setting` (
  `id` int(11) NOT NULL,
  `marchentid` varchar(60) NOT NULL,
  `webservice` varchar(60) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
$tableSchema[] = "INSERT INTO `" . PREFIX . "_vip_setting` (`id`, `marchentid`,`webservice`, `group_id`) VALUES
(1, '000000000000',1, 0);
";

	@$db->query("ALTER TABLE `" . PREFIX . "_users` ADD `viptime_start` INT( 11 ) NOT NULL AFTER `news_num`,
	ADD `viptime_plan` INT( 11 ) NOT NULL AFTER `news_num`,
	ADD `vip_approve` INT( 11 ) NOT NULL AFTER `news_num`");


  
  foreach($tableSchema as $table) {

        $db->query($table);

      }
      
echo <<<HTML
<form method=POST action="$PHP_SELF">
<div style="padding-top:5px;">
<table width="100%">
    <tr>
        <td width="4"><img src="engine/skins/images/tl_lo.gif" width="4" height="4" border="0"></td>
        <td background="engine/skins/images/tl_oo.gif"><img src="engine/skins/images/tl_oo.gif" width="1" height="4" border="0"></td>
        <td width="6"><img src="engine/skins/images/tl_ro.gif" width="6" height="4" border="0"></td>
    </tr>
    <tr>
        <td background="engine/skins/images/tl_lb.gif"><img src="engine/skins/images/tl_lb.gif" width="4" height="1" border="0"></td>
        <td style="padding:5px;" bgcolor="#FFFFFF">
<table width="100%">
    <tr>
        <td bgcolor="#EFEFEF" height="29" style="padding-left:10px;"><div class="navigation">
			<p align="center"><font face="Tahoma" size="2">پايان نصب</font></div></td>
    </tr>
</table>
<div class="unterline"></div>
<table width="100%">
    <tr>
        <td style="padding:2px;">
		<p align="center"><font face="Tahoma" size="2"><b>
		عمليات نصب با موفقيت به پايان رسيد
		
		<br />

		» <a href="index.php?do=vip_user">نمايش ماژول کاربران ويژه </a>
		</b>
        
        </font>
        
        </td>
    </tr>
</table>
</td>
        <td background="engine/skins/images/tl_rb.gif"><img src="engine/skins/images/tl_rb.gif" width="6" height="1" border="0"></td>
    </tr>
    <tr>
        <td><img src="engine/skins/images/tl_lu.gif" width="4" height="6" border="0"></td>
        <td background="engine/skins/images/tl_ub.gif"><img src="engine/skins/images/tl_ub.gif" width="1" height="6" border="0"></td>
        <td><img src="engine/skins/images/tl_ru.gif" width="6" height="6" border="0"></td>
    </tr>
</table>
</div></form>
HTML;
}else{
echo <<<HTML

	<style> 
	.dstn_td td {
		 border:1px solid #ccc;
	}
	</style>
<form method=POST action="$PHP_SELF">
<div style="padding-top:5px;">
<table width="100%">
    <tr>
        <td width="4"><img src="engine/skins/images/tl_lo.gif" width="4" height="4" border="0"></td>
        <td background="engine/skins/images/tl_oo.gif"><img src="engine/skins/images/tl_oo.gif" width="1" height="4" border="0"></td>
        <td width="6"><img src="engine/skins/images/tl_ro.gif" width="6" height="4" border="0"></td>
    </tr>
    <tr>
        <td background="engine/skins/images/tl_lb.gif"><img src="engine/skins/images/tl_lb.gif" width="4" height="1" border="0"></td>
        <td style="padding:5px;" bgcolor="#FFFFFF">
<table width="100%">
    <tr>
        <td bgcolor="#EFEFEF" height="29" style="padding-left:10px;"><div class="navigation"> 
			<p align="center"><font face="Tahoma" size="2">&nbsp; VIP نصب افزونه
			</font> </div></td>
    </tr>
</table>
<div class="unterline"></div>
<table width="100%">
    <tr>
        <td style="padding:2px;">
		
			<div style="line-height: 18px; padding: 5px; color: #505050;">
			
	<p align="center"><font face="Tahoma" size="2">
			
	<span style="color: #cc0000">	نصب نسخه 1 افزونه VIP  			/</span>
			
				
				مواردي که قبل از نصب بايد انجام دهيد : </font></p>
				
				<table border="0" width="100%" class="dstn_td" style="margin-top: 5px; letter-spacing: 2px; text-align: center; padding: 3px; direction: ltr;">
				  <tbody style="text-align: center; background: #eee;">
					<tr>
					 <td> <font face="Tahoma" size="2">سطح دسترسي </font> </td>
					</tr>
				  </tbody>
					<tr>
					 <td> <font face="Tahoma" size="2">جهت نصب نياز به تغيير دسترسي نمي باشد.
						</font> </td>
					 
					</tr>
			</table>
				
			</div>
		</td>
    </tr>
    <tr>
        <td style="padding:2px;"><input type=hidden name=action value="setup">
		<p align="center"><input style="font: 8pt tahoma; padding: 3px;" type=submit value="شروع نصب »"></td>
    </tr>
</table>
</td>
        <td background="engine/skins/images/tl_rb.gif"><img src="engine/skins/images/tl_rb.gif" width="6" height="1" border="0"></td>
    </tr>
    <tr>
        <td><img src="engine/skins/images/tl_lu.gif" width="4" height="6" border="0"></td>
        <td background="engine/skins/images/tl_ub.gif"><img src="engine/skins/images/tl_ub.gif" width="1" height="6" border="0"></td>
        <td><img src="engine/skins/images/tl_ru.gif" width="6" height="6" border="0"></td>
    </tr>
</table>
</div></form>
HTML;
}
echofooter();

?>
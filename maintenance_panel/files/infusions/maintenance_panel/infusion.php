<?php
/*--------------------------------------------------------------+
 | PHP-Fusion 7 Content Management System             			|
 +--------------------------------------------------------------+
 | Copyright © 2002 - 2014 Nick Jones                 			|
 | http://www.php-fusion.co.uk/                       			|
 +--------------------------------------------------------------+
 | Infusion: maintenance_panel                                 	|
 | Author:   GUL-Sonic | teeshock								|
 | web		 http://www.germanys-united-legends.de 				|
 | Email	 gul-sonic@online.de 								|
 +--------------------------------------------------------------+
 | This program is released as free software under the			|
 | Affero GPL license. You can redistribute it and/or			|
 | modify it under the terms of this license which you			|
 | can read by viewing the included agpl.txt or online			|
 | at www.gnu.org/licenses/agpl.html. Removal of this			|
 | copyright header is strictly prohibited without				|
 | written permission from the original author(s).				|
 +--------------------------------------------------------------*/
 
 if (!defined("IN_FUSION")) {
    die("Access Denied");
}

include INFUSIONS . "maintenance_panel/infusion_db.php";

if (file_exists(INFUSIONS . "maintenance_panel/locale/" . $settings['locale'] . ".php")) {
    include INFUSIONS . "maintenance_panel/locale/" . $settings['locale'] . ".php";
} else {
    include INFUSIONS . "maintenance_panel/locale/German.php";
}

// Infusion general information
$inf_title = $locale['gmt000'];
$inf_version = $locale['gmt001'];
$inf_developer = "GUL-Sonic | teeshock";
$inf_weburl = "http://germanys-united-legends.de";
$inf_email = "gul-sonic@online.de";
$inf_folder = "maintenance_panel";
$inf_description = $locale['gmt002'];

$inf_newtable[1] = DB_GMT_MAINTENANCE . "(
id int(11) NOT NULL auto_increment,
gmt_status BOOL NOT NULL,
gmt_width int(3) NOT NULL,
gmt_grundwert int(3) NOT NULL,
gmt_prozentwert int(3) NOT NULL,
gmt_disp_round int(3) NOT NULL,
gmt_disp_type int(1) NOT NULL,
gmt_grafik VARCHAR(100) NOT NULL,
gmt_timeopt BOOL NOT NULL,
gmt_day varchar(2) NOT NULL,
gmt_mon varchar(2) NOT NULL,
gmt_year varchar(4) NOT NULL,
gmt_hour varchar(2) NOT NULL,
gmt_min varchar(2) NOT NULL,
PRIMARY KEY  (id)
)ENGINE=MyISAM;";

$inf_droptable[1] = DB_GMT_MAINTENANCE;

$inf_insertdbrow[1] = DB_GMT_MAINTENANCE . " SET gmt_status='1', gmt_width='500', gmt_grundwert='100', gmt_prozentwert='0', gmt_disp_round='0', gmt_disp_type='2', gmt_grafik='".$settings['sitebanner']."', gmt_timeopt='1', gmt_day='01', gmt_mon='01', gmt_year='".date("Y")."', gmt_hour='01', gmt_min='00'";

$inf_adminpanel[1] = array(
    "title" => $locale['gmt000'],
    "image" => "../infusions/maintenance_panel/images/settings.png",
    "panel" => "gmt_settings_panel.php",
    "rights" => "GMT"
);

$inf_sitelink[1] = array(
	"title" => $locale['gmt000'],
	"url" => "gmt_settings_panel.php".$aidlink,
	"visibility" => "0"
);
?>
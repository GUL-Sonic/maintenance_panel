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
 
include INFUSIONS . "maintenance_panel/infusion_db.php";

if (!defined("IN_FUSION")) { die("Access Denied"); }

if (file_exists(INFUSIONS . "maintenance_panel/locale/" . $settings['locale'] . ".php")) {
    include INFUSIONS . "maintenance_panel/locale/" . $settings['locale'] . ".php";
} else {
    include INFUSIONS . "maintenance_panel/locale/German.php";
}

include LOCALE.LOCALESET."admin/settings.php";

add_to_head("<link rel='stylesheet' href='" . INFUSIONS . "maintenance_panel/css/maintenance.css' type='text/css'/>");
if ($settings['maintenance']) {
opentable("Maintenance");
echo"<table class='tbl-border' width='100%' style='vertical-align: top; margin: 0px auto;'>
			<td class='tbl2' align='center' colspan='2'>".$locale['gmt017']."</td>\n
		<tr>
			<td><div class='gmt_wrap_pan'><iframe class='gmt_frame_pan' src='" . BASEDIR . "maintenance.php'></iframe></div></td>
			
		</tr>
		<tr>
			<td class='tbl2' align='center' colspan='2'><a href='" . BASEDIR . "maintenance.php' target='blank'>Seite in Originalgr&ouml;&szlig;e</a></td>
		</tr>
		<tr>
			<td class='tbl2' align='center' colspan='2'><a href='" . BASEDIR . "infusions/maintenance_panel/gmt_settings_panel.php".$aidlink."'>" . $locale['gmt003'] . "</a></td>
		</tr>
		</table>";
			
closetable();
include "gmt_copyright.php";
}
?>
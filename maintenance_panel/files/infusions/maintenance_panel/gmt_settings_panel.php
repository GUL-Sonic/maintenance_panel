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
 
require_once "../../maincore.php";
require_once THEMES . "templates/header.php";
include INFUSIONS . "maintenance_panel/infusion_db.php";

if (!defined("IN_FUSION")) { die("Access Denied"); }

if (file_exists(INFUSIONS . "maintenance_panel/locale/" . $settings['locale'] . ".php")) {
    include INFUSIONS . "maintenance_panel/locale/" . $settings['locale'] . ".php";
} else {
    include INFUSIONS . "maintenance_panel/locale/German.php";
}
 
if (!checkrights("GMT") || !defined("iAUTH") || !isset($_GET['aid']) || $_GET['aid'] != iAUTH) { redirect("../../index.php"); }

// Variablendefinition //

$gespeichert = "<table class='tbl-border' width='80%' style='vertical-align: top; margin: 0px auto;'><tr><td align='center' class='tbl2'><font color=green'>" . $locale['gmt010'] . "</font></td></tr>\n</table>\n";
	
$gmt_width = (isset($_POST['gmt_width'])) ? $_POST['gmt_width'] : "";
$gmt_grundwert = (isset($_POST['gmt_grundwert'])) ? $_POST['gmt_grundwert'] : "";
$gmt_prozentwert = (isset($_POST['gmt_prozentwert'])) ? $_POST['gmt_prozentwert'] : "";
$gmt_disp_round = (isset($_POST['gmt_disp_round'])) ? $_POST['gmt_disp_round'] : "";
$gmt_disp_type = (isset($_POST['gmt_disp_type'])) ? $_POST['gmt_disp_type'] : "";
$gmt_grafik = (isset($_POST['gmt_grafik'])) ? $_POST['gmt_grafik'] : "";

add_to_head("<link rel='stylesheet' href='" . INFUSIONS . "maintenance_panel/css/maintenance.css' type='text/css'/>");

include LOCALE.LOCALESET."admin/settings.php";

opentable($locale['gmt003']);
if (isset($_POST['update'])) { 
	
	$error = 0;
	
      dbquery("UPDATE " . DB_GMT_MAINTENANCE . " SET
	  gmt_status = '" . stripinput($_POST['gmt_status']) . "',
      gmt_width = '" . stripinput($_POST['gmt_width']) . "',
      gmt_grundwert = '" . stripinput($_POST['gmt_grundwert']) . "',
      gmt_prozentwert = '" . stripinput($_POST['gmt_prozentwert']) . "',
      gmt_disp_round = '" . stripinput($_POST['gmt_disp_round']) . "',
	  gmt_grafik = '" . stripinput($_POST['gmt_grafik']) . "',
      gmt_disp_type = '" . stripinput($_POST['gmt_disp_type']) . "',
	  gmt_timeopt = '" . stripinput($_POST['gmt_timeopt']) . "',
	  gmt_day = '" . stripinput($_POST['gmt_day']) . "',
	  gmt_mon = '" . stripinput($_POST['gmt_mon']) . "',
	  gmt_year = '" . stripinput($_POST['gmt_year']) . "',
	  gmt_hour = '" . stripinput($_POST['gmt_hour']) . "',
	  gmt_min = '" . stripinput($_POST['gmt_min']) . "' WHERE id='1'");
	    
	$result = dbquery("UPDATE ".DB_SETTINGS." SET settings_value='".(isnum($_POST['maintenance_level']) ? $_POST['maintenance_level'] : "102")."' WHERE settings_name='maintenance_level'");
	if (!$result) { $error = 1; }
	$result = dbquery("UPDATE ".DB_SETTINGS." SET settings_value='".(isnum($_POST['maintenance']) ? $_POST['maintenance'] : "0")."' WHERE settings_name='maintenance'");
	if (!$result) { $error = 1; }
	$result = dbquery("UPDATE ".DB_SETTINGS." SET settings_value='".addslash(descript($_POST['maintenance_message']))."' WHERE settings_name='maintenance_message'");
	if (!$result) { $error = 1; }
      
	echo $gespeichert;
	redirect(FUSION_SELF.$aidlink."&error=".$error);
}

if (isset($_GET['error']) && isnum($_GET['error']) && !isset($message)) {
	if ($_GET['error'] == 0) {
		$message = $locale['900'];
	} elseif ($_GET['error'] == 1) {
		$message = $locale['901'];
	} elseif ($_GET['error'] == 2) {
		$message = $locale['696'];
	}
	if (isset($message)) {
		echo "<div id='close-message'><div class='admin-message'>".$message."</div></div>\n";
	}
}

echo"<table class='tbl-border' width='480px' style='vertical-align: top; margin: 0px auto;'>
			<td class='tbl2' align='center' colspan='2'>".$locale['gmt017']."</td>\n
		<tr>
			<td><div class='gmt_wrap'><iframe class='gmt_frame' src='" . BASEDIR . "maintenance.php'></iframe></div></td>
			
		</tr>
			<td class='tbl2' align='center' colspan='2'><a href='" . BASEDIR . "maintenance.php' target='blank'>Seite in Originalgr&ouml;&szlig;e aufrufen</a></td>
		</table>";

echo"<br>";
		
echo"<form name='gmt_admin' id='gmt_admin' method='post' enctype='multipart/form-data' action='" . FUSION_SELF.$aidlink. "'>";

$result = dbquery("SELECT * FROM " . DB_GMT_MAINTENANCE . " WHERE id='1'");
$data = dbarray($result);

echo"<table class='tbl-border' width='480px' style='vertical-align: top; margin: 0px auto;'>";
echo"	
			<td class='tbl2' align='center' colspan='2'>".$locale['gmt018']."</td>\n
		<tr>
            <td class='tbl1'>" . $locale['gmt029'] . "</td>
			<td class='tbl1'><select name='gmt_status' class='textbox'>";
			echo "<option value='1'".($data['gmt_status'] == "1" ? " selected='selected'" : "").">".$locale['502']."</option>";
			echo "<option value='0'".($data['gmt_status'] == "0" ? " selected='selected'" : "").">".$locale['503']."</option>";
			echo "</select></td>	
		</tr>
		
		<tr>
            <td class='tbl1'>" . $locale['gmt004'] . "</td>
			<td class='tbl1'><input name='gmt_width' class='textbox' value='" . $data['gmt_width'] . "' maxlength='3' size='3'></td>	
		</tr>
		
		<tr>
            <td class='tbl1'>" . $locale['gmt005'] . "</td>
			<td class='tbl1'><input name='gmt_grundwert' class='textbox' value='" . $data['gmt_grundwert'] . "' maxlength='3' size='3'></td>

		</tr>
		
		<tr>
            <td class='tbl1'>" . $locale['gmt006'] . "</td>
			<td class='tbl1'><input name='gmt_prozentwert' class='textbox' value='" . $data['gmt_prozentwert'] . "' maxlength='3' size='3'></td>	
		</tr>
		
		<tr>
            <td class='tbl1'>" . $locale['gmt007'] . "</td>
			<td class='tbl1'><input name='gmt_disp_round' class='textbox' value='" . $data['gmt_disp_round'] . "' maxlength='3' size='3'></td>	
		</tr>
		
		<tr>
            <td class='tbl1'>" . $locale['gmt008'] . "</td>
			<td class='tbl1'><select name='gmt_disp_type' class='textbox'>";
			echo "<option value='0'".($data['gmt_disp_type'] == "0" ? " selected='selected'" : "").">".$locale['gmt011']."</option>";
			echo "<option value='1'".($data['gmt_disp_type'] == "1" ? " selected='selected'" : "").">".$locale['gmt012']."</option>";
			echo "<option value='2'".($data['gmt_disp_type'] == "2" ? " selected='selected'" : "").">".$locale['gmt013']."</option>";
			echo "</select></td>
		</tr>
		
		<tr>
            <td class='tbl1'>" . $locale['gmt020'] . "</td>
			<td class='tbl1'><select name='gmt_timeopt' class='textbox'>";
			echo "<option value='1'".($data['gmt_timeopt'] == "1" ? " selected='selected'" : "").">".$locale['502']."</option>";
			echo "<option value='0'".($data['gmt_timeopt'] == "0" ? " selected='selected'" : "").">".$locale['503']."</option>";
			echo "</select></td>
		</tr>
		
		<tr>
			<td class='tbl1'>" . $locale ['gmt027'] . "<br>" . $locale ['gmt028'] . " </td>
			<td class='tbl1'>
			<select name='gmt_day' class='textbox'>\n
			<option".($data['gmt_day'] == '01' ? " selected='selected'" : "").">01</option>\n
			<option".($data['gmt_day'] == '02' ? " selected='selected'" : "").">02</option>\n
			<option".($data['gmt_day'] == '03' ? " selected='selected'" : "").">03</option>\n
			<option".($data['gmt_day'] == '04' ? " selected='selected'" : "").">04</option>\n
			<option".($data['gmt_day'] == '05' ? " selected='selected'" : "").">05</option>\n
			<option".($data['gmt_day'] == '06' ? " selected='selected'" : "").">06</option>\n
			<option".($data['gmt_day'] == '07' ? " selected='selected'" : "").">07</option>\n
			<option".($data['gmt_day'] == '08' ? " selected='selected'" : "").">08</option>\n
			<option".($data['gmt_day'] == '09' ? " selected='selected'" : "").">09</option>\n
			</option>\n"; for ($i=10;$i<=31;$i++) { echo "<option".($data['gmt_day'] == $i ? " selected='selected'" : "").">".$i."</option>\n"; } echo "</select>
			.
			<select name='gmt_mon' class='textbox'>\n
			<option".($data['gmt_mon'] == '01' ? " selected='selected'" : "").">01</option>\n
			<option".($data['gmt_mon'] == '02' ? " selected='selected'" : "").">02</option>\n
			<option".($data['gmt_mon'] == '03' ? " selected='selected'" : "").">03</option>\n
			<option".($data['gmt_mon'] == '04' ? " selected='selected'" : "").">04</option>\n
			<option".($data['gmt_mon'] == '05' ? " selected='selected'" : "").">05</option>\n
			<option".($data['gmt_mon'] == '06' ? " selected='selected'" : "").">06</option>\n
			<option".($data['gmt_mon'] == '07' ? " selected='selected'" : "").">07</option>\n
			<option".($data['gmt_mon'] == '08' ? " selected='selected'" : "").">08</option>\n
			<option".($data['gmt_mon'] == '09' ? " selected='selected'" : "").">09</option>\n
			"; for ($i=10;$i<=12;$i++) { echo "<option".($data['gmt_mon'] == $i ? " selected='selected'" : "").">".$i."</option>\n"; } echo "</select>
			.
			<select name='gmt_year' class='textbox'>\n
			"; for ($i=date("Y");$i<=(date("Y")+1);$i++) { echo "<option".($data['gmt_year'] == $i ? " selected='selected'" : "").">".$i."</option>\n"; } echo "</select>
			<br>
			<select name='gmt_hour' class='textbox'>\n
			<option".($data['gmt_hour'] == '01' ? " selected='selected'" : "").">01</option>\n
			<option".($data['gmt_hour'] == '02' ? " selected='selected'" : "").">02</option>\n
			<option".($data['gmt_hour'] == '03' ? " selected='selected'" : "").">03</option>\n
			<option".($data['gmt_hour'] == '04' ? " selected='selected'" : "").">04</option>\n
			<option".($data['gmt_hour'] == '05' ? " selected='selected'" : "").">05</option>\n
			<option".($data['gmt_hour'] == '06' ? " selected='selected'" : "").">06</option>\n
			<option".($data['gmt_hour'] == '07' ? " selected='selected'" : "").">07</option>\n
			<option".($data['gmt_hour'] == '08' ? " selected='selected'" : "").">08</option>\n
			<option".($data['gmt_hour'] == '09' ? " selected='selected'" : "").">09</option>\n
			"; for ($i=10;$i<=23;$i++) { echo "<option".($data['gmt_hour'] == $i ? " selected='selected'" : "").">".$i."</option>\n"; } echo "</select>
			:
			<select name='gmt_min' class='textbox'>\n
			<option".($data['gmt_min'] == '00' ? " selected='selected'" : "").">00</option>\n
			<option".($data['gmt_min'] == '01' ? " selected='selected'" : "").">01</option>\n
			<option".($data['gmt_min'] == '02' ? " selected='selected'" : "").">02</option>\n
			<option".($data['gmt_min'] == '03' ? " selected='selected'" : "").">03</option>\n
			<option".($data['gmt_min'] == '04' ? " selected='selected'" : "").">04</option>\n
			<option".($data['gmt_min'] == '05' ? " selected='selected'" : "").">05</option>\n
			<option".($data['gmt_min'] == '06' ? " selected='selected'" : "").">06</option>\n
			<option".($data['gmt_min'] == '07' ? " selected='selected'" : "").">07</option>\n
			<option".($data['gmt_min'] == '08' ? " selected='selected'" : "").">08</option>\n
			<option".($data['gmt_min'] == '09' ? " selected='selected'" : "").">09</option>\n
			"; for ($i=10;$i<=60;$i++) { echo "<option".($data['gmt_min'] == $i ? " selected='selected'" : "").">".$i."</option>\n"; } echo "</select>
			".$locale['gmt026']."</td>
			</tr>
		
			<td class='tbl2' align='center' colspan='2'>".$locale['681']."</td>\n
		
		<tr>
			<td class='tbl1'>".$locale['675']."</td>
			<td class='tbl1'><select name='maintenance_level' class='textbox'>";
			echo "<option value='102'".($settings['maintenance_level'] == "102" ? " selected='selected'" : "").">".$locale['676']."</option>\n";
			echo "<option value='103'".($settings['maintenance_level'] == "103" ? " selected='selected'" : "").">".$locale['677']."</option>\n";
			echo "<option value='1'".($settings['maintenance_level'] == "1" ? " selected='selected'" : "").">".$locale['678']."</option>\n";
			echo "</select></td>
		</tr>";
		
echo"	<tr>
			<td class='tbl1'>".$locale['657']."</td>
			<td class='tbl1'>
			<select name='maintenance' class='textbox'>";
			echo "<option value='1'".($settings['maintenance'] == "1" ? " selected='selected'" : "").">".$locale['502']."</option>";
			echo "<option value='0'".($settings['maintenance'] == "0" ? " selected='selected'" : "").">".$locale['503']."</option>\n";
			echo "</select></td>
		</tr>
		
		<tr>
			<td class='tbl1'>".$locale['gmt019']."</td>
			<td class='tbl1'><input name='gmt_grafik' class='textbox' value='" . $data['gmt_grafik'] . "'  maxlength='100' /></td>
		</tr>
		
		<tr>
			<td class='tbl1'>".$locale['658']."</td>
			<td class='tbl1'><textarea name='maintenance_message' cols='50' rows='5' class='textbox' style='width:200px;'>".stripslashes($settings['maintenance_message'])."</textarea></td>
		</tr>
		
			<td class='tbl2' align='center' colspan='2'><input type='submit' name='update' class='button' value='" . $locale['gmt009'] . "'></td>\n
		
		</table></form>";
			
closetable();
include "gmt_copyright.php";
require_once THEMES . "templates/footer.php";
?>
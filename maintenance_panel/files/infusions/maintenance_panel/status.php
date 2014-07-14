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

$result = dbquery("SELECT * FROM " . DB_GMT_MAINTENANCE . " WHERE id='1'");
$data = dbarray($result);

echo "<div align='center'><br />\n";
$gesamtbreite = $data['gmt_width'];
$grundwert = $data['gmt_grundwert'];
$prozentwert = $data['gmt_prozentwert'];
$prozent_disp_round = $data['gmt_disp_round'];
$prozentangabe_type = $data['gmt_disp_type']; 
$border = "1px solid black";

$gmt_targetdate = $data['gmt_mon']. "/" . $data['gmt_day'] . "/" . $data['gmt_year'] . " " . $data['gmt_hour'] . ":" . $data['gmt_min'];
$targetday = $data['gmt_year'] . $data['gmt_mon'].$data['gmt_day'];
$thisday = date("Y").date("m").date("d");

$farben = array("000-033" => "red",
                "034-066" => "yellow",
                "067-100" => "green"
);

if(empty($border))
    $border = "1px solid black";

if(empty($prozent_disp_round))
    $prozent_disp_round = 0;
    
if(empty($prozentangabe_type))
    $prozentangabe_type = 0;


if($prozentwert > $grundwert)
    $prozentwert = $grundwert;

$prozentsatz = $prozentwert / $grundwert;
$teilbreite = $prozentsatz * $gesamtbreite;
$prozentsatz_disp = round((($prozentwert / $grundwert) * 100), $prozent_disp_round);

$i = 1;
foreach($farben AS $bereich => $farbe) {
    $einzelwerte = explode("-", $bereich);
    if(($einzelwerte[0] <= $prozentsatz_disp) && ($prozentsatz_disp <= $einzelwerte[1])) {
        $balken_farbe = $farbe;
        break;
    }    
}
if($data['gmt_status'] == 1) {
if(!isset($balken_farbe))
    $balken_farbe = "orange";
    
if($prozentangabe_type == 0) {
    echo $locale['gmt014'];
    echo "<div style='text-align: left; border: $border; width: ".$gesamtbreite."px; height: auto; padding: 0px;'>\n";
    echo "\t<div style='text-align: center; width: ".$teilbreite."px; background-color: $balken_farbe;'>&nbsp;</div>\n";
    echo "</div>\n";
}

elseif($prozentangabe_type == 1) {
    echo $locale['gmt014'] . " " . $locale['gmt015'] . " " . $prozentsatz_disp . "% " . $locale['gmt016'];
if($teilbreite <= 10)
    $wertbreite = $teilbreite;
else
    $wertbreite = $teilbreite - 10;
    
    echo "<div style='text-align: left; border: $border; width: ".$gesamtbreite."px; height: auto; padding: 0px;'>\n";
    echo "\t<div style='text-align: center; width: ".$teilbreite."px; background-color: $balken_farbe; height: 15px;'></div>\n";
    echo "</div>\n";
}

else {
	echo $locale['gmt014'];
    echo "<div style='text-align: left; border: $border; width: ".$gesamtbreite."px; height: auto; padding: 0px;'>\n";
    echo "\t<div style='text-align: center; width: ".$teilbreite."px; background-color: $balken_farbe;'>".$prozentsatz_disp."%</div>\n";
    echo "</div>\n";
}
}

if($data['gmt_timeopt'] == 1) {
echo "<br>
<table class='tbl-border' width='".$gesamtbreite."px' style='vertical-align: top; margin: 0px auto;'>
<td class='tbl2' align='center' colspan='2'>" . $locale['gmt021'] . "</td>\n
<tr>";
if($targetday > $thisday) {
echo"
<td class='tbl2' align='center' colspan='2'><script language='JavaScript'>
var target = \"$gmt_targetdate\";
TargetDate = target;
BackColor = '#FFFFFF optacity(0.5)';
ForeColor = 'red';
CountActive = true;
CountStepper = -1;
LeadingZero = true;
DisplayFormat = '%%D%% " .$locale['gmt022'] ." | %%H%% " .$locale['gmt023'] ." | %%M%% " .$locale['gmt024'] ." | %%S%% " .$locale['gmt025'] ."';
FinishMessage = '".$locale['gmt030']."';
</script><script language='JavaScript' src='".INFUSIONS."/maintenance_panel/js/gmt_maintenance.js'></script></center></td>";
}
else {
echo"
<td class='tbl2' align='center' colspan='2'><script language='JavaScript'>
var target = \"$gmt_targetdate\";
TargetDate = target;
BackColor = '#FFFFFF optacity(0.5)';
ForeColor = 'red';
CountActive = true;
CountStepper = -1;
LeadingZero = true;
DisplayFormat = '%%H%% " .$locale['gmt023'] ." | %%M%% " .$locale['gmt024'] ." | %%S%% " .$locale['gmt025'] ."';
FinishMessage = '".$locale ['gmt030']."';
</script><script language='JavaScript' src='".INFUSIONS."/maintenance_panel/js/gmt_maintenance.js'></script></center></td>";
}
echo"</tr>
</table><br>";
}

?> 
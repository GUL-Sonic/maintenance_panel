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

if (!defined("IN_FUSION")) { die("Access Denied"); }

if (file_exists(INFUSIONS . "maintenance_panel/locale/" . $settings['locale'] . ".php")) {
    include INFUSIONS . "maintenance_panel/locale/" . $settings['locale'] . ".php";
} else {
    include INFUSIONS . "maintenance_panel/locale/German.php";
}
 
if (!defined("DB_GMT_MAINTENANCE")) {
        define("DB_GMT_MAINTENANCE", DB_PREFIX."gmt_maintenance");
}

?>
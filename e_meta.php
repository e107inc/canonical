<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2015 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Plugin Trackback
 *
 *
*/
if (!defined('e107_INIT')) { exit; }

if(e107::isInstalled('canonical') && USER_AREA)
{
	if(e_PAGE == "news.php" && e_QUERY !='')
	{
		list($mode,$id) = explode(".", e_QUERY);
	}

	if(!empty($mode) && $mode=='extend' && !empty($id) && ($url = e107::getDb()->retrieve("canonical","can_url", "can_table='news' AND can_pid=".$id)))
	{
		echo '<link rel="canonical" href="'.$url.'" />';
		echo "\n";
	}

}

?>
<?php
/**
 * download.php
 * Author: Federico Mestrone
 * Created: 19/12/2012 17:34
 * Copyright: 2012, Moodsdesign Ltd
 */

if ( ($pluginid = $_SERVER['QUERY_STRING']) ) {
	/*
	 * Handle download requests for a registered plugin
	 */
	$filename = "data/$pluginid";
	if ( is_readable($filename) ) {
		$raw = file_get_contents($filename);
		if ( ($data = unserialize($raw)) ) {
			if ( ($download = $data['plugin_guid']) ) {
				header("Location: http://community.elgg.org/plugins/download/$download");
			}
		}
	}
}

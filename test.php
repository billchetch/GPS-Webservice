<?php
require_once('_include.php');

use chetch\Config as Config;
use chetch\Utils as Utils;
use chetch\sys\SysInfo as SysInfo;

try{
	$lf = "\n";
	
	echo 'test'.$lf;

	$si = SysInfo::createInstance();
	$d = $si->getData('gps_device_status');
	print_r($d);

	echo 'finished';
} catch (Exception $e){
	echo "EXCEPTION: ".$e->getMessage();
}


?>
<?php

use chetch\api\APIException as APIException;
use chetch\sys\SysInfo as SysInfo;

class GPSAPIHandleRequest extends chetch\api\APIHandleRequest{
	
	protected function processGetRequest($request, $params){
		$data = array();
		switch($request){
			case 'test':
				$data = array('response'=>"GPS test Yeah baby2");
				break;
				
			case 'status':
				//$data = SysInfo::getInfo('gps_device_status');
				$si = SysInfo::createInstance();
				$data = $si->getData('gps_device_status');
				break;

			case 'position':
				if(empty($params['date']))throw new Exception("Please supply a date value");
				$pos = GPSPosition::getPosition($params['date']);
				$data = $pos->getRowData();
				break;

			case 'latest-position':
				$si = SysInfo::createInstance();
				$data = $si->getData('gps-device-status');
				if(!$data['Connected'])throw new Exception("Cannot get latest position because device is not connected");

				$pos = GPSPosition::getLatestPosition();
				$data = $pos->getRowData();
				break;
		}
		return $data;
	}
}
?>

<?php

use chetch\api\APIException as APIException;

class GPSAPIHandleRequest extends chetch\api\APIHandleRequest{
	
	protected function processGetRequest($request, $params){
		$data = array();
		switch($request){
			case 'test':
				$data = array('response'=>"GPS test Yeah baby");
				break;
				
			case 'status':
				break;

			case 'latest-position':
				$pos = GPSPosition::getLatestPosition();
				$data = $pos->getRowData();
				/*$data['latitude'] = ((float)rand() / (float)getrandmax())*360.0 - 180;
				$data['longitude'] = ((float)rand() / (float)getrandmax())*180.0 - 90;
				$data['bearing'] = ((float)rand() / (float)getrandmax())*360;
				$data['speed_mps'] = ((float)rand() / (float)getrandmax())*50;
				$data['updated'] = self::now();*/
				break;
		}
		return $data;
	}
}
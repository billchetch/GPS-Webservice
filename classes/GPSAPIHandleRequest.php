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
		}
		return $data;
	}
}
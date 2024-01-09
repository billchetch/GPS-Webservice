<?php

class GPSPosition extends \chetch\db\DBObject{

	static public function initialise(){
		$t = \chetch\Config::get('GPS_TABLE', 'gps_positions');
		self::setConfig('TABLE_NAME', $t);

		$tzo = self::tzoffset();
		$sql = "SELECT id,latitude,longitude,hdop,vdop,pdop,bearing,speed,timestamp, CONCAT(timestamp,' ', '$tzo') AS updated FROM $t";
		self::setConfig('SELECT_SQL', $sql);
	}

	static function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
	{
		// convert from degrees to radians
		$latFrom = deg2rad($latitudeFrom);
		$lonFrom = deg2rad($longitudeFrom);
		$latTo = deg2rad($latitudeTo);
		$lonTo = deg2rad($longitudeTo);

		$latDelta = $latTo - $latFrom;
		$lonDelta = $lonTo - $lonFrom;

		$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
		return $angle * $earthRadius;
	}

	static public function getLatestPosition($beforeID = null){
		$filter = $beforeID ? "id < $beforeID" : null;
		$rows = self::createCollection(null, $filter, "timestamp DESC", "0,1");
		$latest = count($rows) ? $rows[0] : null;
		return $latest;
	}

	static public function getPosition($date = null){
		if(empty($date)){
			return static::getLatestPosition();
		}

		$sort = "ABS(TIMESTAMPDIFF(SECOND,timestamp,'$date'))";
		$rows = self::createCollection(null, null, $sort, "0,1");
		$latest = count($rows) ? $rows[0] : null;
		return $latest;
	}
}
?>
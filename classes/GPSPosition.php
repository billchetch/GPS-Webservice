<?php

class GPSPosition extends \chetch\db\DBObject{

	static public function initialise(){
		$t = \chetch\Config::get('GPS_TABLE', 'gps_positions');
		self::setConfig('TABLE_NAME', $t);

		$tzo = self::tzoffset();
		$sql = "SELECT *, CONCAT(timestamp,' ', '$tzo') AS updated FROM $t";
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
		$rows = self::createCollection(null, $filter, "updated DESC", "0,1");
		$latest = count($rows) ? $rows[0] : null;
		return $latest;
	}
}
?>
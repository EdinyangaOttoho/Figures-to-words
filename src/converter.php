<?php
	$unit = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
	$tensoften = ['eleven','twelve','thirteen','fourteen','fifteen','sixteen', 'seventeen', 'eighteen', 'nineteen'];
	$tens = ['ten', 'twenty', 'thirty', 'fourty', 'fifty', 'sixty', 'seventy','eighty','ninety'];
	$positions = ['trillion', 'billion', 'million', 'thousand',''];

	function getWords($str) {
		$str = strval($str);
		global $unit;
		global $tensoften;
		global $tens;
		global $positions;

		$words = "";

		$array = str_split($str);

		$cnt = 0;

		$str = "";

		for ($i = count($array) - 1; $i >= 0; $i--) {
			$cnt++;
			if ($cnt % 3 == 0 && $i != 0) {
				$str .= $array[$i].",";
			}
			else {
				$str .= $array[$i];
			}
		}
		$com = strrev($str);
		$chunks = (strpos($com, ",") !== false)?explode(",", $com):[$com];
		function retval($chunks) {

			global $unit;
			global $tensoften;
			global $tens;
			global $positions;

			$digits = floatval($chunks[0]);
			if ($digits <= 9) {
				return $unit[$digits];
			}
			else if ($digits >= 10 && $digits <= 90 && ($digits % 10 == 0)) {
				return $tens[($digits/10)-1];
			}
			else if ($digits >= 11 && $digits <= 19) {
				return $tensoften[($digits - 10) - 1];
			}
			else if ($digits >= 20 && $digits <= 99 && ($digits % 10 != 0)) {
				return $tens[floatval($chunks[0][0]) - 1]."-".$unit[floatval($chunks[0][1])];
			}
			else if ($digits >= 100 && $digits <= 999) {
				$compart = floor($digits / 100);
				if ($digits % 100 == 0) {
					return $unit[$compart]." hundred";	
				}
				else {
					return $unit[$compart]." hundred and ".retval([strval($digits % 100)]);
				}
			}
		}
		if (count($chunks) == 1) {
			$words = retval($chunks);
		}
		else {
			$ret = [];
			$c = -1;
			$count = count($positions) - count($chunks);
			for ($i = $count; $i < count($positions); $i++) {
				$c++;
				$chunks[$c] = floatval($chunks[$c]);
				if (floatval($chunks[$c]) == 0) {
					
				}
				else {
					array_push($ret, retval([strval(floatval($chunks[$c]))])." ".$positions[$i]);
				}
			}
			$words = implode(", ", $ret);
		}
		$result = trim(ucwords(strtolower($words)));
		return $result;
	}
?>
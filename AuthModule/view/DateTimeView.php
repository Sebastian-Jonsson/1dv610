<?php

namespace View;

class DateTimeView {

	public function show() : string {

		$dayWeek = date('l');
		$numericDayWeek = date('j');
		$suffix = date("S");
		$monthAndYear = date('F Y');
		$dayTime = date('h:i');

		$timeString = $dayWeek . ", the " 
					. $numericDayWeek . $suffix . " of " 
					. $monthAndYear . ", The time is " 
					. $dayTime;

		return '<p>' . $timeString . '</p>';
	}
	
}
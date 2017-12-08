<?php
class Store{
	//setters
	public function setName($name){
		return ucwords(strtolower($name));
	}
	public function shortContent($content){
		return substr($content,0,rand(100, 200));
	}
	public function time_elapsed($ptime){
		$etime = time() - $ptime;
		$count = array(
				365 * 24 * 60 * 60 => 'year',
				30 * 24 * 60 * 60 => 'month',
					24 * 60 * 60  => 'day',
						60 * 60 => 'hour',
							60 => 'minute',
							1 => 'second'
					);
		$count_plural = array(
				'year' => 'years',
				'month' => 'months',
				'day' => 'days',
				'hour' => 'hours',
				'minute' => 'minutes',
				'second' => 'seconds',
			);
		foreach ($count as $secs => $str) {
			//calculate time elapsed
			$d = $etime / $secs;
			//if count 1
			if($d >= 1){
			//roundof variable $d because we don't want the output will 3.22123123 secs ago
				$r = round($d);
				return $r .' '.($r > 1 ? $count_plural[$str] : $str).' ago';
			}
		}
	}
}
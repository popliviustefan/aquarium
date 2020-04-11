<?php 

function get_param_array($s){
	$r = array("[", "]", "'", "\\n");
	$s = str_replace($r, "", $s);
	$pieces = explode(", ",$s);
	$ret = array();
	for($i = 0; $i < sizeof($pieces) - 1; $i += 2){
		$ret[$pieces[$i]] = $pieces[$i + 1];
		//echo '('.$pieces[$i].'='.$ret[$pieces[$i]].') ';
	}
	return $ret;
}

/*
function get_param_array_socket($s){
	$p = explode('~',$s);
	$ret = array();
	for($i = 0; $i < sizeof($p); $i++){
		$v = $p[$i];
		$ret[$i] = sprintf('%02d:%02d',(int)($v / 60), $v % 60);
		//echo '('.$ret[$i].') ';
	}
	return $ret;
}
*/




class C
{
	# set env tank label
	const SET_TEMP = 				'SET_TEMP';
	const SET_PH = 					'SET_PH';
	const ENV_TEMP = 				'ENV_TEMP';
	const TANK_TEMP = 				'TANK_TEMP';
	const TANK_PH = 				'TANK_PH';
	const TANK_FANS = 				'TANK_FANS';
	const TANK_AC = 				'TANK_AC';
	const TANK_OVERFLOW = 			'TANK_OVERFLOW';
	const SET_SOCKET_ = 			['0', 'SET_SOCKET_1', 'SET_SOCKET_2', 'SET_SOCKET_3', 'SET_SOCKET_4', 'SET_SOCKET_5', 'SET_SOCKET_6', 'SET_SOCKET_7', 'SET_SOCKET_8']; 
	const SET_SOCKET_SCHEDULE_ = 	['0', 'SET_SOCKET_SCHEDULE_1', 'SET_SOCKET_SCHEDULE_2', 'SET_SOCKET_SCHEDULE_3', 'SET_SOCKET_SCHEDULE_4', 'SET_SOCKET_SCHEDULE_5', 'SET_SOCKET_SCHEDULE_6', 'SET_SOCKET_SCHEDULE_7', 'SET_SOCKET_SCHEDULE_8'];
	const LABEL_SOCKET_ = 			['0', 'LABEL_SOCKET_1', 'LABEL_SOCKET_2', 'LABEL_SOCKET_3', 'LABEL_SOCKET_4', 'LABEL_SOCKET_5', 'LABEL_SOCKET_6', 'LABEL_SOCKET_7', 'LABEL_SOCKET_8'];
	const TANK_SOCKET_ = 			['0', 'TANK_SOCKET_1', 'TANK_SOCKET_2', 'TANK_SOCKET_3', 'TANK_SOCKET_4', 'TANK_SOCKET_5', 'TANK_SOCKET_6', 'TANK_SOCKET_7', 'TANK_SOCKET_8'];
	
	#add to the end
	#add also to aquarium_file_io.py
}

?>


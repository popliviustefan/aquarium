<?php
include 'functions.php';


function encode($skt) {
    if ($_POST[$skt] == 'ON') return '1';
    elseif ($_POST[$skt] == 'OFF') return '0';
    elseif ($_POST[$skt] == 'AUTO') return '2';
} 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $p = C::SET_TEMP.' '.$_POST['temperature_set'].' '.C::SET_PH.' '.$_POST['ph_set'];
   
	for ($i = 1; $i <= 8; $i++){
	    $p .= ' '.C::LABEL_SOCKET_[$i].' "'.$_POST['label'.$i];
	    $p .= '" '.C::SET_SOCKET_[$i].' '.encode('skt'.$i);
	    $q = '';
	    for ($j = 0; $j < 5; $j++){
		$q .= $_POST['on'.$i.'_'.$j].'~';
		$q .= $_POST['off'.$i.'_'.$j].'~';
	    }
	    $p .= ' '.C::SET_SOCKET_SCHEDULE_[$i].' '.substr($q, 0, -1);
	}
	
	//echo $p;
	exec("python3 python/set_current_data.py ".$p);
	
/*	
	. $_POST['temperature_set'] . " " . $_POST['ph_set'] . " "
	. encode('skt1') . " " . $_POST['on1'] . " " .$_POST['off1'] . " "
	. encode('skt2') . " " . $_POST['on2'] . " " .$_POST['off2'] . " "
	. encode('skt3') . " " . $_POST['on3'] . " " .$_POST['off3'] . " "
	. encode('skt4') . " " . $_POST['on4'] . " " .$_POST['off4'] . " "
	. encode('skt5') . " " . $_POST['on5'] . " " .$_POST['off5'] . " "
	. encode('skt6') . " " . $_POST['on6'] . " " .$_POST['off6'] . " "
	. encode('skt7') . " " . $_POST['on7'] . " " .$_POST['off7'] . " "
	. encode('skt8') . " " . $_POST['on8'] . " " .$_POST['off8']
	);
*/
}

ob_start();
header("Location: details.php");
ob_end_flush();
die();


?>

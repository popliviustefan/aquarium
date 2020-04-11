<?php
	session_start();
	$tmp = exec("python3 python/get_current_data.py");
	include 'functions.php';
	$p = get_param_array($tmp);
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" type="text/css" href="css/aquarium.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<title>Aquarium</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="js/details.js"></script>
	</head> 
<body>
<?php
	if(!isset($_SESSION['pass']) or $_SESSION['pass'] != 'zaza') {
		header("Location:index.php");  
		exit();
	}
?>
	<nav class="navbar navbar-expand-md bg-dark navbar-dark">
		<a class="navbar-brand" href="#"><h2><div id="timer"></div></h2></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="collapsibleNavbar">
		<form method="post">
			<ul class="navbar-nav">
			  <li class="nav-item">
				<button class="btn btn-primary btn-lg btn-block" formaction="modify.php" type="submit" name="Name_modify" value="value_modify">Modify parameters</button>
			  </li>
			  <li class="nav-item">
				<input class="btn btn-info btn-lg btn-block" Type="button" VALUE="Data history" onclick="window.location.href='http://192.168.1.20:3000/d/0wDKfJbWz/aquarium?orgId=1'">
			  </li>
			  <li class="nav-item">
				<button class="btn btn-danger btn-lg btn-block" formaction="reboot.html" type="submit" name="Name_reboot" value="value_reboot" >Reboot</button>
			  </li>    
			  <li class="nav-item">
				<button class="btn btn-warning btn-lg btn-block" formaction="logout.php" type="submit" name="Name_logout" value="value_logoff">Logout</button>
			  </li>
			</ul>
		</form>
		</div>  
	</nav>
	<br>
	
	<div class="container">
	<div class="jumbotron">
	<div class="page-header"><h2>Tank parameters:</h2></div>
	
	<p><?php echo(strftime("%d/%m/%Y")); ?></p>
	
	<p><div style="display:inline">Temperature Set: <b><?php echo $p[C::SET_TEMP]; ?> &#176;C</b>&nbsp;&nbsp; Tank: </div><b><div id="id_tank_temp" style="display:inline"><?php echo $p[C::TANK_TEMP]; ?></div> &#176;C</b></p>
	
	<p><div style="display:inline">Environment Temperature: </div><b><div id="id_env_temp" style="display:inline;"><?php echo $p[C::ENV_TEMP] ?></div> &#176;C</b></p>
	
	<p><div style="display:inline">Fans: <b><div id="id_tank_fans" style="display:inline;"><?php if ($p[C::TANK_FANS]) {echo 'ON';} else {echo 'OFF';} ?></div></b>&nbsp;&nbsp; A/C: <b><div id="id_tank_ac" style="display:inline;"><?php if ($p[C::TANK_AC]) {echo 'ON';} else {echo 'OFF';} ?></div></b></p>
	
	<p><div style="display:inline">Ph Set: </div><div style="display:inline;"><b><?php echo $p[C::SET_PH] ?></b>&nbsp;&nbsp; Tank: <b><div id="id_tank_ph" style="display:inline"><?php echo $p[C::TANK_PH] ?></div></b></div></p>
	
	<p><div style="display:inline">Overflow: </div><b><div id="id_tank_overflow" style="display:inline"><?php if ($p[C::TANK_OVERFLOW]) {echo 'ON';} else {echo 'OFF';} ?></div></b></p>
	
	<table>
<?php 
	for($i = 1; $i <= 8; $i++){
		echo '<tr>';
		echo '	<td>'.$p[C::LABEL_SOCKET_[$i]].'</td>';
		echo '	<td>&nbsp;Skt '.$i.':&nbsp;</td>';
		echo '	<td><b>'.($p[C::TANK_SOCKET_[$i]] ? 'ON':'OFF').'</b></td>';
		$first = 1;
		$a = explode('~', $p[C::SET_SOCKET_SCHEDULE_[$i]]);
		for ($j = 0; $j < 10; $j += 2){
			if ($a[$j] == $a[$j + 1]) continue;
			if ($first) {
				echo '<td>&nbsp;('.$a[$j].' - '.$a[$j + 1].')</td>';
				$first = 0;
			}
			else{
				echo '</tr><tr><td></td><td></td><td></td><td>&nbsp;('.$a[$j].' - '.$a[$j + 1].')</td>';
			}
		}
		echo '</tr>';
	}
?>
	</table>
		
			

		
</div></div>

</body>
</html>

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
  <script src="js/modify.js"></script>
  <link rel="stylesheet" type="text/css" href="css/bootstrap-clockpicker.min.css">
  <script src="js/bootstrap-clockpicker.min.js"></script>
  <title>Aquarium</title>
</head>
<body>
<?php
 if(!isset($_SESSION['pass']) or $_SESSION['pass'] != 'zaza') 
 {
  header("Location:index.php");  
  exit();
 }
?>
	<form action="" method="post">
	<nav class="navbar navbar-expand-md bg-dark navbar-dark">
		<a class="navbar-brand" href="#"><h2>Modify params</h2></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="collapsibleNavbar">
		
			<ul class="navbar-nav">
			  <li class="nav-item">
				<button class="btn btn-warning btn-lg btn-block" formaction="save.php" type="submit" name="Modify" value="value_modify">Modify</button>
			  </li>
			  <li class="nav-item">
				<button class="btn btn-info btn-lg btn-block" formaction="details.php" type="submit" name="Back" value="value_back">Back</button>
			  </li>
			</ul>
		
		</div>  
	</nav>
	<br>

	<div class="container">
	<div class="jumbotron">
	

		<div class="form-group">
		  
		  <div style="float:left; display:table; height:40px; width:150px; ">
		    <span style="display:table-cell;vertical-align:middle;">
			<b>Temperature Set : </b>
		    </span>
		  </div>
		  <div style="width:70px; float:left;">
		      <select class="form-control" data-role="select-dropdown" data-profile="minimal" name = "temperature_set">
			  <?php for ($i = 22; $i <= 30; $i++) {
				  if ($p[C::SET_TEMP] == $i)
					  echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
				  else echo '<option value="'.$i.'">'.$i.'</option>';
				}
			  ?>
		      </select>
		  </div>
		  <div>&nbsp;</div><div>&nbsp;</div>
		  
		  <div style="float:left; display:table; height:40px; width:150px; ">
		    <span style="display:table-cell;vertical-align:middle;">
			<b>PH Set : </b>
		    </span>
		  </div>
		  <div style="width:70px; float:left;">
		      <select class="form-control" data-role="select-dropdown" data-profile="minimal" name = "ph_set">
			  <?php for ($i = 6; $i <= 8; $i+=0.1) {
				  if (abs($p[C::SET_PH] - $i) < 0.001)
					  echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
				  else echo '<option value="'.$i.'">'.$i.'</option>';
				}
			  ?>
		      </select>
		  </div>
		  <div>&nbsp;</div><div>&nbsp;</div>
		</div>
		
			
		  <?php $on = ''; $off = ''; $auto = '';
				for ($i = 1; $i <= 8; $i++) {
					switch ((int)$p[C::SET_SOCKET_[$i]]){
						case 0: $on = ''; $off = 'checked'; $auto = ''; break;
						case 1: $on = 'checked'; $off = ''; $auto = ''; break;
						case 2: $on = ''; $off = ''; $auto = 'checked'; break;
					}
					
					echo '<div class="row mb-2" style="background-color:#A3C8EC; padding:5px;">
					       <div class="mx-auto pb-2"><h5><b>Socket '.$i.'</b></h5></div>
					       <div class="w-100"></div>
					       <div class="col-auto"><span class="allign-middle" ><b>Label: </b></span></div>
					       <div class="col-auto allign-middle"><input type="text" name="label'.$i.'" style="width:120px;" value="'.$p[C::LABEL_SOCKET_[$i]].'"></div>
					       <div class="btn-group btn-group-toggle col-md-6 col-xs-12 m-2" data-toggle="buttons">
						<label class="btn btn-primary"><input type="radio" name="skt'.$i.'" value="ON" '.$on.'> &nbsp&nbspON&nbsp&nbsp</label>&nbsp;
						<label class="btn btn-primary"><input type="radio" name="skt'.$i.'" value="OFF" '.$off.'> &nbsp&nbspOFF&nbsp</label>&nbsp;
						<label class="btn btn-primary"><input type="radio" name="skt'.$i.'" value="AUTO" '.$auto.'> SCHEDULE</label>
					       </div>
					       <div class="w-100"></div>';
					if ($auto == 'checked')	
					     $disp = '';
					else $disp = ' style="display: none"';
					echo	'<div id="int'.$i.'" class="row col-12" '.$disp.'>';
					$a = explode('~', $p[C::SET_SOCKET_SCHEDULE_[$i]]);
					for ($j = 0; $j < 5; $j++){
					  echo		'  <div class="col-xs-6" style="background-color:#E3CEF6; margin-right:10px;">
							    <table>
							     <tr>
							      <td>
							       <div class="input-group clockpicker" data-autoclose="true" style="width:70px;">
								<input class="form-control" type="text" readonly="true" name="on'.$i.'_'.$j.'" value="'.$a[$j * 2].'">
							       </div>
							      </td>
							      <td><div>&nbsp;&nbsp;to&nbsp;&nbsp;</div></td>
							      <td>
							       <div class="input-group clockpicker" data-autoclose="true" style="width:70px;">
								<input class="form-control" type="text" readonly="true" name="off'.$i.'_'.$j.'" value="'.$a[$j * 2 + 1].'">
							       </div>
							      </td>
							     </tr>
							    </table>
							   </div>';
					 }
					 echo '</div></div>'; }?>
			
<script type="text/javascript">
$('.clockpicker').clockpicker();
</script>

		</div>
		</div>

	</form>

</body>
</html>

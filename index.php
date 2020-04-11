<?php   session_start();  ?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="css/aquarium.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <title>Aquarium</title>
</head>
<body>
	<nav class="navbar navbar-expand-md bg-dark navbar-dark">
		<a class="navbar-brand" href="#"><h2>Password</h2></a>
	</nav>
	
	<br>
	<div class="container">
	<div class="jumbotron">
	

	<form action="index.php" method="post">
		<input class="form-control input-lg" type="password" name="pass" /><br>
<?php
	if(isset($_SESSION['pass']) and $_SESSION['pass'] == 'zaza')   
	{
		header("Location: details.php");
		exit();
	}

	if($_POST)
	{
		$x = $_POST['pass'];
		if($x != 'zaza')
		{
			echo "wrong password<br>";
		}
		else
		{
			$_SESSION['pass'] = 'zaza';
			header("Location: details.php");
			exit();
		}
	}

?>
		<br>
		<button class="btn btn-info btn-lg btn-block" type="submit">Login</button>
	</form>
	</div></div>
</body>
</html>

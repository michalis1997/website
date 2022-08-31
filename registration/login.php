<?php include_once('server.php') ?>

<!DOCTYPE html>
<html lang="el">
<head>
  <title>Login</title>
  <!-- Setting the viewport to make your website look good on all devices -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

    
</head>
<body>

	<!-- sidebar -->
	<div class="sidebar">
		<p id="header-log">Σύστημα πληθοποριστικής συλλογής και ανάλυσης δεδομένων κίνησης HTTP</p>
	</div>
	<!-- /sidebar -->

	<div class="header">
		<h2>Login</h2>
	</div>

	<!-- Post method because we don't want to display password in address bar (URL) -->
	<!-- Login form -->
	<form method="post" action="login.php" >

		<?php include("errors.php"); ?>
		
		<div class="input-group">
			<label>Username</label>
			<input type="text" placeholder="username" name="username" >
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" placeholder="password" name="password" id="myInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" title="Must contain at least 8 characters, one number and one uppercase and lowercase letter.">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="login_btn">Login</button>
		</div>
		<p>
			Not yet a member? <a href="register.php">Sign up</a>
		</p>

	</form>
	<!-- /Login form -->

	<div id="copyrights">
		<img src="images/secure-logo.png" style="width:2vw; border-radius: 0.97vw 0.97vw 0.97vw 0.97vw ;">
			<span style="font-size: large; color:white";>
					You are entering the safe login zone 
			</span>
	</div>


	<script src="showPass.js"></script>
</body>
</html>
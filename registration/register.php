<?php include_once('server.php') ?>

<!DOCTYPE html>
<html lang="el">
<head>
  <title>Register</title>
  <!-- Setting the viewport to make your website look good on all devices -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- link to style.css -->
  <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

  	<div class="header">
  		<h2>Register</h2>
  	</div>

	<!-- The part of the code that receives this form data is written in the server.php file and that's why we are including register.php file -->
	<!-- Register form -->
	<form method="post" action="register.php">

		<?php include("errors.php"); ?>
		
		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username">
		</div>
		<div class="input-group">
			<label>Email</label>
			<input type="email" name="email" >
		</div>
		<div class="input-group">
			<label>Password <span style="color: grey; font-size:small"><br>(It must contain at least: 8 characters, 1 digit, 1 upper-case, 1 lower-case letters and 1 non-alphanumeric character)</span></label>
			<input type="password" name="password_1"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" title="Must contain at least 8 characters, one number and one uppercase and lowercase letter.">
		</div>
		<div class="input-group">
			<label>Confirm password</label>
			<input type="password" name="password_2"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" title="Must contain at least 8 characters, one number and one uppercase and lowercase letter.">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="register_btn">Register</button>
		</div>
		<p>
			Already a member? <a href="login.php">Sign in</a>
		</p>
		
	</form>
	<!-- Register form -->

	<div id="copyrights">
		<p> &copy; Copyrights <strong>Our Team</strong>. All Rights Reserved </p>
	</div>

</body>
</html>
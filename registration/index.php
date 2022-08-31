<?php 

	include('server.php');
		
	// If the user is not logged in and tries to access this page, they are automatically redirected to the login page. 
	if (!isset($_SESSION['user'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}

	// Checks if the user has clocked the logout button. If yes, the system logs them out and redirects them back to the login page. 
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: login.php");
	}
?>

<!DOCTYPE html>
<html lang="el">
<head>
	<title>Welcome</title>
	<!-- Setting the viewport to make your website look good on all devices -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- link to css file -->
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body >

	<div class="header">
		<h2>Welcome <strong><?php echo $_SESSION['user']['username']; ?></strong> !</h2>
	</div>

	<div class="content">

		<!-- notification message if success -->
		<?php if (isset($_SESSION['success'])) : ?>
		<div class="error success" >
			<h3>
			<?php 
				echo $_SESSION['success']; 
				unset($_SESSION['success']);
			?>
			</h3>
		</div>
		<?php endif ?>

		<!-- logged in user information -->
		<div class="profile_info">
			<div>
				<img src="images/user_profile.png">
				<?php if (isset($_SESSION['user'])) : ?>
						<p><strong><?php echo $_SESSION['user']['username']; ?></strong></p>
						<small>
							<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
							<br>
						</small>
						<br>
						<p><b><a class="navigate" href="../website/user-page/user_app.php" target="_blank">CLICK HERE TO START</a></b></p>
						<br>
						<!-- logout link to index.php->login page -->
						<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
				<?php endif ?>
			</div>
		</div>
		<!-- /logged in user information -->
		
	</div>

	<div id="copyrights">
      	<p>
       		&copy; Copyrights <strong>Our Team</strong>. All Rights Reserved
      	</p>
	</div>


</body>
</html>
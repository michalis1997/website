<?php 
	include('../server.php');

	if (!isAdmin()) {
		$_SESSION['msg'] = "You must log in first";
		header('location: ../login.php');
	}
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user']);
		header("location: ../login.php");
	}
?>

<!DOCTYPE html>
<html lang="el">
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<style>
        .header {
            background: #003366;
        }
        button[name=register_btn] {
            background: #003366;
        }
	</style>

	<!-- prevent go back to user_app.html when press logout button -->
	<script type = "text/javascript" >
		function preventBack(){window.history.forward();}
		setTimeout("preventBack()", 0);
		window.onunload=function(){
			null
		};
 	</script>

</head>
<body>

	<div class="header">
		<h2>Admin - Home Page</h2>
	</div>

	<div class="content">

		<!-- notification message -->
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
		<!-- /notification message -->

		<!-- logged in user information -->
		<div class="profile_info">
			<div>
				<img src="../images/admin_profile.png"  >
				<br>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>
					
					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
						<br>	
					</small>
					<br>
					<p><b><a class="navigate" href="../../website/admin-page/admin_app.php" target="_blank">CLICK HERE TO START</a></b></p>
					<br>
					<a href="home.php?logout='1'" style="color: red;">logout</a>
                    &nbsp; <a href="create_user.php"> + add user</a>
					

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
<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "../verify_logged_out.php";
	require "../header.php";
?>

<html>
	<head>
		<title>LMS</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../css/form_styles.css">
		<link rel="stylesheet" type="text/css" href="css/index_style.css">
		<style type="text/css">
			.container{
				margin:3%; 
				margin-left: 32%;
				background-color:black;
				width: 35%;
				height:70%;
				padding-left:5%;
				padding-right: 5%;
				opacity: 0.6;
				border-radius: 35px;
				border:4px solid yellow;
				}
			

			}
		</style>

	</head>
	<body style="background: #15163d21;background-image: url(./img/ab.jpg">
		<div class="container">
		<form class="cd-form" method="POST" action="#">
		
		<center><legend>Librarian Login</legend></center>

			<div class="error-message" id="error-message">
				<p id="error"></p>
			</div>
			
			<div class="icon">
				<input class="l-user" type="text" name="l_user" placeholder="Username" required />
			</div>
			
			<div class="icon">
				<input class="l-pass" type="password" name="l_pass" placeholder="Password" required />
			</div>
			
			<input type="submit" value="Login" name="l_login"/>

			
			
		</form>
		<p align="center"><a href="../index.php" style="text-decoration:none;">Go Back</a>
		</div>
	</body>
	
	<?php
		if(isset($_POST['l_login']))
		{
			$username = $_POST['l_user'];
			$password =sha1($_POST['l_pass']);
			$sql ="SELECT id FROM librarian WHERE username = '$username' and password = '$password'";
			$result = $con->query($sql);

			// $query = $con->prepare("SELECT id FROM librarian WHERE username = ? AND password = ?;");
			// $query->bind_param("ss", $_POST['l_user'], sha1($_POST['l_pass']));
			// $query->execute();

			// if(mysqli_num_rows($query->get_result()) != 1)
			if ($result->num_rows != 1)
				echo error_without_field("Invalid username/password combination");
			else
			{
				$_SESSION['type'] = "librarian";
				$_SESSION['id'] = mysqli_fetch_array($result)[0];
				$_SESSION['username'] = $_POST['l_user'];
				header('Location:dashboard.php');
			}
		}
	?>
	<?php
			include('../footer.php');
		?>
</html>
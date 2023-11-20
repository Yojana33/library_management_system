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
				height:75%;
				padding-left:5%;
				padding-right: 5%;
				opacity: 0.6;
				border-radius: 35px;
				border:4px solid yellow;
				}
			

		</style>
	</head>
	<body style="background-color:#1b8c95; background-image: url(./img/pg.jpg) ">
		<div class="container">
		<form class="cd-form" method="POST" action="#">
		
		<center><legend><b>Member Login</b></legend></center>
			
			<div class="error-message" id="error-message">
				<p id="error"></p>
			</div>
			
			<div class="icon">
				<input class="m-user" type="text" name="m_user" placeholder="Username" required />
			</div>
			
			<div class="icon">
				<input class="m-pass" type="password" name="m_pass" placeholder="Password" required />
			</div>
			
			<input type="submit" value="Login" name="m_login" />
			
			<br /><br /><br /><br />
			
			<p align="center">Don't have an account?&nbsp;<a href="register.php" style="text-decoration:none; color:red;">Register Now!</a>

			<p align="center"><a href="../index.php" style="text-decoration:none;">Go Back</a>
		</form>
	</div>
		<?php
			include('../footer.php');
		?>
	</body>
	
	<?php
		if(isset($_POST['m_login']))
		{			
			$username = $_POST['m_user'];
			$password = ' '.sha1($_POST['m_pass']);
			$sql ="SELECT id FROM member WHERE username = '$username' and password = '$password'";
			$result = $con->query($sql);

			if ($result->num_rows != 1) {
				echo error_without_field("Invalid details or Account has not been activated yet!");
			}else 
			{
				$resultRow = mysqli_fetch_array($result);			
				$_SESSION['type'] = "member";
				$_SESSION['id'] = $resultRow[0];
				$_SESSION['username'] = $_POST['m_user'];
				header('Location: home.php');
			}
		}
	?>
	
</html>
<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "../header.php";
?>

<html>
	<head>
		<title>LMS</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../css/form_styles.css">
		<link rel="stylesheet" href="css/register_style.css">
		<style type="text/css">
			.container{
					margin:3%; 
				margin-left: 32%;
				background-color:black;
				width: 35%;
				height:105%;
				padding-left:5%;
				padding-right: 5%;
				opacity: 0.6;
				border-radius: 35px;
				border:4px solid yellow;
				}
			}
		</style>
	</head>
	<body  style="background: #15163d21;background-image: url(./img/pg.jpg)">
		<div class="container">
		<form class="cd-form" method="POST" action="#">
			<center><legend><b>Member Registration</b></legend><p>Please fillup the form below:</p></center>
			
				<div class="error-message" id="error-message">
					<p id="error"></p>
				</div>

				<div class="icon">
					<input class="m-name" type="text" name="m_name" placeholder="Full Name" required />
				</div>

				<div class="icon">
					<input class="m-email" type="email" name="m_email" id="m_email" placeholder="Email" required />
				</div>
				
				<div class="icon">
					<input class="m-user" type="text" name="m_user" id="m_user" placeholder="Username" required />
				</div>
				
				<div class="icon">
					<input class="m-pass" type="password" name="m_pass" placeholder="Password" required />
				</div>
					
				
				<br />
				<input type="submit" name="m_register" value="Submit" />
		</form>
	</div>
	</body>
	
	<?php
		if(isset($_POST['m_register']))
		{
			$query = $con->prepare("(SELECT username FROM member WHERE username = ?) UNION (SELECT username FROM pending_registrations WHERE username = ?);");
			$query->bind_param("ss", $_POST['m_user'], $_POST['m_user']);
			$query->execute();
			if(mysqli_num_rows($query->get_result()) != 0)
				echo error_with_field("The username you entered is already taken", "m_user");
			else
			{
				$query = $con->prepare("(SELECT email FROM member WHERE email = ?) UNION (SELECT email FROM pending_registrations WHERE email = ?);");
				$query->bind_param("ss", $_POST['m_email'], $_POST['m_email']);
				$query->execute();
				if(mysqli_num_rows($query->get_result()) != 0)
					echo error_with_field("An account is already registered with that email", "m_email");
				else
				{
					 $name = $_POST['m_name'];
					 $email = $_POST['m_email'];
					 $username = $_POST['m_user'];
					 $password = sha1($_POST['m_pass']);
					$sql = "INSERT INTO pending_registrations (username, password, name, email)
							VALUES ('$username','$password','$name','$email')";
					if($con->query($sql) === TRUE)
						echo success("Details submitted, soon you'll will be notified after verifications!");
					else
						echo error_without_field("Couldn\'t record details. Please try again later");
				}
			}
		}
	?>
	<?php
			include('../footer.php');
		?>
</html>
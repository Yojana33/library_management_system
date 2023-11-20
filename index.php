<?php
	require "db_connect.php";
	require "header.php";
	session_start();
	
	if(empty($_SESSION['type']));
	else if(strcmp($_SESSION['type'], "librarian") == 0)
		header("Location: librarian/dashboard.php");
	else if(strcmp($_SESSION['type'], "member") == 0)
		header("Location: member/home.php");
?>

<html>
	<head>
		<title>LMS</title>
		<link rel="stylesheet" type="text/css" href="css/index_style.css" />
		<style type="text/css">
			.container{
				background-color: black;
				width: 50%;
				height: 50%;
				margin-left:270px;
				margin-bottom: 5%;
				border-radius: 30px;
				opacity: 0.8;
				

			}
		</style>
	</head>
	<body style="background: #15163d21; background-image: url(./img/lb.jpg);">
		<div class="container">
		<div id="allTheThings">
			<div id="member">
				<a href="member">
					<img src="img/member1.jpg" width="250px" height="200"/><br />
					&nbsp;Member Login
				</a>
			</div>
			<div id="verticalLine">
				<div id="librarian">
					<a id="librarian-link" href="librarian">
						<img src="img/librarian login.png" width="250px" height="220" /><br />
						&nbsp;&nbsp;&nbsp;Librarian Login
					</a>
				</div>
			</div>
		</div>
	</div>
		<?php
			include('footer.php');
		?>
	</body>
</html>
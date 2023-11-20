<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "verify_librarian.php";
	require "header_librarian.php";
?>

<html>
	<head>
		<title>LMS</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css" />
		<link rel="stylesheet" type="text/css" href="../css/form_styles.css" />
		<link rel="stylesheet" href="css/update_copies_style.css">
		<style type="text/css">
			.container{
				background-color:black;
				width: 60%;
				padding-right: 10px;
				padding-left: 10px;
				margin-left: 250px;
				opacity: 1.0;
				margin-top: 20px;
				border-radius: 35px;
				border:4px solid #4cd302;
				margin-bottom:20px;
			}
		</style>
	</head>
	<body style="background-image: linear-gradient(purple,cyan);">
		<div class="container">
		<form class="cd-form" method="POST" action="#">
			<center><legend>Update Book Copies</legend></center>
			
				<div class="error-message" id="error-message">
					<p id="error"></p>
				</div>
				
				<div class="icon">
					<input class="b-isbn" type='text' name='b_isbn' id="b_isbn" placeholder="Book ISBN" required />
				</div>
					
				<div class="icon">
					<input class="b-copies" type="number" name="b_copies" placeholder="Copies to add" required />
				</div>
						
				<input type="submit" name="b_add" value="Update Book Copies" />
		</form>
	</div>
		<?php
			include('../footer.php');
		?>
	</body>
	
	<?php
		if(isset($_POST['b_add']))
		{
			$query = $con->prepare("SELECT isbn FROM book WHERE isbn = ?;");
			$query->bind_param("s", $_POST['b_isbn']);
			$query->execute();
			if(mysqli_num_rows($query->get_result()) != 1)
				echo error_with_field("Invalid ISBN", "b_isbn");
			else
			{
				$query = $con->prepare("UPDATE book SET copies = copies + ? WHERE isbn = ?;");
				$query->bind_param("ds", $_POST['b_copies'], $_POST['b_isbn']);
				if(!$query->execute())
					die(error_without_field("ERROR: Couldn\'t update book copies"));
				echo success("Number of book copies has been updated");
				   header("location:update_copies.php");
			    
			}
		}
	?>
</html>
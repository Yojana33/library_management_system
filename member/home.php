<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "verify_member.php";
	require "header_member.php";
?>

<html>
	<head>
		<title>LMS</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="css/home_style.css">
		<link rel="stylesheet" type="text/css" href="../css/custom_radio_button_style.css">
		<style type="text/css">
			.container{
			
				background-color:lightcyan;
				width: 80%;
				padding-right: 10px;
				padding-left: 10px;
				margin-left: 120px;
				margin-top: 20px;
				opacity: 0.9;
				border-radius: 35px;
				border:4px solid #4cd302;
				margin-bottom:20px;
			}
		</style>
		
	</head>
<body style="background-image: linear-gradient(purple,cyan);">
					<div class="container">
		<div style="float: right;margin:10px 100px;">
				
			<form method="Post" action="search.php">
		      <input type="text" class="form-control-plaintext" name="search-data" id="staticEmail">
		      <input type="submit" name="search" value="Search">			  
			</form>
		</div>
		<?php
			$query ="SELECT * FROM `book` ORDER BY title";
			$result=$con->query($query);

			if(!$result)
				die("ERROR: Couldn't fetch books");
			$rows = mysqli_num_rows($result);
			if($rows == 0)
				echo "<h2 align='center'>No books available</h2>";
			else
			{
				echo "<form class='cd-form' method='POST' action='#'>";
				echo "<center><legend>List of Available Books</legend></center>";
				echo "<div class='error-message' id='error-message'>
						<p id='error'></p>
					</div>";
				echo "<table width='100%' cellpadding=10 cellspacing=10>";
				echo "<tr>
						<th></th>
						<th>ISBN<hr></th>
						<th>Book Title<hr></th>
						<th>Author<hr></th>
						<th>Category<hr></th>
						<th>Copies<hr></th>
					</tr>";
				for($i=0; $i<$rows; $i++)
				{
					$row = mysqli_fetch_array($result);
					echo "<tr>
							<td>
								<label class='control control--radio'>
									<input type='radio' name='rd_book' value=".$row[0]." />
								<div class='control__indicator'></div>
							</td>";
					for($j=0; $j<6; $j++)
						if($j == 4)
							// echo "<td>Rs.".$row[$j]."</td>";
							echo "";
						else
							echo "<td>".$row[$j]."</td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "<br /><br /><input type='submit' name='m_request' value='Request Book' />";
				echo "</form>";
			}

			if(isset($_POST['m_request']))
			{
				if(empty($_POST['rd_book']))
					echo error_without_field("Please select a book to issue");

				else
				{
					$query = $con->prepare("SELECT copies FROM book WHERE isbn = ?;");
					$query->bind_param("s", $_POST['rd_book']);
					$query->execute();
					$copies = mysqli_fetch_array($query->get_result())[0];
					if($copies == 0)
						echo error_without_field("No copies of the selected book are available");
					else
					{
						$query = $con->prepare("SELECT request_id FROM pending_book_requests WHERE member = ?;");
						$query->bind_param("s", $_SESSION['username']);
						$query->execute();
						if(mysqli_num_rows($query->get_result()) == 1)
							echo error_without_field("You can only request one book at a time");
									
						else
						{
							$query = $con->prepare("SELECT book_isbn FROM book_issue_log WHERE member = ?;");
							$query->bind_param("s", $_SESSION['username']);
							$query->execute();
							$result = $query->get_result();
							if(mysqli_num_rows($result) >= 3)
								echo error_without_field("You cannot issue more than 3 books at a time");
							      

							else
							{
								$rows = mysqli_num_rows($result);
								for($i=0; $i<$rows; $i++)
									if(strcmp(mysqli_fetch_array($result)[0], $_POST['rd_book']) == 0)
										break;
								if($i < $rows)
									echo error_without_field("You have already issued a copy of this book");
								    
								else
								{
									$query = $con->prepare("INSERT INTO pending_book_requests(member, book_isbn) VALUES(?, ?);");
										$query->bind_param("ss", $_SESSION['username'], $_POST['rd_book']);
										if(!$query->execute())
											echo error_without_field("ERROR: Couldn\'t request book");
										else
											echo success("Selected book has been requested. Soon you'll' be notified when the book is issued to your account!");
										

								}
							}
						}
					}
				}
			}
         
		?>
	</div>
		<?php
			include('../footer.php');
		?>
	</body>
</html>
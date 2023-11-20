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
	</head>
	<body style="background: #15163d21;">
		<div style="float: right;margin:10px 100px;">
			<?php
				if (!empty($_POST["search"])) {
					// var_dump($_POST['search-data']);
					$search=$_POST['search-data'];
				}
			?>
			<form method="Post" action="search.php">
				<input type="text" class="form-control-plaintext" name="search-data" value="<?php echo $search; ?>">
			    <input type="submit" name="search" value="Search">			  
			</form>
		</div>
		<?php

			function likeCheck($str, $searchTerm) {
			    $searchTerm = strtolower($searchTerm);
			    $str = strtolower($str);
			    $pos = strpos($str, $searchTerm);
			    if ($pos === false)
			        return false;
			    else
			        return true;
			}

			$query ="SELECT * FROM book";
			$result=$con->query($query);

			if(!$result)
				die("ERROR: Couldn't fetch books");
			$rows = mysqli_num_rows($result);
			if($rows == 0)
				echo "<h2 align='center'>No books available</h2>";
			else
			{
				$keyss=array();
				$isbnss=array();
				$counter=0;
				$isbnss1="(";

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
						<th>Price<hr></th>
						<th>Copies<hr></th>
					</tr>";

				
				if ($search) {
					for($i=0; $i<$rows; $i++)
					{
						$row = mysqli_fetch_array($result);
						$title=$row['title'];
						$author=$row['author'];
						$category=$row['category'];
						$isbn=$row['isbn'];

						$foundTitle = likeCheck($title, $search);
						$foundAuthor = likeCheck($author, $search);
						$foundCategory = likeCheck($category, $search);

						if($foundTitle || $foundAuthor  || $foundCategory){
						    $keyss[]=$i;
						    // $isbnss[]=$isbn;
						    $counter+=1;
						    if ($counter==1) {
						    	$isbnss1.="'".$isbn."'";
						    }else{
						    	$isbnss1.=",'".$isbn."'";
						    }
						}
					}
					$isbnss1.=")";
					$query1 ="SELECT * FROM book WHERE isbn IN $isbnss1";
				}else{
					$query1 ="SELECT * FROM book";
				}
				$result1=$con->query($query1);

				if(!$result1){
					// echo "<h2 align='center'>No books available</h2>";
					echo "<tr>
								<td colspan='5' align='center'><h2 align='center'>No books available</h2></td></tr>";
					echo "</table>";

					die();
					// die("ERROR: Couldn't fetch books 1");
				}					
				$rows1 = mysqli_num_rows($result1);
				if($rows1 == 0){
					echo "<h2 align='center'>No books available</h2>";
				}else{
					for($i=0; $i<$rows1; $i++) {
						$row = mysqli_fetch_array($result1);
						echo "<tr>
								<td>
									<label class='control control--radio'>
										<input type='radio' name='rd_book' value=".$row[0]." />
									<div class='control__indicator'></div>
								</td>";
						for($j=0; $j<6; $j++)
							if($j == 4)
								echo "<td>Rs.".$row[$j]."</td>";
							else
								echo "<td>".$row[$j]."</td>";
						echo "</tr>";
					}
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
									$query = $con->prepare("SELECT balance FROM member WHERE username = ?;");
									$query->bind_param("s", $_SESSION['username']);
									$query->execute();
									$memberBalance = mysqli_fetch_array($query->get_result())[0];
									
									$query = $con->prepare("SELECT price FROM book WHERE isbn = ?;");
									$query->bind_param("s", $_POST['rd_book']);
									$query->execute();
									$bookPrice = mysqli_fetch_array($query->get_result())[0];
									if($memberBalance < $bookPrice)
										echo error_without_field("You do not have sufficient balance to issue this book");
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
			}
		?>
		<?php
			include('../footer.php');
		?>
	</body>
</html>
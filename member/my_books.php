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
		<link rel="stylesheet" type="text/css" href="../css/custom_checkbox_style.css">
		<link rel="stylesheet" type="text/css" href="css/my_books_style.css">
	</head>
	<body style="background: #15163d21;">
			<?php
// 			$date = date('y-m-d');
// 			$earlier = new DateTime($date);
// 			$date1=date('y-m-d', strtotime('+7 days'));
// 			$later = new DateTime($date1);
// 			$abs_diff = $later->diff($earlier)->format("%a"); //3
// 			echo $abs_diff;
			
// echo "<br>";
// echo $date;
// echo "<br>";
// echo ($date1);

		?>
		<?php
			// $query = $con->prepare("SELECT book_isbn FROM book_issue_log WHERE member = ?;");
			// $query->bind_param("s", $_SESSION['username']);
			// $query->execute();
			// $result = $query->get_result();
			// $rows = mysqli_num_rows($result);

			$userr=$_SESSION['username'];
			$query ="SELECT book_isbn,issued_date,rdate FROM book_issue_log WHERE member='$userr' and status = '1'";
			$result=$con->query($query);
			$rows = mysqli_num_rows($result);

			// if(!$result){
			if($rows == 0){
				echo "<h2 align='center'>There Are No Issued Books Yet!</h2>";
			}
			else
			{
				echo "<form class='cd-form' method='POST' action='#'>";
				echo "<center><legend>My Books</legend></center>";
				echo "<div class='success-message' id='success-message'>
						<p id='success'></p>
					</div>";
				echo "<div class='error-message' id='error-message'>
						<p id='error'></p>
					</div>";
				echo"<table width='100%' cellpadding='10' cellspacing='10'>
						<tr>
							<th></th>
							<th>ISBN<hr></th>
							<th>Title<hr></th>
							<th>Author<hr></th>
							<th>Category<hr></th>
							<th>Issued Date<hr></th>
							<th>Returning Date<hr></th>
							<th>Returned date<hr></th>
							<th>Fine<hr></th>
						</tr>";
				for($i=0; $i<$rows; $i++)

				{
					$row = mysqli_fetch_array($result);
					if($row)
					{
						echo "<tr>
								<td>
									<label class='control control--checkbox'>
										<input type='checkbox' name='cb_book".$i."' value='".$row[0]."'>
										<div class='control__indicator'></div>
									</label>
								</td>";
						echo "<td>".$row[0]."</td>";
						$query = $con->prepare("SELECT title, author, category FROM book WHERE isbn = ?;");
						$query->bind_param("s", $row[0]);
						$query->execute();
						$innerRow = mysqli_fetch_array($query->get_result());
						for($j=0; $j<3; $j++){
							echo "<td>".$innerRow[$j]."</td>";
						}
						echo "<td>".$row[1]."</td>";
						//print_r($row); //exit;

						$start_date = $row[1];  
						$return_date_fine = $row[1];  
						$return_date = $row[1];  
						$return_date = strtotime($return_date);
					    $return_date = strtotime("+7 day", $return_date);
						$return_date=date('Y-m-d', $return_date);
						echo "<td>".$return_date."</td>";

						$earlier = new DateTime($return_date_fine);
						$date1=date('y-m-d');
						$later = new DateTime($date1);
						$abs_diff = $later->diff($earlier)->format("%a"); //3
						// echo $abs_diff;
						echo "<td>".$row[2]."</td>";
				
						

						if ($abs_diff>7) {
							$fine=($abs_diff-7)*20;
							echo "<td>Rs. ".$fine."</td>";
						} else {
							echo "<td>Rs. 0</td>";
						}
						
						echo "</tr>";
					}
				}
				echo "</table><br />";
				echo "<input type='submit' name='b_return' value='Return Selected Books' />";
				echo "</form>";
			}
			
			if(isset($_POST['b_return']))
			{
				//print_r($_POST); /// exit;
				$books = 0;
				for($i=0; $i<$rows; $i++)
					if(isset($_POST['cb_book'.$i]))
					{
						$user_name=$_SESSION['username']; 
						$rdate = date("Y-m-d");
						//echo $rdate;
						$b_isbn=$_POST['cb_book'.$i];
						$upd="UPDATE book_issue_log SET status=0, rdate = '$rdate' WHERE member='$user_name' and book_isbn='$b_isbn'";

						$update=$con->query($upd);

						if (!$update){
							die(error_without_field("ERROR: Couldn\'t return the books"));
						}
						// else{
						// 	die('book returned');
						// }
						$books++;
					}
				if($books > 0)
				{
					echo '<script>
							document.getElementById("success").innerHTML = "Successfully returned '.$books.' books";
							document.getElementById("success-message").style.display = "block";
                          </script>';
                          header("location:my_books.php");

				}
				else
					echo error_without_field("Please select a book to return");

			}
		?>
		<?php
			include('../footer.php');
		?>
	</body>
</html>
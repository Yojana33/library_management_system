<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "verify_librarian.php";
	require "header_librarian.php";
?>

<html>
	<head>
		<title>LMS</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../css/custom_checkbox_style.css">
		<link rel="stylesheet" type="text/css" href="css/pending_book_requests_style.css">
		<style type="text/css">
			.container{
				background-color:lightcyan;
				width: 80%;
				border-radius: 35px;
				border:4px solid #4cd302;
				margin-top: 50px;
				margin-bottom: 50px;
				margin-left: 107px;
			}
		</style>
		
	</head>
	<body style="background-image: linear-gradient(purple,cyan);">
		<div class="container">

		<?php
			$query = $con->prepare("SELECT * FROM pending_book_requests;");
			$query->execute();
			$result = $query->get_result();;
			$rows = mysqli_num_rows($result);
			if($rows == 0)
				echo "<h2 align='center'>No requests pending</h2>";
			else
			{
				echo "<form class='cd-form' method='POST' action='#'>";
				echo "<center><legend>Pending book requests</legend></center>";
				echo "<div class='error-message' id='error-message'>
						<p id='error'></p>
					</div>";
				echo "<table width='100%' cellpadding=10 cellspacing=10>
						<tr>
							<th></th>
							<th>Username<hr></th>
							<th>ISBN<hr></th>
							<th>Book<hr></th>
							<th>Issuse date & Time<hr></th>
						</tr>";
				for($i=0; $i<$rows; $i++)
				{
					$row = mysqli_fetch_array($result);
					echo "<tr>";
					echo "<td>
							<label class='control control--checkbox'>
								<input type='checkbox' name='cb_".$i."' value='".$row[0]."' />
								<div class='control__indicator'></div>
							</label>
						</td>";
					for($j=1; $j<4; $j++){
						echo "<td>".$row[$j]."</td>";
						if ($j=='2') {
							$isbn=$row[$j];
							$query3 = $con->prepare("SELECT title FROM book WHERE isbn = ?;");
							$query3->bind_param("d", $isbn);
							$query3->execute();
							$resultRow = mysqli_fetch_array($query3->get_result());
							echo "<td>".$resultRow[0]."</td>";
						}
					}						
					echo "</tr>";
				}
				echo "</table>";
				echo "<br /><br /><div style='float: right;'>";
				echo "<input type='submit' value='Reject Request' name='l_reject' />&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<input type='submit' value='Allow' name='l_grant'/>";
				echo "</div>";
				echo "</form>";
			}
			
			$header = 'From: <omkar@gmail.com>' . "\r\n";
			
			if(isset($_POST['l_grant']))
			{
				$requests = 0;
				for($i=0; $i<$rows; $i++)
				{
					if(isset($_POST['cb_'.$i]))
					{
						$request_id =  $_POST['cb_'.$i];
						$query = $con->prepare("SELECT member,book_isbn FROM pending_book_requests WHERE request_id = ?;");
						$query->bind_param("d", $request_id);
						$query->execute();

						$resultRow = mysqli_fetch_array($query->get_result());
						// var_dump($request_id);die();
						$member = $resultRow[0];
						$isbn = $resultRow[1];
						$date = date('y-m-d');

						$query3 = $con->prepare("SELECT copies FROM book WHERE isbn = ?;");
						$query3->bind_param("d", $isbn);
						$query3->execute();

						$resultRow3 = mysqli_fetch_array($query3->get_result());
						$qty = $resultRow3[0];
						$qty-=1;

						$sql = "INSERT INTO book_issue_log (member,book_isbn,issued_date)
								VALUES ('$member','$isbn','$date')";
						if(!$con->query($sql)){
							die(error_without_field("ERROR: Couldn\'t issue book"));
						}

						$query1 = $con->prepare("DELETE FROM pending_book_requests WHERE request_id = ?");
						$query1->bind_param("d", $request_id);
						if(!$query1->execute())
							die(error_without_field("ERROR: Couldn\'t delete values"));

						$upd = "UPDATE book SET copies='$qty' WHERE isbn = '$isbn'";
						$update=$con->query($upd);
						if (!$update){
							die(error_without_field("ERROR: Couldn\'t update values"));
						}

						$requests++;
						
						$query = $con->prepare("SELECT email FROM member WHERE username = ?;");
						$query->bind_param("s", $member);
						$query->execute();
						$to = mysqli_fetch_array($query->get_result())[0];
						$subject = "Book has been issued";
						
						$query = $con->prepare("SELECT title FROM book WHERE isbn = ?;");
						$query->bind_param("s", $isbn);
						$query->execute();
						$title = mysqli_fetch_array($query->get_result())[0];
						
						$query = $con->prepare("SELECT issued_date FROM book_issue_log WHERE member = ? AND book_isbn = ?;");
						$query->bind_param("ss", $member, $isbn);
						$query->execute();
						$issued_date = mysqli_fetch_array($query->get_result())[0];

						
						
					}
				}
				if($requests > 0){
					echo success("Granted Successfully!".$requests." requests");
					header("location:pending_book_requests.php");
				}
				else{
					echo error_without_field("No request selected");
				}
			}
			
			if(isset($_POST['l_reject']))
			{
				$requests = 0;
				for($i=0; $i<$rows; $i++)
				{
					if(isset($_POST['cb_'.$i]))
					{
						$requests++;
						$request_id =  $_POST['cb_'.$i];
						
						$query = $con->prepare("SELECT member, book_isbn FROM pending_book_requests WHERE request_id = ?;");
						$query->bind_param("d", $request_id);
						$query->execute();
						$resultRow = mysqli_fetch_array($query->get_result());
						$member = $resultRow[0];
						$isbn = $resultRow[1];
						
						$query = $con->prepare("SELECT email FROM member WHERE username = ?;");
						$query->bind_param("s", $member);
						$query->execute();
						$to = mysqli_fetch_array($query->get_result())[0];
						$subject = "Book issue rejected";
						
						$query = $con->prepare("SELECT title FROM book WHERE isbn = ?;");
						$query->bind_param("s", $isbn);
						$query->execute();
						$title = mysqli_fetch_array($query->get_result())[0];
						$message = "Your request for issuing the book '".$title."' with ISBN ".$isbn." has been rejected. You can request the book again or visit a librarian for further information.";
						
						$query = $con->prepare("DELETE FROM pending_book_requests WHERE request_id = ?");
						$query->bind_param("d", $request_id);
						if(!$query->execute())
							die(error_without_field("ERROR: Couldn\'t delete values"));
						
					}
				}
				if($requests > 0)
					echo success("Successfully rejected ".$requests." requests");
				else
					echo error_without_field("No request selected");
			}
?>
</div>

<?php
			include('../footer.php');
		?>
</body>
</html>

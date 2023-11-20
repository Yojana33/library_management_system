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
		<link rel="stylesheet" type="text/css" href="css/pending_registrations_style.css">
		<style type="text/css">
			.container{
			background-color:lightcyan;
				width: 75%;
				padding-right: 50%;
				padding-left: 10px;
				margin-left: 150px;
				opacity: 1.0;
				margin-top: 20px;
				border-radius: 35px;
				border:4px solid #4cd302;
				margin-bottom:20px;
		</style>
	</head>
<body style="background-image: linear-gradient(purple,cyan);">
	<div class="container">
		<?php
			
			$query ="SELECT book_isbn,member,issue_id,issued_date, rdate FROM book_issue_log WHERE status = '1'";

			$result=$con->query($query);
			$rows = mysqli_num_rows($result);
			if($rows == 0){
				echo "<h2 align='center'>None at the moment!</h2>";
			}
			else
			{
				echo "<form class='cd-form' method='POST' action='#'>";
				echo "<center><legend><b>Returned Book </b></legend></center>";
				echo "<div class='error-message' id='error-message'>
						<p id='error'></p>
					</div>";
				echo "<table width='100%' cellpadding=12 cellspacing=5>
						<tr> 
							<th>ISBN<hr></th>
							<th>Member<hr></th>
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
					//print_r($row); //exit;
					echo "<tr>"; 
					$j;
					for($j=0; $j<2; $j++){
						echo "<td>".$row[$j]."</td>";
					}
					$isbn1=$row[0];
					$query = $con->prepare("SELECT title, author, category FROM book WHERE isbn = ?;");
					$query->bind_param("s", $isbn1);
					$query->execute();
					$innerRow = mysqli_fetch_array($query->get_result());
					for($k=0; $k<3; $k++){
							echo "<td>".$innerRow[$k]."</td>";
					}

					echo "<td>".$row[3]."</td>";

					$start_date = $row[3];  
					$return_date_fine = $row[3];  
					$return_date = $row[3];  
					$return_date = strtotime($return_date);
					$return_date = strtotime("+7 day", $return_date);
					$return_date=date('Y-m-d', $return_date);
					echo "<td>".$return_date."</td>";

					$earlier = new DateTime($return_date_fine);
					$date1=date('y-m-d');
					$later = new DateTime($date1);
					$abs_diff = $later->diff($earlier)->format("%a"); //3
					// echo $abs_diff;
					echo "<td>".$row[4]." </td>";
					if ($abs_diff>7) {
						$fine=($abs_diff-7)*20;
						echo "<td>Rs. ".$fine."</td>";
					} else {
						echo "<td>Rs. 0</td>";
					}

					echo "</tr>";
				}
				echo "</table><br /><br />";
				echo "<div style='float: right;'>";
				
				
				echo "</div>";
				echo "</form>";
			}
			
			
			
			
		?>
	</div>
		<?php
			include('../footer.php');
		?>
	</body>
</html>
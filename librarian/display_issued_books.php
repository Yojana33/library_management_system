<?php
    require "../db_connect.php";
    require "../message_display.php";
	require "verify_librarian.php";
	require "header_librarian.php";
?>

<html>
	<head>
		<title>LMS</title>
		<link rel="stylesheet" type="text/css" href="../member/css/home_style.css" />
        <link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../css/home_style.css">
		<link rel="stylesheet" type="text/css" href="../member/css/custom_radio_button_style.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"  />
		<style type="text/css">
			.ftco-footer-social li {
			    list-style: none;
			    margin: 0 10px 0 0;
			    display: inline-block;
			}

			.ftco-footer-social li a {
			    background: transparent;
			    border: 1px solid #a3de83;
			}
			.ftco-footer-social li a {
			    height: 40px;
			    width: 40px;
			    display: block;
			    color: white !important;
			    background: rgba(0,0,0,.05);
			    border-radius: 50%;
			    position: relative;
			}
			.ftco-footer-social li a i{
			   position: relative;
				top: 10px;
			}
			.container{
			
				background-color:lightcyan;
				width: 80%;
				padding-right: 10px;
				padding-left: 10px;
				margin-left: 120px;
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

    <?php
			$query = $con->prepare("SELECT book_isbn,member,issue_id,issued_date FROM book_issue_log ORDER BY issued_date ASC");
			$query->execute();
			$result = $query->get_result();
			if(!$result)
				die("ERROR: Couldn't fetch books");
			$rows = mysqli_num_rows($result);
			if($rows == 0)
				echo "<h2 align='center'>No any books have been issued.</h2>";
			else
			{
				echo "<form class='cd-form'>";
				echo "<div class='error-message' id='error-message'>
						<p id='error'></p>
					</div>";
				echo "<table width='100%' cellpadding=10 cellspacing=10>";
				echo "<tr>
							<th>Id<hr></th>
							<th>ISBN<hr></th>
							<th>Username<hr></th>
							<th>Title<hr></th>
							<th>Author<hr></th>
							<th>Category<hr></th>
							<th>Issued Date<hr></th>
							<th>Returning Date<hr></th>
							<th>Fine<hr></th>

					</tr>";
				for($i=0; $i<$rows; $i++)
				{
					$row = mysqli_fetch_array($result);
					echo "<tr>";
					$isbn1=$row[0];
					echo "<td>".$row[2]."</td>";
					echo "<td>".$isbn1."</td>";
					echo "<td>".$row[1]."</td>";
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

					if ($abs_diff>7) {
						$fine=($abs_diff-7)*20;
						echo "<td>Rs. ".$fine."</td>";
					} else {
						echo "<td>Rs. 0</td>";
					}
                            
					echo "</tr>";
				}
				echo "</table>";
				
				echo "</form>";
			}
			
			
		?>
</div>
		<?php
			include('../footer.php');
		?>
    </body>

</html>
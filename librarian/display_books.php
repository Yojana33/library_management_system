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
		<style type="text/css">
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
			$query = $con->prepare("SELECT * FROM book ORDER BY title");
			$query->execute();
			$result = $query->get_result();
			if(!$result)
				die("ERROR: Couldn't fetch books");
			$rows = mysqli_num_rows($result);
			if($rows == 0)
				echo "<h2 align='center'>No books available</h2>";
			else
			{
				echo "<form class='cd-form'>";
				echo "<div class='error-message' id='error-message'>
						<p id='error'></p>
					</div>";
				echo "<table width='100%' cellpadding=10 cellspacing=10>";
				echo "<tr>
				
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
							";
					for($j=0; $j<6; $j++)
						if($j == 4){
							echo "";
						}
						else
                            echo "<td>".$row[$j]."</td>";
                            
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
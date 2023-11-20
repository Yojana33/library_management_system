<?php
	require "../db_connect.php";
	require "verify_librarian.php";
	require "header_librarian.php";
?>

<html>
	<head>
		<title>LMS</title>
		<link rel="stylesheet" type="text/css" href="css/home_style.css" />
		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		
		<style type="text/css">
			.allTheThings{
				width: 80%;
           margin-top: 10%;
				margin-left: 10%;
      }


		</style>
	</head>
	<body style="background-image: linear-gradient(purple,cyan);">
		<div class="allTheThings">
			<div class="inner_container">
			 <div class="content mt-3">
      			<div class="shadow-sm p-1 mb-1 bg-blue rounded" id="card-item">
        	 <div class="row mb-3">
            <div class="shadow-sm p-1 mb-1 bg-white rounded">

               <div class="card-header bg-success text-white">
                  <h3 class="display-4">New Book <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="insert_book.php" class="text-primary">Add Book <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>
            &nbsp &nbsp 

            <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success8 text-white">
                  <h3 class="display-4">Update Copy <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="update_copies.php" class="text-primary">Update Copy <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>
            &nbsp &nbsp 

             <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success7 text-white">
                  <h3 class="display-4">Delete Book <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="delete_book.php" class="text-primary">Delete Book <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>
            &nbsp &nbsp 

             <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success6 text-white">
                  <h3 class="display-4">View Books <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="display_books.php" class="text-primary">Book Details <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>
            &nbsp &nbsp 

             <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success5 text-white">
                  <h3 class="display-4">Pending Book <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="pending_book_requests.php" class="text-primary">Pending Details <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>
            &nbsp &nbsp

             <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success4 text-white">
                  <h3 class="display-4">Returning Book <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="pending_return_book_requests.php" class="text-primary">Returning Details <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>
            &nbsp &nbsp 

             <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success3 text-white">
                  <h3 class="display-4">Issue Book <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="display_issued_books.php" class="text-primary">Issue Details <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>
            &nbsp &nbsp

             <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success2 text-white">
                  <h3 class="display-4">Membership <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="pending_registrations.php" class="text-primary">Registration Details <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>
            &nbsp &nbsp 

         <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success1 text-white">
                  <h3 class="display-4">Returned Book <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="./returned_book.php" class="text-primary"> Books Details <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>





        </div>
         </div>
      </div>
       



			<!-- <a href="insert_book.php">
				<input type="button" value="Insert New Book Record" />
			</a><br />

			<a href="update_copies.php">
				<input type="button" value="Update Copies of a Book" />
			</a><br />

			<a href="delete_book.php">
				<input type="button" value="Delete Book Records" />
			</a><br />

			<a href="display_books.php">
				<input type="button" value="Display Available Books" />
			</a><br />

			<a href="display_issued_books.php">
				<input type="button" value="Display Issued Books" />
			</a><br />

			<a href="pending_book_requests.php">
				<input type="button" value="Manage Pending Book Requests" />
			</a><br />

			<a href="pending_return_book_requests.php">
				<input type="button" value="Manage Returned Book Requests" />
			</a><br />

			<a href="pending_registrations.php">
				<input type="button" value="Manage Pending Membership Registrations" />
			</a><br /> -->

		</div>

      <style type="text/css">
         .bg-success1 {
                background: #cb0e1fdd;
            }
              .bg-success2 {
                background: purple;
            }
              .bg-success3 {
                background: orange;
            }
              .bg-success4 {
                background: blue;
            }
              .bg-success5 {
                background: aqua;
            }
              .bg-success6 {
                background: brown;
            }
              .bg-success7{
                background: magenta;
            }
              .bg-success8 {
                background: olive;
            }

            
      </style>

	</body>
	
</html>


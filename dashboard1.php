<?php

	require "db_connect.php";
	require "./librarian/verify_librarian.php";
	require "./librarian/header_librarian.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
   <meta charset="utf-8">
   <title>Dashboard</title>
   <link rel="stylesheet" href="./CSS/header_style.css">
   <link rel="stylesheet" href="./CSS/header_librarian_style.css">
   <!-- <link rel="stylesheet" href="./CSS/global_styles.css"> -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   <style type="text/css">
			#allTheThings input[type="button"] {
    			background: #1b235c !important;
    		}
		</style>

</head>

<body>

   <div class="content mt-3">
      <div class="shadow-sm p-1 mb-1 bg-white rounded" id="card-item">
         <div class="row mb-3">

            <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success text-white">
                  <h3 class="display-4">New Book <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="./librarian/insert_book.php" class="text-primary">Add Book <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>

            <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success text-white">
                  <h3 class="display-4">Update Copy <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="./librarian/update_copies.php" class="text-primary">Update Copy <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>

             <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success text-white">
                  <h3 class="display-4">Delete Book <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="./librarian/delete_book.php" class="text-primary">Delete Book <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>

             <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success text-white">
                  <h3 class="display-4">View Books <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="./librarian/display_books.php" class="text-primary">Book Details <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>

             <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success text-white">
                  <h3 class="display-4">Pending Book <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="./librarian/pending_book_requests.php" class="text-primary">Pending Details <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>

             <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success text-white">
                  <h3 class="display-4">Returning Book <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="./librarian/pending_return_book_requests.php" class="text-primary">Returning Details <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>

             <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success text-white">
                  <h3 class="display-4">Issue Book <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="./librarian/display_issued_books.php" class="text-primary">Issue Details <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>

             <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success text-white">
                  <h3 class="display-4">Membership <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="./librarian/pending_registrations.php" class="text-primary">Registration Details <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>
             <div class="shadow-sm p-1 mb-1 bg-white rounded">
               <div class="card-header bg-success text-white">
                  <h3 class="display-4">Returned Book <small class="text-warning"></small></h3>
               </div>
               <div class="card-footer">
                  <h6>
                     <a href="./librarian/returned_book.php" class="text-primary"> Books Details <i class="fas fa-arrow-alt-circle-right"></i></a>
                  </h6>
               </div>
            </div>


         </div>
      </div>
   </div>
</body>

</html>
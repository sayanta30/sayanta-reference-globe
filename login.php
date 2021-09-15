<?php

if(!isset($_SESSION)){
   session_start();
}

include './api/checkLoggedStatusFunction.php';

if(checkLoggedStatus()){
   header('Location: ./');
}

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Home Page</title>

      <!-- External datatables bootstrap css cdn -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"/>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css"/>
      
      <!-- External datatables bootstrap js cdn -->
      <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
      <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
      

      <style>
         body{
            background-color: #f8f8f8;
         }
         table{
            background-color: #fff;
         }
      </style>
   </head>
   <body class="bg-light">
      <nav class="navbar navbar-light bg-dark">
         <span class="navbar mb-0 h3 text-light">Welcome User!!</span>
      </nav>
      <div class="container-fluid mt-2">
         <div class="row justify-content-md-center align-items-center">
            <div class="col-sm-6">
               <div class="card">
                  <div class="card-header">
                     Login
                  </div>
                  <div class="card-body">
                     <form id="newEventForm">
                        <div class="form-group">
                           <input id="userName" type="text" class="form-control" placeholder="Enter the Username here....">
                        </div>
                        <div class="form-group">
                           <input id="userPassword" type="password" class="form-control">
                        </div>
                        <input id="loginSubmit" type="submit" class="btn btn-secondary" value="Done">
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- Sripts starts here -->
      <script>
         $('#loginSubmit').click(function(e){
            e.preventDefault();
            if($('#userName').val().trim().length > 0 && $('#userPassword').val().trim().length > 0){
               $.ajax({
                  url: './api/validate.php',
                  type: 'POST',
                  data: {
                     username: $('#userName').val().trim(),
                     pass: $('#userPassword').val().trim()
                  },
                  success: function(res){
                     res = JSON.parse(res);
                     if(res['status'] == true){
                        location.href = './'
                     }
                     else{
                        Swal.fire({
                           title: 'Wrong Username or Password.',
                           confirmButtonText: 'Try Again',
                           allowOutsideClick: false
                        });
                     }
                  }
               });
            }
         });
      </script>
   </body>
</html>
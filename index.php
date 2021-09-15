<?php

if(!isset($_SESSION)){
   session_start();
}

// var_dump($_SESSION);

include './api/checkLoggedStatusFunction.php';
include './api/checkAdminAcessFunction.php';

if(!checkLoggedStatus()){
   header('Location: login');
}

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Dashboard</title>

      <!-- External datatables bootstrap css cdn -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"/>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css"/>
      <link rel="stylesheet" href="./css/customCSS.css">
      
      <!-- External datatables bootstrap js cdn -->
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
      <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

   </head>
   <body class="bg-light">
      <?php
         include './api/loggedUserDetailsFunction.php';
         $result = loggedUserDetails();
      ?>
      <nav class="navbar navbar-light bg-dark">
         <span class="navbar-brand mb-0 h1 text-light">Dashboard</span>
         <h3 class="text-center text-white">Welcome <?php echo $result['user_name']; ?></h2>
         <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

               <span class="rounded-circle"><img class="imagePreviewNavbar" src="<?php echo 'uploaded_files/profilePhoto/'.$result['user_profile_photo']; ?>" alt="Profile Photo of <?php echo $result['user_name']; ?>" ></span>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">                        
               <?php
                  if(checkAdminAccess()){
                     ?>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#updateSelfModal">
                           <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                           Update Bio
                        </a>
                     <?php
                  }
               ?>
               <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changePasswordModal">
                  <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                  Change Password
               </a>
               <div class="dropdown-divider"></div>
               <a class="dropdown-item" href="./api/logout" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
               </a>
            </div>
         </li>
      </nav>
      <div class="container-fluid mt-2">
         <div class="row mt-3">
            <?php
               if(checkAdminAccess()){
                  ?>
                     <div class="col-sm-12">
                        <br><h3 class="text-center">User Table</h3><br>
                        <button id="newUserModalButton" type="button" class="btn btn-outline-primary">Add New User</button>
                        <hr>
                        <table id="userTable" class="table table-striped table-bordered table-hover" style="width: 100%;">
                           <caption>List of all users with details.</caption>
                           <thead class="thead-dark">
                              <tr>
                                 <th>#</th>
                                 <th>Name</th>
                                 <th>Profile Photo</th>
                                 <th>Email</th>
                                 <th>Mobile</th>
                                 <th>Dob</th>
                                 <th>Aadhar Card</th>
                                 <th>PAN Card</th>
                                 <th>Signature</th>
                                 <th>Actions</th>
                              </tr>
                           </thead>
                        </table>
                     </div>
                  <?php
               }
               else{
                  ?>
                     <div class="col-sm-2"></div>
                     <div class="col-sm-8">
                        <table class="table table-striped table-bordered table-hover text-center">
                           <thead>
                              <tr>
                                 <td rowspan="2" colspan="2"><h3><center>Welcome <?php echo $result['user_name']; ?>, below table contains your details</center></h3></td>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td>Name</td>
                                 <td><span id="userName"></span></td>
                              </tr>
                              <tr>
                                 <td>Profile Photo</td>
                                 <td><img id = "userProfilePhoto" class="imagePreview"></td>
                              </tr>
                              <tr>
                                 <td>Email</td>
                                 <td><span id="userEmail"></span></td>
                              </tr>
                              <tr>
                                 <td>Mobile</td>
                                 <td><span id="userMob"></span></td>
                              </tr>
                              <tr>
                                 <td>Date Of Birth</td>
                                 <td><span id="userDob"></span></td>
                              </tr>
                              <tr>
                                 <td>Signature</td>
                                 <td><span id="userSign"></span></td>
                              </tr>
                              <tr>
                                 <td>Aadhar Card Photo</td>
                                 <td><span id="userAadharCard"></span></td>
                              </tr>
                              <tr>
                                 <td>PAN Card Photo</td>
                                 <td><span id="userPanCard"></span></td>
                              </tr>
                              <tr>
                                 <td colspan="2"><center><button id="updateSelf" class="btn btn-primary">Update Details</button></center></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  <?php
               }
            ?>
         </div>
      </div>
      <footer>
         <div class="text-center p-4">
            ©<?php echo date('Y'); ?> Copyright
         </div>
      </footer>

      <?php
         if(checkAdminAccess()){
            ?>
               <div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title">New User Information</h5>
                           <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <form id="newUserForm">
                           <div class="modal-body">
                              <div class="form-group">
                                 <label for="newUserRole">Role of User</label>
                                 <select name="newUserRole" id="newUserRole" class="form-control" required>
                                    <option>Choose any one</option>
                                    <?php
                                       if($result['user_role'] == 'Super Admin'){
                                          ?>
                                             <option value="Super Admin">Super Admin</option>
                                          <?php
                                       }
                                    ?>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                 </select>
                              </div>
                              <div class="form-group ">
                                 <label for="newUserName">Name</label>
                                 <input id="newUserName" type="text" class="form-control" name="newUserName" required>
                              </div>
                              <div class="form-group ">
                                 <label for="newUserPassword">Password</label>
                                 <input id="newUserPassword" type="password" class="form-control" name="newUserPassword" required>
                              </div>
                              <div class="form-group">
                                 <label for="newUserProfilePhoto" class="btn btn-primary mb-0">Choose Profile Picture</label>
                                 <input id="newUserProfilePhoto" type="file" class="form-control-file" name="newUserProfilePhoto" accept="image/png, image/jpg" style="display:none;">
                                 <small class="badge badge-warning">Only JPG and PNG files allowed.</small>
                              </div>
                              <div class="form-group">
                                 <label for="newUserEmail">Email</label>
                                 <input id="newUserEmail" type="email" class="form-control" name="newUserEmail" required>
                              </div>
                              <div class="form-group">
                                 <label for="newUserMob">Mobile</label>
                                 <input id="newUserMob" type="number" class="form-control" name="newUserMob" required>
                              </div>
                              <div class="form-group">
                                 <label for="newUserDOB">Date of birth</label>
                                 <input id="newUserDOB" type="date" class="form-control" name="newUserDOB" min="<?php echo date('Y-m-d',strtotime('-100 years')); ?>" max="<?php echo date('Y-m-d'); ?>" required>
                              </div>
                              <div class="form-group">
                                 <label for="newUserSign">Signature</label>
                                 <input id="newUserSign" type="text" class="form-control" name="newUserSign" required>
                              </div>
                              <div class="form-group">
                                 <label for="newUserAadhar" class="btn btn-primary mb-0">Choose Aadhar Card</label>
                                 <input id="newUserAadhar" type="file" class="form-control-file" name="newUserAadhar" accept="image/png, image/jpg, application/pdf" style="display:none;">
                                 <small class="badge badge-warning">Only JPG/PNG/PDF files allowed.</small>
                              </div>
                              <div class="form-group">
                                 <label for="newUserPan" class="btn btn-primary mb-0">Choose Pan Card</label>
                                 <input id="newUserPan" type="file" class="form-control-file" name="newUserPan" accept="image/png, image/jpg, application/pdf" style="display:none;">
                                 <small class="badge badge-warning">Only JPG/PNG/PDF files allowed.</small>
                              </div>
                           </div>
                           <div class="modal-footer">
                              <input id="newUserFormSubmit" class="btn btn-success" type="submit" value="Submit">
                           </div>
                        </form>
                     </div>
                  </div>
               </div>

               <div class="modal fade" id="updateUserModal" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title">Update User Information</h5>
                           <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <form id="updateUserForm">
                           <div class="modal-body">
                              <div class="form-group">
                                 <label for="updateUserRole">Role of User</label>
                                 <select name="updateUserRole" id="updateUserRole" class="form-control" required>
                                    <option>Choose any one</option>
                                    <?php
                                       if($result['user_role'] == 'Super Admin'){
                                          ?>
                                             <option value="Super Admin">Super Admin</option>
                                          <?php
                                       }
                                    ?>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                 </select>
                              </div>
                              <div class="form-group ">
                                 <label for="name">Name</label>
                                 <input id="updateUserName" type="text" class="form-control" name="updateUserName" required>
                              </div>
                              <div class="form-group">
                                 <label for="name">Profile Photo</label>
                                 <div id="hasProfilePhoto"></div>
                                 <label for="updateUserProfilePhoto" class="btn btn-primary mb-0">Choose Profile Picture</label>
                                 <input id="updateUserProfilePhoto" type="file" class="form-control-file" name="updateUserProfilePhoto" accept="image/png, image/jpg" style="display:none;">
                                 <small class="badge badge-warning">Only JPG and PNG files allowed.</small>
                              </div>
                              <div class="form-group">
                                 <label for="name">Email</label>
                                 <input id="updateUserEmail" type="email" class="form-control" name="updateUserEmail" required>
                              </div>
                              <div class="form-group">
                                 <label for="name">Mobile</label>
                                 <input id="updateUserMob" type="number" class="form-control" name="updateUserMob" required>
                              </div>
                              <div class="form-group">
                                 <label for="name">Date of birth</label>
                                 <input id="updateUserDOB" type="date" class="form-control" name="updateUserDOB" min="<?php echo date('Y-m-d',strtotime('-100 years')); ?>" max="<?php echo date('Y-m-d'); ?>" required>
                              </div>
                              <div class="form-group">
                                 <label for="name">Signature</label>
                                 <input id="updateUserSign" type="text" class="form-control" name="updateUserSign" required>
                              </div>
                              <div id="hasAadharCard" class="form-group"></div>
                              <div id="hasPanCard" class="form-group"></div>
                              <input id="updateUserID" type="hidden" name="updateUserID">
                           </div>
                           <div class="modal-footer">
                              <input id="updateUserFormSubmit" class="btn btn-success" type="submit" value="Submit">
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            <?php
         }
      ?>

      <div class="modal fade" id="updateSelfModal" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title">Update Information</h5>
                     <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <form id="updateSelfForm">
                     <div class="modal-body">
                        <?php
                           $result = loggedUserDetails();
                        ?>
                        <div class="form-group ">
                           <label for="name">Name</label>
                           <input id="updateSelfName" type="name" class="form-control" name="updateSelfName" value="<?php echo $result['user_name']; ?>" required>
                        </div>
                        <div class="form-group">
                           <label for="name">Profile Photo</label>
                           <?php
                              echo !empty($result['user_profile_photo']) ? '<img class="w-100" src="uploaded_files/profilePhoto/'.$result['user_profile_photo'].'" alt="Profile Photo of '.$result['user_name'].'">' : '<img src="uploaded_files/profilePhoto/default.png" alt="Nothing to preview">';
                           ?>
                           <label for="updateSelfProfilePhoto" class="btn btn-primary mb-0">Choose Profile Picture</label>
                           <input id="updateSelfProfilePhoto" type="file" class="form-control-file" name="updateSelfProfilePhoto" accept="image/png, image/jpg" style="display:none;">
                           <small class="badge badge-warning">Only JPG and PNG files allowed.</small>
                           
                        </div>
                        <div class="form-group">
                           <label for="name">Email</label>
                           <input id="updateSelfEmail" type="email" class="form-control" name="updateSelfEmail" value="<?php echo $result['user_email']; ?>" accept="jpg/png" required>
                        </div>
                        <div class="form-group">
                           <label for="name">Mobile</label>
                           <input id="updateSelfMob" type="number" class="form-control" name="updateSelfMob" value="<?php echo $result['user_mobile']; ?>" required>
                        </div>
                        <div class="form-group">
                           <label for="name">Date of birth</label>
                           <input id="updateSelfDOB" type="date" class="form-control" name="updateSelfDOB" value="<?php echo $result['user_dob']; ?>" min="<?php echo date('Y-m-d',strtotime('-100 years')); ?>" max="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="form-group">
                           <label for="name">Signature</label>
                           <input id="updateSelfSign" type="text" class="form-control" name="updateSelfSign" value="<?php echo $result['user_signature']; ?>" required>
                        </div>
                        <div class="form-group">
                           <?php 
                              echo $result['user_aadhar_card'] != '' ? '<a target="_blanc" href="uploaded_files/aadharCard/'.$result['user_aadhar_card'].'"><div class="btn btn-outline-primary">View Aadhar Card</div></a>' : 'Nothing to preview';
                           ?>
                           <label for="updateSelfAadhar" class="btn btn-primary mb-0">Choose Aadhar Card</label>
                           <input id="updateSelfAadhar" type="file" class="form-control-file" name="updateSelfAadhar" accept="image/png, image/jpg, application/pdf" style="display:none;">
                           <small class="badge badge-warning">Only JPG/PNG/PDF files allowed.</small>
                        </div>
                        <div class="form-group">
                           <?php 
                              echo $result['user_pan_card'] != '' ? '<a target="parent" href="uploaded_files/panCard/'.$result['user_pan_card'].'"><div class="btn btn-outline-primary">View Pan Card</div></a>' : 'Nothing to preview';
                           ?>
                           <label for="updateSelfPan" class="btn btn-primary mb-0">Choose Pan Card</label>
                           <input id="updateSelfPan" type="file" class="form-control-file" name="updateSelfPan" accept="image/png, image/jpg, application/pdf" style="display:none;">
                           <small class="badge badge-warning">Only JPG/PNG/PDF files allowed.</small>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <input id="updateSelfFormSubmit" class="btn btn-success" type="submit" value="Submit">
                     </div>
                  </form>
               </div>
         </div>
      </div>

      <!--Change Password Modal-->
      <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                  </button>
               </div>
               <form id="passwordChangeForm">
                  <div class="modal-body">
                     <div class="form-group ">
                        <label for="name">New Password</label>
                        <input id="newPassword" type="password" class="form-control" name="newPassword" required>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
                     <input class="btn btn-primary" type="submit" value="Submit">
                  </div>
               </form>
            </div>
         </div>
      </div>


      <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                     <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body">Double check before leaving!!</div>
                  <div class="modal-footer">
                     <button class="btn btn-warning" type="button" data-dismiss="modal">Let me Check!</button>
                     <a class="btn btn-primary" href="logout">All Good</a>
                  </div>
               </div>
         </div>
      </div>

      <!-- Sripts starts here -->
      <script>
         <?php
            if(checkAdminAccess()){
               ?>
                  function populateUserTable(){
                     $('#userTable').DataTable({
                        "destroy": true,
                        "pageLength": 10,
                        "lengthMenu": [5,10,15,20],
                        "responsive": true,
                        "ajax": {
                           "url": './data/data.json'
                        },
                        "columns": [
                           { "data": "sl" },
                           { "data": "name" },
                           { "data": "profile" },
                           { "data": "email" },
                           { "data": "mobile" },
                           { "data": "dob" },
                           { "data": "aadhar" },
                           { "data": "pan" },
                           { "data": "signature" },
                           { "data": "actions" },
                        ]
                     });
                  }
                  function fetchUser(){
                     $.ajax({
                        url: './api/getAllUser.php',
                        type: 'POST',
                        success: function(){
                           populateUserTable();
                        }                  
                     });
                  }
               <?php
            }
            else{
               ?>
                  function fetchAndPopulateSingleUser(){
                     $.ajax({
                        url: './api/getSingleUser.php',
                        type: 'POST',
                        success: function(data){
                           data = JSON.parse(data);
                           if(data['status'] == true){
                              if(data['text'] === undefined){
                                 $('#userName').text(data['name']);
                                 $('#userProfilePhoto').attr('src',data['profile']).attr('alt', 'Profile photo of '+data['name']);
                                 $('#userEmail').text(data['email']);
                                 $('#userMob').text(data['mobile']);
                                 $('#userDob').text(data['dob']);
                                 $('#userSign').text(data['sign']);
                                 $('#userAadharCard').html(data['aadhar']);
                                 $('#userPanCard').html(data['pan']);
                                 <?php
                                    if(checkAdminAccess()){
                                       ?>
                                          $('#userID').val(data['id']);
                                       <?php
                                    }
                                 ?>
                              }
                              else{
                                 Swal.fire({
                                    title: data['text'],
                                    confirmButtonText: 'Try Again',
                                 });
                              }
                           }
                           else{
                              location.href = 'login';
                           }
                           
                        }                  
                     });
                  }
               <?php
            }
         ?>


      </script>

      <script>
         $(document).ready(function(){
            <?php
               if(checkAdminAccess()){
                  ?>
                     fetchUser();
                     $('#newUserModalButton').click(function(e){
                        $('#newUserModal').modal({backdrop: 'static', keyboard: false})
                     });
                     
                     $('#newUserForm').submit(function(e){
                        e.preventDefault();
                        $.ajax({
                           url: './api/addUser.php',
                           type: 'POST',
                           enctype: 'multipart/form-data',
                           processData: false,
                           contentType: false,
                           data: new FormData($('#newUserForm')[0]),
                           success: function(newUserResponse){
                              newUserResponse = JSON.parse(newUserResponse);
                              if(newUserResponse['status'] == true){
                                 $("#newUserModal").modal('hide');
                                 Swal.fire({
                                    html: newUserResponse['status'] == true ? newUserResponse['text'] : 'Something went wrong',
                                    confirmButtonText: newUserResponse['status'] == true ? 'Got it' : 'Try again.',
                                 }).then(function(isCnfirm){
                                    fetchUser();
                                 });
                              }
                              else{
                                 location.href = './';
                              }
                           }
                        });
                     });
                     
                     $(document).on('click', '.editUser', function(e){
                        $.ajax({
                           url: './api/getSingleUser.php',
                           type: 'POST',
                           data: {
                              user_id: $(this).attr('id')
                           },
                           success: function(getSingleUserResponse){
                              getSingleUserResponse = JSON.parse(getSingleUserResponse);
                              $('#updateUserID').val(getSingleUserResponse['id']);
                              $('#updateUserRole').val(getSingleUserResponse['role'])
                              $('#updateUserName').val(getSingleUserResponse['name']);
                              $('#updateUserEmail').val(getSingleUserResponse['email']);
                              $('#hasProfilePhoto').empty().append('<img class="w-100 border" src="'+getSingleUserResponse['profile']+'" alt="Profile Photo of '+getSingleUserResponse['name']+'">');
                              $('#updateUserMob').val(getSingleUserResponse['mobile']);
                              $('#updateUserDOB').val(getSingleUserResponse['dob']);
                              $('#updateUserSign').val(getSingleUserResponse['sign']);
                              $('#hasAadharCard').empty().prepend(getSingleUserResponse['aadhar']+'&nbsp;<label for="updateUserAadhar" class="btn btn-primary mb-0">Choose Aadhar Card</label><input id="updateUserAadhar" type="file" class="form-control-file" name="updateUserAadhar" accept="image/png, image/jpg, application/pdf" style="display:none;"><small class="badge badge-warning">Only JPG/PNG/PDF files allowed.</small>');
                              $('#hasPanCard').empty().prepend(getSingleUserResponse['pan']+'&nbsp;<label for="updateUserPan" class="btn btn-primary mb-0">Choose Pan Card</label><input id="updateUserPan" type="file" class="form-control-file" name="updateUserPan" accept="image/png, image/jpg, application/pdf" style="display:none;"><small class="badge badge-warning">Only JPG/PNG/PDF files allowed.</small>');
                              $('#updateUserModal').modal({backdrop: 'static', keyboard: false});
                           }
                        });
                     });
                     
                     $(document).on('click', '.deleteUser', function(e){
                        Swal.fire({
                           title: 'Do you want to delete this user?',
                           showCancelButton: true,
                           confirmButtonText: `Delete`,
                           denyButtonText: `Cancel`,
                        }).then((result) => {
                              if (result.isConfirmed) {
                                 let id = $(this).attr('id');
                                 $.ajax({
                                    url: './api/deleteUser.php',
                                    type: 'POST',
                                    data: {
                                       id: id
                                    },
                                    success: function(data){
                                       data = JSON.parse(data)
                                       if(data['status'] == true){
                                          Swal.fire({
                                             html: data['text'],
                                             showCancelButton: true,
                                          }).then(() => {
                                             fetchUser();
                                          });
                                       }
                                    }
                                 })
                              }
                           })
                     });

                     $(document).on('click','#updateUserFormSubmit', function(e){
                        e.preventDefault();
                        allowUpdateUser = 1;
                        name = $('#updateUserName').val().trim()
                        email = $('#updateUserEmail').val().trim()
                        mobile = $('#updateUserMob').val().trim()
                        dob = $('#updateUserDOB').val().trim()
                        sign = $('#updateUserSign').val().trim()
                        
                        if(name == '' || name.length == 0){
                           allowUpdateUser = 0;
                           $('#updateUserName').focus()
                        }
                        if(email == '' || email.length == 0){
                           allowUpdateUser = 0;
                           $('#updateUserEmail').focus()
                        }
                        if(mobile == '' || mobile.length == 0){
                           allowUpdateUser = 0;
                           $('#updateUserMob').focus()
                        }
                        if(dob == '' || dob.length == 0){
                           allowUpdateUser = 0;
                           $('#updateUserDOB').focus()
                        }
                        if(sign == '' || sign.length == 0){
                           allowUpdateUser = 0;
                           $('#updateUserSign').focus()
                        }
                        if(allowUpdateUser){
                           $.ajax({
                              url: './api/updateSingleUser.php',
                              type: 'POST',
                              enctype: 'multipart/form-data',
                              processData: false,
                              contentType: false,
                              data: new FormData($('#updateUserForm')[0]),
                              success: function(updateUserResponse){
                                 updateUserResponse = JSON.parse(updateUserResponse);
                                 if(updateUserResponse['status'] == true){
                                    $("#updateUserModal").modal('hide');
                                    Swal.fire({
                                       html: updateUserResponse['status'] == true ? updateUserResponse['text'] : 'Something went wrong',
                                       confirmButtonText: updateUserResponse['status'] == true ? 'Got it' : 'Try again.',
                                    }).then(function(isCnfirm){
                                       fetchUser();
                                    });
                                 }
                                 else{
                                    location.href = './';
                                 }
                              }
                           });
                        }
                     });

                  <?php
               }
               else{
                  ?>
                  fetchAndPopulateSingleUser();
                  <?php
               }               
            ?>
            $(document).on('click', '#updateSelf', function(e){
               $('#updateSelfModal').modal({backdrop: 'static', keyboard: false})
            });

            $('#updateSelfForm').submit(function(e){
               e.preventDefault();
               allowUpdateSelf = 1;
               name = $('#updateSelfName').val().trim()
               email = $('#updateSelfEmail').val().trim()
               mobile = $('#updateSelfMob').val().trim()
               dob = $('#updateSelfDOB').val().trim()
               sign = $('#updateSelfSign').val().trim()
               
               if(name == '' || name.length == 0){
                  allowUpdateSelf = 0;
                  $('#updateSelfName').focus()
               }
               if(email == '' || email.length == 0){
                  allowUpdateSelf = 0;
                  $('#updateSelfEmail').focus()
               }
               if(mobile == '' || mobile.length == 0){
                  allowUpdateSelf = 0;
                  $('#updateSelfMob').focus()
               }
               if(dob == '' || dob.length == 0){
                  allowUpdateSelf = 0;
                  $('#updateSelfDOB').focus()
               }
               if(sign == '' || sign.length == 0){
                  allowUpdateSelf = 0;
                  $('#updateSelfSign').focus()
               }
               if(allowUpdateSelf){
                  $.ajax({
                     url: './api/updateSelfUser.php',
                     type: 'POST',
                     enctype: 'multipart/form-data',
                     processData: false,
                     contentType: false,
                     data: new FormData($('#updateSelfForm')[0]),
                     success: function(response){
                        response = JSON.parse(response);
                        if(response['status'] == true){
                           $("#updateSelfModal").modal('hide');
                           Swal.fire({
                              html: response['status'] == true ? response['text'] : 'Something went wrong',
                              confirmButtonText: response['status'] == true ? 'Got it' : 'Try again.',
                           }).then(function(isCnfirm){
                              location.href = './';
                           });
                        }
                     }
                  })
               }
            });

            $("#passwordChangeForm").submit(function(e){
               e.preventDefault();
               $.ajax({
                  url: "./api/passwordChange.php",
                  type: "POST",
                  data: {
                     pass: $('#newPassword').val()
                  },
                  success: function(passwordChangeResponse){
                     passwordChangeResponse = JSON.parse(passwordChangeResponse)
                     if(passwordChangeResponse['status'] == true){
                        $('#passwordChangeModal').modal('hide');
                        Swal.fire({
                           html: passwordChangeResponse['status'] == true ? passwordChangeResponse['text'] : 'Something went wrong',
                           confirmButtonText: passwordChangeResponse['status'] == true ? 'Got it' : 'Try again.',
                        }).then(function(isCnfirm){
                           location.href = 'logout';
                        });
                     }
                     else{
                        location.href = './';
                     }
                  }
               });
            });
         });
      </script>
   </body>
</html>
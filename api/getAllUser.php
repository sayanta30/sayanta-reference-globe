<?php

include 'checkLoggedStatusFunction.php';

if(!isset($_SESSION))
   session_start();

$data = $userData = array();
$data['status'] = true;

if(!checkLoggedStatus())
   $data['status'] = false;

else{
   include 'db.php';
   include 'writeData.php';

   $query = "SELECT * FROM user";

   if($_SESSION['user_details']['user_role'] == 'Admin'){
      $query .= " where user_role != 'Super Admin'";
   }
   elseif($_SESSION['user_details']['user_role'] == 'User'){
      $query .= " where _id = ".$_SESSION['user_details']['_id'];   
   }
   else{
      $query .= " where _id != ".$_SESSION['user_details']['_id'];
   }

   $query = $con->prepare($query);
   $query->execute();

   $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
   
   $counter = 0;

   $superAdminFlag = $_SESSION['user_details']['user_role'] == 'Super Admin' ? true : false;
   foreach($result as $row)
   {
      $subArray = array();
      $subArray["sl"] = ++$counter;
      $subArray["name"] = $row['user_name'];
      $subArray["email"] = $row['user_email'];
      $subArray["mobile"] = $row['user_mobile'];
      $subArray["profile"] = $row['user_profile_photo'] ? '<img src="uploaded_files/profilePhoto/'.$row['user_profile_photo'].'" class="imagePreview">' : '<img src="uploaded_files/profilePhoto/default.png" class="imagePreview">';
      $subArray["dob"] = $row['user_dob'];
      $subArray["signature"] = $row['user_signature'];
      $subArray["aadhar"] = $row['user_aadhar_card'] ? '<a target="_blanc" href="uploaded_files/aadharCard/'.$row['user_aadhar_card'].'"><button class="btn btn-outline-primary">View Aadhar Card</button></a>' : '<span class="badge badge-warning">No Aadhar Card</span>';
      $subArray["pan"] = $row['user_pan_card'] ? '<a target="_blanc" href="uploaded_files/panCard/'.$row['user_pan_card'].'"><button class="btn btn-outline-primary">View PAN Card</button></a>' : '<span class="badge badge-warning">No Pan Card</span>';

      $actions = '<button id="'.$row['_id'].'" class="btn btn-outline-danger deleteUser"><i class="fas fa-trash"></i></button>';

      if($superAdminFlag){
         $actions = '<button id="'.$row['_id'].'" class="btn btn-outline-warning editUser"><i class="fas fa-edit"></i></button>&nbsp;'.$actions;
      }

      $subArray['actions'] = $actions;

      $userData[] = $subArray;
   }
}
   echo $data['status'] == true ? ( writeData($userData) == true ? 'Data loaded' : 'Something went wrong' ) : 'Kindly login please.';
?>
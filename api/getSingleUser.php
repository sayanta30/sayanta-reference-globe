<?php

include './checkLoggedStatusFunction.php';
$data = array();

if(!isset($_SESSION)){
   session_start();
}

if(!checkLoggedStatus()){
   $data['status'] = false;
}
else{
   include 'db.php';
   $data['status'] = true;
   $query = $con->prepare("SELECT * from user where _id = ?");
   if(isset($_POST['user_id']) && !empty($_POST['user_id'])){
      $query->bind_param('i',$_POST['user_id']);
   }
   else{
      $query->bind_param('i',$_SESSION['user_details']['_id']);
   }
   $query->execute();
   $result = $query->get_result();
   if($result->num_rows){
      $result = $result->fetch_assoc();
      $data['id'] = $result['_id'];
      $data['name'] = $result['user_name'];
      $data['role'] = $result['user_role'];
      $data['profile'] = $result['user_profile_photo'] != '' ? 'uploaded_files/profilePhoto/'.$result['user_profile_photo'] : 'uploaded_files/profilePhoto/default.png';
      $data['email'] = $result['user_email'];
      $data['mobile'] = $result['user_mobile'];
      $data['dob'] = $result['user_dob'];
      $data['sign'] = $result['user_signature'];
      $data['aadhar'] = $result['user_aadhar_card'] != '' ? '<a target="_blanc" href="uploaded_files/aadharCard/'.$result['user_aadhar_card'].'"><div class="btn btn-outline-primary">View Aadhar Card</div></a>' : 'Nothing to preview';
      $data['pan'] = $result['user_pan_card'] != '' ? '<a target="_blanc" href="uploaded_files/panCard/'.$result['user_pan_card'].'"><div class="btn btn-outline-primary">View PAN Card</div></a>' : 'Nothing to preview';
   }
   else{
      $data['text'] = 'Invalid user.';
   }
}

echo json_encode($data);






?>
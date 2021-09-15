<?php
include 'checkLoggedStatusFunction.php';

if(!isset($_SESSION))
   session_start();

$data = array();
$data['status'] = false;
$data['text'] = 'Nothing to delete';

if(checkLoggedStatus()){
   if(isset($_POST['id']) && !empty($_POST['id']) ){
      include 'db.php';

      $query = $con->prepare("SELECT * FROM user where _id = ?");
      $query->bind_param('i', $_POST['id']);
      $query->execute();

      $result = $query->get_result();

      if($result->num_rows == 1){
         $data['status'] = true;
         $result = $result->fetch_assoc();

         $query = $con->prepare("DELETE FROM user where _id = ?");
         $query->bind_param('i',$_POST['id']);
         if($query->execute()){
            if($result['user_profile_photo'] != ''){
               unlink('../uploaded_files/profilePhoto/'.$result['user_profile_photo']);
            }
            if($result['user_aadhar_card'] != ''){
               unlink('../uploaded_files/aadharCard/'.$result['user_aadhar_card']);
            }
            if($result['user_pan_card'] != ''){
               unlink('../uploaded_files/panCard/'.$result['user_pan_card']);
            }
            $data['text'] = '<p>User deleted</p>';
         }
         else{
            $data['text'] = '<p>User not deleted</p>';
         }
      }
   }
}

echo json_encode($data);
?>
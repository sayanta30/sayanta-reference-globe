<?php

include 'checkLoggedStatusFunction.php';

if(!isset($_SESSION))
   session_start();

$data = array();
$data['status'] = false;
$data['text'] = 'Nothing to update';

if(checkLoggedStatus()){
   if(isset($_POST['updateUserID'], $_POST['updateUserName'], $_POST['updateUserEmail'], $_POST['updateUserMob'], $_POST['updateUserDOB'], $_POST['updateUserSign'], $_POST['updateUserRole']) && !empty($_POST['updateUserID']) && !empty($_POST['updateUserName'])  && !empty($_POST['updateUserEmail'])  && !empty($_POST['updateUserMob'])  && !empty($_POST['updateUserDOB'])  && !empty($_POST['updateUserSign']) && !empty($_POST['updateUserRole'])){
      include 'db.php';
      include 'duplicateEmailFunction.php';

      $errorText = '';
      $uploadflag = 1;
      $successText = '';

      $query = $con->prepare("SELECT * FROM user where _id = ?");
      $query->bind_param('i', $_POST['updateUserID']);
      $query->execute();

      $result = $query->get_result()->fetch_assoc();

      if($result['user_role'] != $_POST['updateUserRole']){
         $updateQuery = $con->prepare('UPDATE user set user_role = ? where _id = ?');
         $updateQuery->bind_param('si', $_POST['updateUserRole'], $_POST['updateUserID']);
         if($updateQuery->execute()){
            $successText .= 'Updated Role';
         }
      }
      if($result['user_name'] != $_POST['updateUserName']){
         $updateQuery = $con->prepare('UPDATE user set user_name = ? where _id = ?');
         $updateQuery->bind_param('si', $_POST['updateUserName'], $_POST['updateUserID']);
         if($updateQuery->execute()){
            $successText .= 'Updated Name';
         }
      }
      if($result['user_email'] != $_POST['updateUserEmail']){
         if(!duplicateEmail($_POST['updateUserEmail'])){
            $updateQuery = $con->prepare('UPDATE user set user_email = ? where _id = ?');
            $updateQuery->bind_param('si', $_POST['updateUserEmail'], $_POST['updateUserID']);
            if($updateQuery->execute()){
               $successText .= 'Updated Email';
            }
         }
         else{
            $errorText .= '<p>Duplicate Email</p>';
         }
      }
      if($result['user_mobile'] != $_POST['updateUserMob']){
         $updateQuery = $con->prepare('UPDATE user set user_mobile = ? where _id = ?');
         $updateQuery->bind_param('si', $_POST['updateUserMob'], $_POST['updateUserID']);
         if($updateQuery->execute()){
            $successText .= 'Updated Mobile';
         }
      }
      if($result['user_dob'] != $_POST['updateUserDOB']){
         $updateQuery = $con->prepare('UPDATE user set user_dob = ? where _id = ?');
         $updateQuery->bind_param('si', $_POST['updateUserDOB'], $_POST['updateUserID']);
         if($updateQuery->execute()){
            $successText .= 'Updated Date of Birth';
         }
      }
      if($result['user_signature'] != $_POST['updateUserSign']){
         $updateQuery = $con->prepare('UPDATE user set user_signature = ? where _id = ?');
         $updateQuery->bind_param('si', $_POST['updateUserSign'], $_POST['updateUserID']);
         if($updateQuery->execute()){
            $successText .= 'Updated Sign';
         }
      }

      if(isset($_FILES)){
         $allowedExtensionProfilePhoto = array('png','jpg');
         $allowedExtensionAadharPanCard = array('png','jpg','pdf');
         if(isset($_FILES['updateUserProfilePhoto']) && !empty($_FILES['updateUserProfilePhoto']['name']) && $_FILES['updateUserProfilePhoto']['size'] != 0){
            $fileType = explode('.',$_FILES['updateUserProfilePhoto']['name']);
            if(sizeof($fileType) == 2){
               if(in_array($fileType[1],$allowedExtensionProfilePhoto)){
                  $fileName = $_POST['updateUserID'].$_FILES['updateUserProfilePhoto']['name'];
                  if(move_uploaded_file($_FILES['updateUserProfilePhoto']['tmp_name'],'../uploaded_files/profilePhoto/'.$fileName)){
                     $updateQuery = $con->prepare('UPDATE user set user_profile_photo = ? where _id = ?');
                     $updateQuery->bind_param('si', $fileName, $_POST['updateUserID']);
                     if($updateQuery->execute()){
                        $successText .= 'Updated Profile Photo';
                     }
                     else{
                        $errorText .= '<p>Problem with the database.</p>';
                        $uploadflag = 0;
                     }
                  }
               }
               else{
                  $errorText .= '<p>Invalid file extensions for Profile Photo</p>';
                  $uploadflag = 0;
               }
            }
            else{
               $errorText .= '<p>Invalid file format for Profile Photo</p>';
               $uploadflag = 0;
            }
         }
         if(isset($_FILES['updateUserAadhar']) && !empty($_FILES['updateUserAadhar']['name']) && $_FILES['updateUserAadhar']['size'] != 0){
            $fileType = explode('.',$_FILES['updateUserAadhar']['name']);
            if(sizeof($fileType) == 2){
               if(in_array($fileType[1],$allowedExtensionAadharPanCard)){
                  $fileName = $_POST['updateUserID'].$_FILES['updateUserAadhar']['name'];
                  if(move_uploaded_file($_FILES['updateUserAadhar']['tmp_name'],'../uploaded_files/aadharCard/'.$fileName)){
                     $updateQuery = $con->prepare('UPDATE user set user_aadhar_card = ? where _id = ?');
                     $updateQuery->bind_param('si', $fileName, $_POST['updateUserID']);
                     if($updateQuery->execute()){
                        $successText .= 'Updated Aadhar Card';
                     }
                     else{
                        $errorText .= '<p>Problem with the database.</p>';
                        $uploadflag = 0;
                     }
                  }
               }
               else{
                  $errorText .= '<p>Invalid file extensions for Aadhar Card</p>';
                  $uploadflag = 0;
               }
            }
            else{
               $errorText .= '<p>Invalid file format for Aadhar Card</p>';
               $uploadflag = 0;
            }
         }
         if(isset($_FILES['updateUserPan']) && !empty($_FILES['updateUserPan']['name']) && $_FILES['updateUserPan']['size'] != 0){
            $fileType = explode('.',$_FILES['updateUserPan']['name']);
            if(sizeof($fileType) == 2){
               if(in_array($fileType[1],$allowedExtensionAadharPanCard)){
                  $fileName = $_POST['updateUserID'].$_FILES['updateUserPan']['name'];
                  if(move_uploaded_file($_FILES['updateUserPan']['tmp_name'],'../uploaded_files/panCard/'.$fileName)){
                     $updateQuery = $con->prepare('UPDATE user set user_pan_card = ? where _id = ?');
                     $updateQuery->bind_param('si', $fileName, $_POST['updateUserID']);
                     if($updateQuery->execute()){
                        $successText .= 'Updated Pan Card';
                     }
                     else{
                        $errorText .= '<p>Problem with the database.</p>';
                        $uploadflag = 0;
                     }
                  }
               }
               else{
                  $errorText .= '<p>Invalid file extensions for Pan Card</p>';
                  $uploadflag = 0;
               }
            }
            else{
               $errorText .= '<p>Invalid file format for Pan Card</p>';
               $uploadflag = 0;
            }
         }
      }

      {
         if(!empty($successText)){
            $data['text'] = $successText;
            if(!$uploadflag){
               $data['text'] .= $errorText;
            }   
         }
         elseif(!$uploadflag){
            $data['text'] = $errorText;
         }
         $data['status'] = true;
      }


   }
   else{
      $data['text'] = 'Some inputs were empty';
   }
}

echo json_encode($data);
?>
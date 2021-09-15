<?php
include 'checkLoggedStatusFunction.php';

if(!isset($_SESSION))
   session_start();

$data = array();
$data['status'] = false;
$data['text'] = 'Nothing to add';

if(checkLoggedStatus()){
   if(isset($_POST['newUserName'], $_POST['newUserPassword'], $_POST['newUserEmail'], $_POST['newUserMob'], $_POST['newUserDOB'], $_POST['newUserSign'], $_POST['newUserRole']) && !empty($_POST['newUserName']) && !empty($_POST['newUserPassword']) && !empty($_POST['newUserEmail']) && !empty($_POST['newUserMob']) && !empty($_POST['newUserDOB']) && !empty($_POST['newUserSign']) && !empty($_POST['newUserRole']) ){
      include 'db.php';
      include 'duplicateEmailFunction.php';
      include 'duplicateMobileFunction.php';

      $errorText = '';
      $uploadflag = 1;
      $successText = '';
      $readyForInsert = 1;

      $data['status'] = true;

      if(duplicateEmail($_POST['newUserEmail'])){
         $readyForInsert = 0;
         $errorText = '<p>Duplicate Email</p>';
      }

      if(duplicateMobile($_POST['newUserMob'])){
         $readyForInsert = 0;
         $errorText = '<p>Duplicate Mobile</p>';
      }

      if($_SESSION['user_details']['user_role'] == 'Super Admin'){
         if(trim($_POST['newUserRole']) != 'Super Admin' && trim($_POST['newUserRole']) != 'Admin' && trim($_POST['newUserRole']) != 'User'){
            $readyForInsert = 0;
            $errorText = '<p>User role illegal.</p>';
         }
      }

      if($_SESSION['user_details']['user_role'] == 'Admin'){
         if(trim($_POST['newUserRole']) != 'Admin' && trim($_POST['newUserRole']) != 'User'){
            $readyForInsert = 0;
            $errorText = '<p>User role illegal.</p>';
         }
      }

      if($readyForInsert){
         $pass = md5(trim($_POST['newUserPassword']));
         $query = $con->prepare('INSERT INTO user(user_name, user_email, user_pass, user_mobile, user_dob, user_signature, user_role) VALUES(?,?,?,?,?,?,?)');
         $query->bind_param('sssssss', $_POST['newUserName'], $_POST['newUserEmail'], $pass, $_POST['newUserMob'], $_POST['newUserDOB'], $_POST['newUserSign'], $_POST['newUserRole']);
         if($query->execute()){
            $latestUser = $con->insert_id;
            $successText .= '<p>User added.</p>';
            if(isset($_FILES)){
               $allowedExtensionProfilePhoto = array('png','jpg');
               $allowedExtensionAadharPanCard = array('png','jpg','pdf');
               if(isset($_FILES['newUserProfilePhoto']) && !empty($_FILES['newUserProfilePhoto']['name']) && $_FILES['newUserProfilePhoto']['size'] != 0){
                  $fileType = explode('.',$_FILES['newUserProfilePhoto']['name']);
                  if(sizeof($fileType) == 2){
                     if(in_array($fileType[1],$allowedExtensionProfilePhoto)){
                        $fileName = $latestUser.$_FILES['newUserProfilePhoto']['name'];
                        if(move_uploaded_file($_FILES['newUserProfilePhoto']['tmp_name'],'../uploaded_files/profilePhoto/'.$fileName)){
                           $updateQuery = $con->prepare('UPDATE user set user_profile_photo = ? where _id = ?');
                           $updateQuery->bind_param('si', $fileName, $latestUser);
                           if(!$updateQuery->execute()){
                              $successText .= '<p>Problem with Database.</p>';
                              $uploadflag = 0;
                           }
                        }
                        else{
                           $successText .= '<p>Unable to upload Profile Photo</p>';
                           $uploadflag = 0;
                        }
                     }
                     else{
                        $successText .= '<p>Invalid file extensions for Profile Photo</p>';
                        $uploadflag = 0;
                     }
                  }
                  else{
                     $successText .= '<p>Invalid file format for Profile Photo</p>';
                     $uploadflag = 0;
                  }
               }
               if(isset($_FILES['newUserAadhar']) && !empty($_FILES['newUserAadhar']['name']) && $_FILES['newUserAadhar']['size'] != 0){
                  $fileType = explode('.',$_FILES['newUserAadhar']['name']);
                  if(sizeof($fileType) == 2){
                     if(in_array($fileType[1],$allowedExtensionAadharPanCard)){
                        $fileName = $latestUser.$_FILES['newUserAadhar']['name'];
                        if(move_uploaded_file($_FILES['newUserAadhar']['tmp_name'],'../uploaded_files/aadharCard/'.$fileName)){
                           $updateQuery = $con->prepare('UPDATE user set user_aadhar_card = ? where _id = ?');
                           $updateQuery->bind_param('si', $fileName, $latestUser);
                           if(!$updateQuery->execute()){
                              $successText .= '<p>Problem with Database.</p>';
                              $uploadflag = 0;
                           }
                        }
                        else{
                           $successText .= '<p>Unable to upload Aadhar Card</p>';
                           $uploadflag = 0;
                        }
                     }
                     else{
                        $successText .= '<p>Invalid file extensions for Aadhar Card</p>';
                        $uploadflag = 0;
                     }
                  }
                  else{
                     $successText .= '<p>Invalid file format for Aadhar Card</p>';
                     $uploadflag = 0;
                  }
               }
               if(isset($_FILES['newUserPan']) && !empty($_FILES['newUserPan']['name']) && $_FILES['newUserPan']['size'] != 0){
                  $fileType = explode('.',$_FILES['newUserPanPan']['name']);
                  if(sizeof($fileType) == 2){
                     if(in_array($fileType[1],$allowedExtensionAadharPanCard)){
                        $fileName = $latestUser.$_FILES['newUserPan']['name'];
                        if(move_uploaded_file($_FILES['newUserPan']['tmp_name'],'../uploaded_files/panCard/'.$fileName)){
                           $updateQuery = $con->prepare('UPDATE user set user_aadhar_card = ? where _id = ?');
                           $updateQuery->bind_param('si', $fileName, $latestUser);
                           if(!$updateQuery->execute()){
                              $successText .= '<p>Problem with Database.</p>';
                              $uploadflag = 0;
                           }
                        }
                        else{
                           $successText .= '<p>Unable to upload Pan Card</p>';
                           $uploadflag = 0;
                        }
                     }
                     else{
                        $successText .= '<p>Invalid file extensions for Pan Card</p>';
                        $uploadflag = 0;
                     }
                  }
                  else{
                     $successText .= '<p>Invalid file format for Pan Card</p>';
                     $uploadflag = 0;
                  }
               }
            }
            $data['text'] = $successText;
         }
      }
      else{
         $data['text'] = $errorText;
      }
   }
   else{
      $data['text'] = 'Required fields were empty';
   }
}

echo json_encode($data);
?>
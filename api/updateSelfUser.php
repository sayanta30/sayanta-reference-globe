<?php

include 'checkLoggedStatusFunction.php';

if(!isset($_SESSION))
   session_start();

$data = array();
$data['status'] = false;
$data['text'] = 'Nothing to update';

if(checkLoggedStatus()){
   if(isset($_POST['updateSelfName'], $_POST['updateSelfEmail'], $_POST['updateSelfMob'], $_POST['updateSelfDOB'], $_POST['updateSelfSign']) && !empty($_POST['updateSelfName'])  && !empty($_POST['updateSelfEmail'])  && !empty($_POST['updateSelfMob'])  && !empty($_POST['updateSelfDOB'])  && !empty($_POST['updateSelfSign']) ){
      include 'db.php';
      include 'duplicateEmailFunction.php';

      $errorText = '';
      $uploadflag = 1;
      $successText = '';

      $query = $con->prepare("SELECT * FROM user where _id = ?");
      $query->bind_param('i', $_SESSION['user_details']['_id']);
      $query->execute();

      $result = $query->get_result()->fetch_assoc();

      if($result['user_name'] != $_POST['updateSelfName']){
         $updateQuery = $con->prepare('UPDATE user set user_name = ? where _id = ?');
         $updateQuery->bind_param('si', $_POST['updateSelfName'], $_SESSION['user_details']['_id']);
         if($updateQuery->execute()){
            $_SESSION['user_details']['user_name'] = $_POST['updateSelfName'];
            $successText .= 'Updated Name';
         }
      }
      if($result['user_email'] != $_POST['updateSelfEmail']){
         if(!duplicateEmail($_POST['updateSelfEmail'])){
            $updateQuery = $con->prepare('UPDATE user set user_email = ? where _id = ?');
            $updateQuery->bind_param('si', $_POST['updateSelfEmail'], $_SESSION['user_details']['_id']);
            if($updateQuery->execute()){
               $_SESSION['user_details']['user_email'] = $_POST['updateSelfEmail'];
               $successText .= 'Updated Email';
            }
         }
         else{
            $errorText .= '<p>Duplicate Email</p>';
         }
      }
      if($result['user_mobile'] != $_POST['updateSelfMob']){
         $updateQuery = $con->prepare('UPDATE user set user_mobile = ? where _id = ?');
         $updateQuery->bind_param('si', $_POST['updateSelfMob'], $_SESSION['user_details']['_id']);
         if($updateQuery->execute()){
            $_SESSION['user_details']['user_mobile'] = $_POST['updateSelfMob'];
            $successText .= 'Updated Mobile';
         }
      }
      if($result['user_dob'] != $_POST['updateSelfDOB']){
         $updateQuery = $con->prepare('UPDATE user set user_dob = ? where _id = ?');
         $updateQuery->bind_param('si', $_POST['updateSelfDOB'], $_SESSION['user_details']['_id']);
         if($updateQuery->execute()){
            $_SESSION['user_details']['user_dob'] = $_POST['updateSelfDOB'];
            $successText .= 'Updated Date of Birth';
         }
      }
      if($result['user_signature'] != $_POST['updateSelfSign']){
         $updateQuery = $con->prepare('UPDATE user set user_signature = ? where _id = ?');
         $updateQuery->bind_param('si', $_POST['updateSelfSign'], $_SESSION['user_details']['_id']);
         if($updateQuery->execute()){
            $_SESSION['user_details']['user_signature'] = $_POST['updateSelfSign'];
            $successText .= 'Updated Sign';
         }
      }

      if(isset($_FILES)){
         $allowedExtensionProfilePhoto = array('png','jpg');
         $allowedExtensionAadharPanCard = array('png','jpg','pdf');
         if(isset($_FILES['updateSelfProfilePhoto']) && !empty($_FILES['updateSelfProfilePhoto']['name']) && $_FILES['updateSelfProfilePhoto']['size'] != 0){
            $fileType = explode('.',$_FILES['updateSelfProfilePhoto']['name']);
            if(sizeof($fileType) == 2){
               if(in_array($fileType[1],$allowedExtensionProfilePhoto)){
                  $fileName = $_SESSION['user_details']['_id'].$_FILES['updateSelfProfilePhoto']['name'];
                  if(move_uploaded_file($_FILES['updateSelfProfilePhoto']['tmp_name'],'../uploaded_files/profilePhoto/'.$fileName)){
                     $updateQuery = $con->prepare('UPDATE user set user_profile_photo = ? where _id = ?');
                     $updateQuery->bind_param('si', $fileName, $_SESSION['user_details']['_id']);
                     if($updateQuery->execute()){
                        $_SESSION['user_details']['user_profile_photo'] = $fileName;
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
         if(isset($_FILES['updateSelfAadhar']) && !empty($_FILES['updateSelfAadhar']['name']) && $_FILES['updateSelfAadhar']['size'] != 0){
            $fileType = explode('.',$_FILES['updateSelfAadhar']['name']);
            if(sizeof($fileType) == 2){
               if(in_array($fileType[1],$allowedExtensionAadharPanCard)){
                  $fileName = $_SESSION['user_details']['_id'].$_FILES['updateSelfAadhar']['name'];
                  if(move_uploaded_file($_FILES['updateSelfAadhar']['tmp_name'],'../uploaded_files/aadharCard/'.$fileName)){
                     $updateQuery = $con->prepare('UPDATE user set user_aadhar_card = ? where _id = ?');
                     $updateQuery->bind_param('si', $fileName, $_SESSION['user_details']['_id']);
                     if($updateQuery->execute()){
                        $_SESSION['user_details']['user_aadhar_card'] = $fileName;
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
         if(isset($_FILES['updateSelfPan']) && !empty($_FILES['updateSelfPan']['name']) && $_FILES['updateSelfPan']['size'] != 0){
            $fileType = explode('.',$_FILES['updateSelfPan']['name']);
            if(sizeof($fileType) == 2){
               if(in_array($fileType[1],$allowedExtensionAadharPanCard)){
                  $fileName = $_SESSION['user_details']['_id'].$_FILES['updateSelfPan']['name'];
                  if(move_uploaded_file($_FILES['updateSelfPan']['tmp_name'],'../uploaded_files/panCard/'.$fileName)){
                     $updateQuery = $con->prepare('UPDATE user set user_pan_card = ? where _id = ?');
                     $updateQuery->bind_param('si', $fileName, $_SESSION['user_details']['_id']);
                     if($updateQuery->execute()){
                        $_SESSION['user_details']['user_pan_card'] = $fileName;
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
<?php

   include './checkLoggedStatusFunction.php';
   $data = array();

   $data['status'] = true;
   $data['text'] = 'Nothing to update';
   
   if(!isset($_SESSION)){
      session_start();
   }

   if(!checkLoggedStatus()){
      $data['status'] = false;
   }

   if(isset($_POST['pass']) && !empty($_POST['pass'])){
      include 'db.php';
      $password = md5(trim($_POST['pass']));

      $query = $con->prepare('SELECT * FROM user where _id = ?');
      $query->bind_param("i", $_SESSION['user_details']['_id']);
      $query->execute();

      $result = $query->get_result();

      if($result->num_rows > 0){
         $data['status'] = true;
         $row = $result->fetch_assoc();
         if($row['user_pass'] != $password){
            $query = $con->prepare("UPDATE user SET user_pass = ?");
            $query->bind_param('s', $password);
            if($query->execute()){
               $data['text'] = 'You password is updated<br>Login with the new password.';
            }
            else{
               $data['status'] = false;
               $data['text'] = 'Your password updation failes!';
            }
         }
      }
   }
   else{
      $data['text'] = '<p>Required fields are empty, so password change failed.</p>';
   }
   echo json_encode($data);
?>
<?php

include './checkLoggedStatusFunction.php';

if(!isset($_SESSION))
   session_start();

$data = array();
$data['status'] = false;

if(!checkLoggedStatus())
   $data['status'] = false;

if(isset($_POST['username'], $_POST['pass']) && !empty($_POST['username']) && !empty($_POST['pass'])){
   include 'db.php';
   $user = $_POST['username'];
   $pass = $_POST['pass'];

   $query = $con->prepare('SELECT * FROM user where user_email = ?');
   $query->bind_param('s',$user);
   $query->execute();
   $result = $query->get_result();

   if($result->num_rows == 1){
      $result = $result->fetch_assoc();
      if(md5($pass) == $result['user_pass']){
         $_SESSION['logged'] = true;
         $_SESSION['user_details'] = $result;
         $data['status'] = true;
      }
   }
}

echo json_encode($data);
<?php
   function loggedUserDetails(){
      include 'db.php';
      $query = $con->prepare("SELECT * FROM user where _id = ?");
      $query->bind_param('i',$_SESSION['user_details']['_id']);
      $query->execute();
      return $query->get_result()->fetch_assoc();
   }
?>
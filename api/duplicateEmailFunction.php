<?php

function duplicateEmail($email){
   include 'db.php';
   $query = $con->prepare('SELECT count(_id) total from user where user_email = ?');
   $query->bind_param('s',$email);
   $query->execute();

   return $query->get_result()->fetch_assoc()['total'] > 0 ? true : false;
}

?>
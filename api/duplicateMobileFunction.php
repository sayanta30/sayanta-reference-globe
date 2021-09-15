<?php

function duplicateMobile($mobile){
   include 'db.php';
   $query = $con->prepare('SELECT count(_id) total from user where user_mobile = ?');
   $query->bind_param('s',$mobile);
   $query->execute();

   return $query->get_result()->fetch_assoc()['total'] > 0 ? true : false;
}

?>
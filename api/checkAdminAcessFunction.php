<?php

function checkAdminAccess(){
   if(!isset($_SESSION)){
      session_start();
   }
   
   return isset($_SESSION['user_details']) && !empty($_SESSION['user_details']) && $_SESSION['user_details']['user_role'] != 'User' ? true : false;
}

?>
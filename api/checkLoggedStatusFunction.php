<?php

function checkLoggedStatus(){
   if(!isset($_SESSION))
      session_start();
   
   return isset($_SESSION['logged']) && !empty($_SESSION['logged']) && $_SESSION['logged'] == true ? true : false;
}

?>
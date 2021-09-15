<?php
   $serverName = "localhost";
   $dbUser = "root";
   $dbPass = "root";
   $dbName= "sayanta_reference_globe";
   
   // Create connection
   $con = new mysqli($serverName, $dbUser, $dbPass , $dbName);
   
   // Check connection
   if ($con->connect_error) {
      die("Connection failed: " . $con->connect_error);
   }
?>
<?php
   function writeData($data){
      $jsonfile = fopen("../data/data.json", "w") or die("Unable to open file!");
      $status = fwrite($jsonfile, '{ "data": '.json_encode($data).' }') == true ? 1 : 0;
      fclose($jsonfile);

      return $status;
   }
?>
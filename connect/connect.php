<?php

$hostname = "localhost";
 $dbname = "otop";
 $uname = "root";
$pwd = "";
$proj_connect = mysqli_connect($hostname, $uname, $pwd ,
 $dbname);
 if (!$proj_connect) {
  die("Connection failed: ". mysqli_connect_error());
 }
mysqli_query($proj_connect, "SET NAMES 'utf8' ");
mysqli_query($proj_connect, "SET character_set_results=utf8");
mysqli_query($proj_connect, "SET character_set_client='utf8'");
mysqli_query($proj_connect, "SET
character_set_connection= 'utf8'");
date_default_timezone_set("Asia/Bangkok");
?>
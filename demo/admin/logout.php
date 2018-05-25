<?php

include_once "../db_connect.php";

session_start();
mysql_close();
session_destroy();

header("location:index.php");

?>

<?php
ini_set('display_errors', 0); 
// $servername = "localhost";
// $username = "root";
// $password = "";

// $servername = "localhost";
// $username = "platinat_client";
// $password = "8v)4.K?{{5uo";

$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = mysql_connect($servername, $username, $password);

// Check connection 

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 
// echo "Connected successfully";

$db_selected = mysql_select_db('survey_data', $conn);
// $db_selected = mysql_select_db('platinat_client', $conn);
// $db_selected = mysql_select_db('db_client', $conn);
if (!$db_selected) {
	die ( mysql_error());
}

?>
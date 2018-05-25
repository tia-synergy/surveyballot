<html>
<head>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>
<body>
<?php
include_once "db_connect.php";
$sql = "Delete from tb_customerheartbeat where client_id ='".$_REQUEST['client_id']."'";
$query=mysql_query($sql);
if ($query) {
    echo "Record deleted successfully";
} 
else {
    echo "Error deleting record: " . $query->error;
}

mysql_close($conn)	
?>
</body>
</html>


<?php
$con = new mysqli("localhost","root","","data");

$query = "SELECT * FROM filter";
$query_run = mysqli_query($con, $query);

if($con -> connect_error) {
  echo "Error 404. Failed to connect: " . $con -> connect_error;
  exit();
}

?>
<?php

//connect to database
$hostname = 'localhost';
$user = 'root';
$pass = 'root';
$database = 'UserInfo';
$conn =  @mysqli_connect($hostname, $user, $pass, $database) or die('Cannot connect to server');

//display service list
$servicelist = "SELECT name FROM ServiceList";
$result = $conn->query( $servicelist );
$row = $result->fetch_assoc();
echo "<p style=\"text-decoration:underline;\">Service Type List</p>";
for ($x = 0; $x < $result->num_rows; ++$x) {
    echo $row['name'];
    echo "<br>";
    $row = $result->fetch_assoc();
}

?>

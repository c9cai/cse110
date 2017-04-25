<?php

$newService = $_POST['service'];
$price = $_POST['price'];
$duration = $_POST['duration'];

//connect to database
$hostname = 'localhost';
$user = 'root';
$pass = 'root';
$database = 'UserInfo';

$conn =  @mysqli_connect($hostname, $user, $pass, $database) or die('Cannot connect to server');

//modify tables
$ServiceList = 'ServiceList';
$PackageList = 'PackageList';

//check if service exists
$checkValid = "SELECT id FROM $ServiceList WHERE name = '$newService'";
$result = $conn->query( $checkValid ) or die('failed query');
if( $result->num_rows > 0 ) {
    echo "<br>";
    echo "Service already exists";

    die();
    exit();
}

//add new column in info
$addToInfo = "ALTER TABLE Info ADD $newService INT NOT NULL DEFAULT '0'";
$conn->query( $addToInfo ) or die('failed to add to Info');

//add Service to Service List
$addToServiceList = "INSERT INTO $ServiceList ( id, name, price, duration )
VALUES ( NULL, '$newService', '$price', '$duration' )";
$conn->query( $addToServiceList ) or die('failed to add to service list');

//add new type of service to individual packages
$readPackageList = "Select name FROM $PackageList";
$result = $conn->query( $readPackageList ) or die('failed to get package names');
$count = $result->num_rows;
$row = $result->fetch_assoc();
for ($x = 0; $x < $count; ++$x) {
    $packageName = $row['name'];
    $row = $result->fetch_assoc();
    $addToPackageList = "INSERT INTO $packageName ( id, name, has )
    VALUES ( NULL, '$newService', '0' )";
    $conn->query( $addToPackageList ) or die('add to individual package failed');
}

echo "<br>Service successfully added!";

?>

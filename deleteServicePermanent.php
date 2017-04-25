<?php

$service = $_POST['myService'];

//connect to database
$hostname = 'localhost';
$user = 'root';
$pass = 'root';
$database = 'UserInfo';

$conn =  @mysqli_connect($hostname, $user, $pass, $database) or die('Cannot connect to server');

//modify tables
$ServiceList = 'ServiceList';

//check if package exists
$checkValid = "SELECT id FROM $ServiceList WHERE name = '$service'";
$result = $conn->query( $checkValid ) or die('failed query');
if( $result->num_rows == 0 ) {
    echo "<br>";
    echo "Service doesn't exist";

    die();
    exit();
}

//delete column in info
$deleteColumn = "ALTER TABLE Info DROP $service";
$conn->query($deleteColumn);

//delete column in servicelist
$deleteColumn = "DELETE FROM ServiceList WHERE name='$service'";
$conn->query($deleteColumn);

//iterate through package list
$iteratePackages = "SELECT name FROM PackageList";
$result = $conn->query($iteratePackages);
while($row = $result->fetch_assoc()) {
    $packageName = $row["name"];
    $deleteRow = "DELETE FROM $packageName WHERE name='$service'";
    $conn->query($deleteRow);
}

echo "<br>Service successfully deleted!";

?>

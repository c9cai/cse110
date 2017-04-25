<?php

$addService = $_POST['service'];
$toPackage = $_POST['mypackage'];

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
$checkValid = "SELECT id FROM $ServiceList WHERE name = '$addService'";
$resultValid = $conn->query( $checkValid ) or die('failed query');
if( $resultValid->num_rows < 1 ) {
    echo "<br>";
    echo "Service does not exist!";

    die();
    exit();
}

$addToPackage = "UPDATE $toPackage SET has = '1' WHERE name = '$addService'";
$conn->query( $addToPackage ) or die('failed to update package');

//check if package exist for every user and update Info
$infoList = "SELECT id FROM Info";
$result = $conn->query( $infoList ) or die('failed to get Info Ids');
$row = $result->fetch_assoc();
$count = $result->num_rows;
for ($x = 0; $x < $count; ++$x) {
    $id = $row['id'];
    $row = $result->fetch_assoc();

    $getHas = "SELECT $toPackage FROM Info WHERE id = '$id'";
    $resultHas = $conn->query( $getHas ) or fail("failed to get has of package");
    $rowHas = $resultHas->fetch_assoc();
    if( $rowHas[$toPackage] == 1 ) {
        $updateInfo = "UPDATE Info SET $addService = '1' WHERE id = $id";
        $conn->query( $updateInfo ) or die('failed query');
    }
}

echo "<br>Service successfully added to Package and updated on all Users!";

?>

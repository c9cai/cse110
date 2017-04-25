<?php

//connect to database
$hostname = 'localhost';
$user = 'root';
$pass = 'root';
$database = 'UserInfo';
$conn =  @mysqli_connect($hostname, $user, $pass, $database) or die('Cannot connect to server');

//display package list
$servicelist = "SELECT name FROM PackageList";
$result = $conn->query( $servicelist );
$row = $result->fetch_assoc();
echo "<p style=\"text-decoration:underline;\">Package List</p>";
for ($x = 0; $x < $result->num_rows; ++$x) {
    $currentPackage = $row['name'];
    echo $currentPackage;
    echo ": ";
    
    //print services for each package
    $getPackageServices = "SELECT name FROM $currentPackage";
    $getPackageHas = "SELECT has FROM $currentPackage";
    $resultServices = $conn->query( $getPackageServices );
    $resultHas = $conn->query( $getPackageHas );
    $rowServices = $resultServices->fetch_assoc();
    $rowHas = $resultHas->fetch_assoc();
    for ($y = 0; $y < $resultServices->num_rows; ++$y) {
        $currentService = $rowServices['name'];
        $currentHas = $rowHas['has'];
        if ($currentHas == 1) {
            echo "[$currentService] ";
        }
        
        $rowServices = $resultServices->fetch_assoc();
        $rowHas = $resultHas->fetch_assoc();
    }
    
    echo "<br>";
    $row = $result->fetch_assoc();
}

?>

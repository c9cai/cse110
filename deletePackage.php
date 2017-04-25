<?php

$package = $_POST['myPackage'];

//connect to database
$hostname = 'localhost';
$user = 'root';
$pass = 'root';
$database = 'UserInfo';

$conn =  @mysqli_connect($hostname, $user, $pass, $database) or die('Cannot connect to server');

//modify tables
$PackageList = 'PackageList';

//check if package exists
$checkValid = "SELECT id FROM $PackageList WHERE name = '$package'";
$result = $conn->query( $checkValid ) or die('failed query');
if( $result->num_rows == 0 ) {
    echo "<br>";
    echo "Package doesn't exist";

    die();
    exit();
}

//delete package services from INFO
$fineOnce = 0;
$iterateServices = "Select name,has from $package";
$result = $conn->query($iterateServices)or die("cannot fetch from package");
//loop through each service the package contains
while($row = $result->fetch_assoc()) {
    $has = $row["has"];
    if ($has == 1) {
        $iterateUsers = "Select id from Info";
	$resultUsers = $conn->query($iterateUsers)or die("cannot fetch names from info");
	//loop through all users who have the package
	while ($rowUsers = $resultUsers->fetch_assoc()) {
	    $currID = $rowUsers["id"];
	    $hasPackage = "Select $package from Info where id='$currID'";
	    $hasResult = $conn->query($hasPackage)or die("failed to fetch package from info");
	    $fetchHas = $hasResult->fetch_assoc();
	    //set service to 0 if user had the package
	    if ($fetchHas["$package"] == 1) {
		$serviceName = $row["name"];
		$removePackageService = "UPDATE Info SET $serviceName=0 WHERE id='$currID'";
		$conn->query($removePackageService)or die("failed to remove service");
	
		if ($fineOnce == 0) {		
		    $setFine = "UPDATE Info SET fines=fines+30 WHERE id='$currID'";
		    $conn->query($setFine)or die("couldnt set fine");
		    $fineOnce = 1;
		}
	    }
	}
    }
}

//delete column in info
$deleteColumn = "ALTER TABLE Info DROP $package";
$conn->query($deleteColumn);

//delete column in packagelist
$deleteColumn = "DELETE FROM PackageList WHERE name='$package'";
$conn->query($deleteColumn);

//drop table
$deleteTable = "DROP TABLE $package";
$conn->query($deleteTable);

echo "<br>Package successfully deleted!";

?>

<?php

//connect to database
$username = $_POST['username'];
$hostname = 'localhost';
$user = 'root';
$pass = 'root';
$database = 'UserInfo';
$conn =  @mysqli_connect($hostname, $user, $pass, $database) or die('Cannot connect to server');

//display package list
$sql = "SELECT * FROM Info";
$servicelist = "SELECT name FROM PackageList";
$result2 = $conn->query($sql);
$result = $conn->query( $servicelist );
$row = $result->fetch_assoc();
echo "<p style=\"text-decoration:underline;\">Package List</p>";

for ($x = 0; $x < $result->num_rows; ++$x) {
    $currentPackage = $row['name'];
    
    //print services for each package
    $getPackageServices = "SELECT name FROM $currentPackage";
    $getPackageHas = "SELECT has FROM $currentPackage";
    $resultServices = $conn->query( $getPackageServices );
    $resultHas = $conn->query( $getPackageHas );
    $rowServices = $resultServices->fetch_assoc();
    $rowHas = $resultHas->fetch_assoc();
    while ($row1 = $result2->fetch_assoc()){
    	if ($row1["username"]==$username) {
	  if ($row1["$currentPackage"]==1) {
	    echo "You Have: ";
    	    echo $currentPackage;
   	    echo ": ";
	  }
	  else {
	    echo "You Dont Have: ";
    	    echo $currentPackage;
    	    echo ": ";
	  }
	
    
    for ($y = 0; $y < $resultServices->num_rows; ++$y) {
        $currentService = $rowServices['name'];
        $currentHas = $rowHas['has'];
        if ($currentHas == 1) {
            echo "[$currentService] ";
        }
        
        $rowServices = $resultServices->fetch_assoc();
        $rowHas = $resultHas->fetch_assoc();
      }
    }
}
    echo "<br>";
    $result2 = $conn->query($sql);
    $row = $result->fetch_assoc();
}


?>

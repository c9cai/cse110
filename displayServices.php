<?php

$username = $_POST['username'];
//connect to database
$hostname = 'localhost';
$user = 'root';
$pass = 'root';
$database = 'UserInfo';
$conn =  @mysqli_connect($hostname, $user, $pass, $database) or die('Cannot connect to server');
if ($conn->connect_error) {
    die("Connection failed");
    exit();
}

//display service list
$servicelist = "SELECT * FROM Info WHERE username = '$username'";
$sql2 = "SELECT name,price FROM ServiceList";
$result = $conn->query( $servicelist );
$result2 = $conn->query($sql2);

echo "<p style=\"text-decoration:underline;\">Service List</p>";
while($row = $result->fetch_assoc()){
	if ($username == $row["username"]){
	  while($row2 = $result2->fetch_assoc()) {
	  $name = $row2["name"];
	    if ($row[$row2["name"]] != 0) {
		echo "<font color = 'green'>You have: </font>";
		echo "<font color = 'green'>$name</font>";
		echo "<br>";
	    }
	    else {
		echo "<font color = 'red'>You do not have: ";
		echo "<font color = 'red'>$name</font>";
		echo "<br>";
	    }
	  }
	}
}

//display package list
/*$packagelist = "SELECT Package1,Package2 FROM PackageList WHERE username = '$username'";
$result = $conn->query( $packagelist );
$row = $result->fetch_assoc();
echo "<p style=\"text-decoration:underline;\">Package List</p>";
if ( $row["Package1"] == 0 && $row["Package2"] == 0 ) {
    echo "No packages<br>";
} else {
    if ( $row["Package1"] != 0 ) {
        echo "Package1(Internet and Phone)<br>";
    }
    if ( $row["Package2"] != 0 ) {
        echo "Package2(All three services)<br><br>";
    }
}*/

?>

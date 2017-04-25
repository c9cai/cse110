<?php

$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'UserInfo';

//create connection
$conn =  @mysqli_connect($servername, $username, $password, $dbname) or die('Cannot connect to server');

$sql = "SELECT * FROM Info";
$sql2 = "SELECT name FROM ServiceList";
$result = $conn->query($sql);
$result2 = $conn->query($sql2);


if ($result->num_rows>0) {
	//ouput data of each row
	while ($row = $result->fetch_assoc()) {
	  $id = $row["username"];
	  echo "<br> Name: $id ->";
	  while($row2 = $result2->fetch_assoc()) {	
		$name = $row2["name"];
		if ($row[$row2["name"]] == 0) {
                        $row[$name] = "<font color = 'red'>NO $name </font> ";
                }
                else {
                        $row[$name] = "<font color = 'green'>HAS $name</font> ";
                }
	echo $row[$name];
	echo " | ";
//echo "<br> id: ". $row["id"]. " - Name: ". $row["username"]."   " . $row["internet"] . "   " . $row["phone"]. "    " . $row["utilities"] . "<br>";
	  }
	$result2 = $conn->query($sql2);
	
	}
}
?>

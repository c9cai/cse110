<?php

$newPackage = $_POST['myPackage'];
$price = $_POST['price'];
$duration = $_POST['duration'];

//connect to database
$hostname = 'localhost';
$user = 'root';
$pass = 'root';
$database = 'UserInfo';

$conn =  @mysqli_connect($hostname, $user, $pass, $database) or die('Cannot connect to server');

//modify tables
$PackageList = 'PackageList';

//check if package exists
$checkValid = "SELECT id FROM $PackageList WHERE name = '$newPackage'";
$result = $conn->query( $checkValid ) or die('failed query');
if( $result->num_rows > 0 ) {
    echo "<br>";
    echo "Package already exists";

    die();
    exit();
}

//add new column in info
$addToInfo = "ALTER TABLE Info ADD $newPackage INT NOT NULL DEFAULT '0'";
$conn->query( $addToInfo ) or die('failed to add to Info');

//add pacakge to package List
$addToPackageList = "INSERT INTO $PackageList ( id, name, price, duration )
VALUES ( NULL, '$newPackage', '$price', '$duration' )";
$conn->query( $addToPackageList ) or die('failed to add to service list');

//create packaget table
$createPackage = "CREATE TABLE $newPackage (
id INT AUTO_INCREMENT, 
name varchar(20),
has INT(1),
PRIMARY KEY(id)
)";
$conn->query($createPackage);

//insert into package
$iterateServices = "Select name from ServiceList";
$result = $conn->query($iterateServices)or die("cannot fetch names");
while($row = $result->fetch_assoc()) {
    $toInsert = $row["name"];
    $insert = "INSERT INTO $newPackage (id, name, has) VALUES ( NULL, '$toInsert', '0')";
    $conn->query($insert) or die("failed to insert into table");
}

//$conn->query($createPackage) or die("failed to create package");

echo "created package";

echo "<br>Package successfully added!";
$total = 0;
$sql = "SELECT * FROM Info";
$sql2 = "SELECT name,price FROM ServiceList";
$result = $conn->query($sql);
$result2 = $conn->query($sql2);
$price = 0;
if ($result->num_rows>0) {
        //ouput data of each row
        while ($row = $result->fetch_assoc()) {
          $rowname = $row["username"];
          $fines = $row["fines"];
          while($row2 = $result2->fetch_assoc()) {
            $name = $row2["name"];
                if ($row[$row2["name"]] != 0) {
                        $price = $row2["price"];
                        $row[$name] = $price;
                        $total = $total + $price;
                }
          }
          $total = $total + $fines;
          $balance = "UPDATE Info SET balance=$total WHERE username='$rowname'";
          $conn->query($balance);
          $total = 0;
        $result2 = $conn->query($sql2);
        }

  }


?>

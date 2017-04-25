<?php

$username = $_POST['username'];
$service = $_POST['servicename'];

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


$add = "UPDATE Info SET $service=1 WHERE username='$username'";

if( $conn->query( $add ) == TRUE )
{
    echo "<br>Service added";

$mail = "SELECT * FROM Info";
$result = $conn->query( $mail );

while($row = $result->fetch_assoc()){
        if ($username == $row["username"]){
	$threshold = $row["threshold"];
	$balance = $row["balance"];
	$email = $row["email"];
	}
   }

if ($threshold < $balance) {
  $msg = "ACCOUNT BALANCE HAS REACHED THRESHOLD";

  if (mail($email,"ALERT",$msg)==true) {
	echo "email notif sent";
	}
}
}
else {
echo "No such service";
}

?>

<?php

$username = $_POST['username'];
$service = $_POST['servicename'];

//echo $service;

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

$add = "UPDATE Info SET $service=0 WHERE username='$username'";

if( $conn->query( $add ) == TRUE )
{
    echo "<br>Package removed";
    $fine = "UPDATE Info SET fines=fines+30 WHERE username = '$username'";
    if ($conn->query($fine)==true) {
	echo "<br>$30 fine added";
	}
} else {
    echo "<br>No such package";
}

//$link = mysql_connect("localhost", "root", "root");
//mysql_select_db("UserInfo", $link);
//$result = mysql_query("SELECT * FROM $service", $link);
//$num_rows = mysql_num_rows($result);
$sql = "SELECT name, has FROM $service";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    if ($row["has"]==1) {
      $name = $row["name"];
     $add =  "UPDATE Info SET $name=0 WHERE username='$username'";
     if ($conn->query($add)==TRUE){
	echo "<br>$name added";
	}		
    }		
  }	
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

?>

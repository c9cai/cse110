<?php

//Get User Info
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

//Redirect if info not filled out
if ( $password == null or $username == null ) {   
    //TODO change redirection
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Fill in both username and password')
    window.location.href='index.html';
    </SCRIPT>");
    
    exit();
}

//encrypt address and password
$passwordmd5 = md5($password);

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

//check if username taken
$checkValid = "SELECT id FROM Info WHERE username = '$username' and password = '$passwordmd5'";
$result = $conn->query( $checkValid );
if( $result->num_rows == 0 ) {
    //TODO change redirection
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Invalid username or password')
    window.location.href='index.html';
    </SCRIPT>");

    die();
    exit();
}

$checkType = "SELECT type FROM Info WHERE username = '$username'";
$type = $conn->query($checkType);
$row = $type->fetch_assoc();
if ($row["type"] == "retail") {
    //Alert registration successful
    //TODO change relocation page
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    localStorage.setItem('username', '$username');
    window.alert('Login Successful!');
    window.location.href='retailCustomer.html';
    </SCRIPT>");
} else if ($row["type"] == "representative"){
    //Alert registration successful
    //TODO change relocation page
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    localStorage.setItem('username', '$username');
    window.alert('Login Successful!');
    window.location.href='customerServiceRep.html';
    </SCRIPT>");
}
else if ($row["type"] == "marketing") {
    //Alert registration successful
    //TODO change relocation page
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    localStorage.setItem('username', '$username');
    window.alert('Login Successful!');
    window.location.href='marketRep.html';
    </SCRIPT>");
}
?>

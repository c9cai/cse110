<?php

//Get User Info
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$email = $_REQUEST['email'];
$name = $_REQUEST['name'];
$address = $_REQUEST['address'];
$type = $_REQUEST['type'];

//Redirect if info not filled out
if ( $address == null or $name == null or $email == null or 
     $password == null or $username == null ) {   
    //TODO change redirection
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Fill in all info')
    window.location.href='index.html';
    </SCRIPT>");
    
    exit();
}

//encrypt address and password
$passwordmd5 = md5($password);
$addressmd5 = md5($address);

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

//check if username taken
$checkValid = "SELECT id FROM Info WHERE username = '$username'";
$result = $conn->query( $checkValid );
if( $result->num_rows > 0 ) {
    //TODO change redirection
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Username Taken')
    window.location.href='index.html';
    </SCRIPT>");

    die();
    exit();
}

//check if email taken
$checkValid = "SELECT id FROM Info WHERE email = '$email'";
$result = $conn->query( $checkValid );
if( $result->num_rows > 0 ) {
    //TODO change redirection
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Email Taken')
    window.location.href='index.html';
    </SCRIPT>");

    die();
    exit();
}

//Insert info if no errors, initialize their package and service list
$register = "INSERT INTO Info ( id, username, password, email, name, address, type )
VALUES ( NULL, '$username', '$passwordmd5', '$email', '$name', '$addressmd5', '$type' )";
/*$package = "INSERT INTO PackageList ( username )
VALUES ( '$username' )";*/

$conn->query($register);
//$conn->query($service);


//Alert registration successful
echo ("<SCRIPT LANGUAGE='JavaScript'>
window.alert('Registration Successful!')
window.location.href='index.html';
</SCRIPT>");

?>

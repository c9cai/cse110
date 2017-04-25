<?php
$username1 = $_POST['username'];
$balance = $_POST['balance'];
$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'UserInfo';

//create connection
$conn =  @mysqli_connect($servername, $username, $password, $dbname) or die('Cannot connect to server');

$add = "UPDATE Info SET threshold='$balance' WHERE username='$username1'";

if( $conn->query( $add ) == TRUE )
{
    echo "<br>Threshold Changed";
} else {
    echo "<br>Threshold Not Changed";
}

?>

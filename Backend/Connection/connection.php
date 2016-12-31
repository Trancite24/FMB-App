<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 12/1/2016
 * Time: 2:31 PM
 *
 * This class is used to connect to the Database
 */



// Create connection
$conn = new mysqli('localhost', 'root', 'ijse', 'findmybus');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
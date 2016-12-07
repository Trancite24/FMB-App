<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 12/1/2016
 * Time: 2:31 PM
 *
 * This class is used to connect to the Local Host
 */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "busdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 12/1/2016
 * Time: 2:36 PM
 */

error_reporting(0);
header('Content-Type: application/json');

include './connectionLocalHost.php';

$sql = "SELECT * from busdb.routes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<br> id: ". $row["start"]. " - Name: ". $row["destination"]. "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>
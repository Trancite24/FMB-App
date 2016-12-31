<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 12/14/2016
 * Time: 9:36 AM
 */

include '../Connection/connection.php';

$start = $_GET['route_no'];

//get routes name
$query = "SELECT route_table_name FROM bus_route WHERE route_no=$start";
$result = $conn->query($query);

$tableName="";
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $tableName = $row['route_table_name'];
    }
}

//get routes name
$query = "SELECT halt_one FROM $tableName";
$result = $conn->query($query);

$haltList = array();
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        array_push($haltList , $row['halt_one']);
    }
}
echo $_GET['callback']."(".(json_encode($haltList)).")";

?>
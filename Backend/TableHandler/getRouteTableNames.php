<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 12/4/2016
 * Time: 6:05 PM
 *
 * This file will return the route table names
 */
include '../Connection/connection.php';

//get routes name
$query = "SELECT route_table_name FROM bus_route";
$result = $conn->query($query);

//create an array for tables
$tableList = array();

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {

        array_push($tableList , $row['route_table_name']);

    }
}





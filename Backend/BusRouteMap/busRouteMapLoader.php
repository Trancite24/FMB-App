<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 12/6/2016
 * Time: 8:15 AM
 *
 * This file will load each route for each map
 */

include '../Connection/connection.php';

//$route_no = $_REQUEST['route_no'];
$route_no = $_GET['route_no'];
//create query to update the database
$query = "SELECT route_map FROM bus_route WHERE route_no='$route_no'";
//connect the query and retrieve the result
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo $_GET['callback']."(".(json_encode($row['route_map'])).")";
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 12/6/2016
 * Time: 8:15 AM
 *
 * This file will add the map routes of each bus route including waypoints
 */

include '../Connection/connection.php';

$data = $_REQUEST['mapdata'];
$route_no = $_REQUEST['route_no'];

//create query to update the database
$query = "UPDATE bus_route SET route_map='$data' WHERE route_no = '$route_no'";
//connect the query and retrieve the result
$result = $conn->query($finalQuery);
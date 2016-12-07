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

$route_no = $_REQUEST['route_no'];

//create query to update the database
$query = "SELECT route_map FROM bus_route WHERE route_no = '$route_no'";
//connect the query and retrieve the result
$result = $conn->query($finalQuery);
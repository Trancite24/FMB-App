<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 12/7/2016
 * Time: 9:38 PM
 */

include '../Connection/connection.php';

$route_no = $_REQUEST['route_no'];


$query = "SELECT * FROM bus_route WHERE route_no=$route_no";
$result = $conn->query($query);

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $route_map = $row["route_map"];
        $start_lat = $row["start_lat"];
        $start_long = $row["start_long"];
        $start = $row["start"];
        $destination = $row["destination"];
        $dest_lat = $row["dest_lat"];
        $dest_long = $row["dest_long"];
    }

} else {
    die("failed");
}
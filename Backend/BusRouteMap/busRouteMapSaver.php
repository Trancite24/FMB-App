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

$route_map = $_REQUEST['route_map'];
$start_lat = $_REQUEST['start_lat'];
$start_long = $_REQUEST['start_long'];
$start = $_REQUEST['start'];
$destination = $_REQUEST['destination'];
$route_no = $_REQUEST['route_no'];
$dest_lat= $_REQUEST['dest_lat'];
$dest_long = $_REQUEST['dest_long'];

$route_no = 2;

$query = "SELECT * FROM bus_route WHERE route_no=$route_no";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $query = "UPDATE bus_route SET route_map='$route_map', 
                            start_lat='$start_lat',
                            start_long='$start_long',
                            start='$start',
                            destination='$destination',
                            dest_lat='$dest_lat',
                            dest_long='$dest_long'
              WHERE route_no = '$route_no'";
    $result = $conn->query($query);
    if ($result){
        die("updated");
    }
    die("failed");
} else {
    $query = "INSERT INTO bus_route (route_map,start_lat, start_long , start,
                          destination ,dest_lat , dest_long , route_no )
                          VALUES 
                            ('$route_map','$start_lat',
                            '$start_long','$start',
                            '$destination','$dest_lat',
                            '$dest_long','$route_no')";

    $result = $conn->query($query);
    if ($result){
        die("updated");
    }
    die("failed");
}
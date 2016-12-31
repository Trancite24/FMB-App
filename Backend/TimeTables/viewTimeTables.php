<?php
include '../Connection/connection.php';

$start = $_GET['start'];
$end = $_GET['end'];
$route_no = $_GET['route_no'];

$timetable_name = 'r0'.$route_no.'_'.strtolower ($start).'_'.strtolower($end).'_timetable';
//r02_galle_colombo_timetable

//get route name
$query = "SELECT * FROM `$timetable_name`";
$result = $conn->query($query);

$resultArray = array();
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $resultArray[] = $row;
    }
}

echo $_GET['callback']."(".(json_encode($resultArray)).")";


?>
<?php
include '../Connection/connection.php';

//get routes name
$query = "SELECT route_no,start,destination FROM bus_route";
$result = $conn->query($query);

$resultArray = array();
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $resultArray[] = $row['route_no'].' '.$row['start'].'-'.$row['destination'];
    }
}

echo $_GET['callback']."(".(json_encode($resultArray)).")";

?>
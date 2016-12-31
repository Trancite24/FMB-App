<?php
error_reporting(0);
header('Content-Type: application/json');

include '../Connection/connection.php';
include '../TableHandler/getRouteTableNames.php';

$start = $_GET['start'];
$destination = $_GET['destination'];
$start_lat_lon = get_lat_long($start);
$destination_lat_lon = get_lat_long($destination);

$routeNumberList = array();

foreach ($tableList as $tableName) {
    //get routes name
    $query = "SELECT halt_one, halt_two, route_id FROM `$tableName`";
    $result = $conn->query($query);

    $route_no = "";
    $locationArray = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $route_no = $row['route_id'];
            if (!in_array($row['halt_one'] , $locationArray)){
                array_push($locationArray , $row['halt_one']);
            }
            if (!in_array($row['halt_two'] , $locationArray)){
                array_push($locationArray , $row['halt_two']);
            }
        }
    }
    if (in_array($start , $locationArray) and in_array($destination , $locationArray)){
        array_push($routeNumberList , $route_no);
    }

}

$currently_moving_buses = array();

//reading URL
$url = "http://203.189.65.205/master/uom/vehlstjson.php";
$data = file_get_contents($url);
$obj = json_decode($data);

//current time
date_default_timezone_set('Asia/Colombo');
$current_time = date('Y-m-d H:i:s', time());

//filtering for most latest details of buses
for ($i = 0; $i < count($obj->Vehicleinfo); $i++) {
    if ($obj->Vehicleinfo[$i] != NULL) {
        $vehicle_info = $obj->Vehicleinfo[$i];

        if ($vehicle_info->RouteNo != NULL && $vehicle_info->latitude != NULL) {
            $bus_time = $vehicle_info->time->date;
            $diff = strtotime($current_time)-strtotime($bus_time);

            if($diff <= 180){
                //checking buses in related routes
                foreach($routeNumberList as $route_number){
                    $formatted_route_no = preg_replace('/\s+/', '', $vehicle_info->RouteNo);
                    if($formatted_route_no == $route_number){

                        $timeToArrive = getTime($vehicle_info->latitude, $start_lat_lon[0], $vehicle_info->logitude, $start_lat_lon[1]);
                        $timeToDestination = getTime($start_lat_lon[0], $destination_lat_lon[0], $start_lat_lon[1], $destination_lat_lon[1]);
                        $distance = real_distance($start_lat_lon[0], $start_lat_lon[1], $vehicle_info->latitude, $vehicle_info->logitude);
                        $now_at = location($vehicle_info->latitude, $vehicle_info->logitude);
                        $vehicle_info->timeToArrive = $timeToArrive;
                        $vehicle_info->timeToDestination = $timeToDestination;
                        $vehicle_info->distance  = $distance;
                        $vehicle_info->now_at  = $now_at;
                        $vehicle_info->route_no = $route_number;
                        $currently_moving_buses[] = $vehicle_info;
                    }
                }
            }
        }
    }
}

echo $_GET['callback']."(".(json_encode($currently_moving_buses)).")";

function getTime($lat1, $lat2, $long1, $long2) {
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&language=en-US&key=AIzaSyDq1_JABbF4d85yAUh1psNLxN0xNHyU3rA";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

    return $time;
}

function location($lat1, $lon1) {    #function to find the bus location in texual form
    $address = "";
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat1 . ',' . $lon1.'&key=AIzaSyDq1_JABbF4d85yAUh1psNLxN0xNHyU3rA';
    $data = file_get_contents($url);
    $data = utf8_decode($data);
    $obj = json_decode($data);
    $address.= $obj->results[0]->formatted_address;
    return $address;
}

function real_distance($lat1, $lon1, $lat2, $lon2) {
    $url_new = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $lat1 . ',' . $lon1 . '&destinations=' . $lat2 . ',' . $lon2 . '&mode=driving&language=en&sensor=false&key=AIzaSyDq1_JABbF4d85yAUh1psNLxN0xNHyU3rA';
    $dat = file_get_contents($url_new);
    $dat = utf8_decode($dat);
    $ob = json_decode($dat);

    return ($ob->rows[0]->elements[0]->distance->text); //km
}

function get_lat_long($address) {
    $latlng = array();

    $address = str_replace(" ", "+", $address);

    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=AIzaSyDq1_JABbF4d85yAUh1psNLxN0xNHyU3rA");
    $json = json_decode($json);

    $latlng[] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $latlng[] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

    return $latlng;
}



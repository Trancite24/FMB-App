<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 12/6/2016
 * Time: 4:03 PM
 */

include '../TableHandler/getRouteTimeTableNames.php';

$routeArray = array();




foreach ($timeTableList as &$name) {
    $finalQuery .= 'SELECT route_id ,halt_one , halt_two, time FROM ' . $name;
    //if there more tables to be joined
    if ($currentCount < count($tableList)) {
        $finalQuery .= ' UNION ';
    }
    $currentCount += 1;
}
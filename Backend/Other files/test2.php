<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 12/13/2016
 * Time: 9:15 PM
 */

ini_set("allow_url_fopen", 1);

$json = file_get_contents('http://203.189.65.205/master/uom/vehlstjson.php');
$obj = json_decode($json);
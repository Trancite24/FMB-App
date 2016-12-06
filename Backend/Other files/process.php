<?php
/**
 * Created by PhpStorm.
 * User: ASUS-PC
 * Date: 12/1/2016
 * Time: 6:58 PM
 */

ob_start(); header('Cache-Control: no-store, no-cache, must-revalidate');

mysql_connect('localhost','root','');
mysql_select_db('busdb');

$data = $_REQUEST['mapdata'];



    $query = "UPDATE busdb.mapdir SET value='$data'";
    if(mysql_query($query))die('bien');
    die(mysql_error());




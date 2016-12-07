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


    $query = "select value from mapdir";
    if(!($res = mysql_query($query)))die(mysql_error());
    $rs = mysql_fetch_array($res,1);
    die($rs['value']);


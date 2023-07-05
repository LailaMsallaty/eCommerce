<?php

$dsn='mysql:host=localhost;dbname=shop';          // Data source name
$user='root';
$pass='';
$option= array (
PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',


);

try{
$conn=new PDO($dsn,$user,$pass,$option);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//echo 'You are connected weloome to Database';

}
catch(PDOException $e)
{

echo 'failed to connect'.$e->getmessage();

}

?>
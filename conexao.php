<?php 
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'tp_financas';

$mysqli = new mysqli($hostname, $username, $password, $database);
if($mysqli->connect_errno){
    die("Falha ao conectar ao SQL: ".$mysqli->error);
}
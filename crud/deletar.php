<?php
ini_set("display_errors",'1');
error_reporting(E_ALL);


require_once __DIR__ . "/../framework/persistencia.php";

$fwk = new Persistencia(new PDO(
    "mysql:host=localhost;dbname=fwkPersistencia;charset=utf8mb4",
    'root',
    'bancodedados'
));

$id = $_GET["id"];


$fwk->delete($id,"numero");


header("location: ../index.php");
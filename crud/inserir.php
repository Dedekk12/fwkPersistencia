<?php
ini_set("display_errors",'1');
error_reporting(E_ALL);


require_once __DIR__ . "/../framework/persistencia.php";
require_once __DIR__ . "/../entidades/Numero.php";

$fwk = new Persistencia(new PDO(
    "mysql:host=localhost;dbname=fwkPersistencia;charset=utf8mb4",
    'root',
    'bancodedados'
));

if (isset($_POST["numeral"])) {
    $numeral = $_POST["numeral"];


    $numero = new Numero();
    $numero->numeral = $numeral;
    $numero->valor = $numeral;

    $fwk->save($numero);

    header("location: ../index.php");
}


$tituloForm = "Inserir";
require_once __DIR__ . "/../include/form.php";
?>


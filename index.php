<?php
require_once __DIR__ . "/framework/persistencia.php";


require_once __DIR__ . "/include/head.php";
?>

<h1>CRUD Persistencia FWK : </h1>




<?php
ini_set("display_errors",'1');
error_reporting(E_ALL);


$fwk = new Persistencia(new PDO(
    "mysql:host=localhost;dbname=fwkPersistencia;charset=utf8mb4",
    'root',
    'bancodedados'
));

$lista = $fwk->listAll("numero");
echo "<h2>Lista </h2>"; 
foreach ($lista as $key) {

    echo "<hr>ID : " . $key->id . "<br>NUMERAL : ". $key->numeral . "<br>VALOR : " . $key->valor . "<br>";
    echo "<a href=\"crud/atualizar.php?id={$key->id}\">Update</a><br>";
    echo "<a href=\"crud/deletar.php?id={$key->id}\">Deletar</a><br><hr>";
}

?>

<h3><a href="crud/inserir.php">Inserir</a></h3>
<br>

<?php

require_once __DIR__ . "/include/footer.php";
?>
<?php
require_once __DIR__ . "/head.php";
?>


<h1>FORMULARIO <?= $tituloForm ?></h1>

<form action="" method="post">
    <label for="numeral">Numeral</label>
    <br>
    <input name="numeral" type="number">
    <br>
    <button>Salvar</button>
</form>

<a href="../index.php">Retornar</a>

<?php
require_once __DIR__ . "/footer.php";
?>




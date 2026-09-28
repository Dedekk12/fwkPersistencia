<?php
require_once (__DIR__ . "/../Atributos/Tabela.php");
require_once (__DIR__ . "/../Atributos/Coluna.php");

#[Tabela(nome:"numero")]
class Numero
{
    #[Coluna]
    public $id = null;

    #[Coluna]
    public $numeral;

    #[Coluna]
    public $valor;

}
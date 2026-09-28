<?php

#[Attribute(Attribute::TARGET_PROPERTY)]
class Coluna{
    public function __construct(public ?string $nome) {}
}

//Coluna irá gerar um vetor contendo o nome de cada coluna da tabela no banco
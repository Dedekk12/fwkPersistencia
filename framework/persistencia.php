<?php


require_once(__DIR__ . "/../Atributos/Tabela.php");
require_once(__DIR__ . "/../Atributos/Coluna.php");
require_once(__DIR__ . "/../entidades/Numero.php");

class Persistencia
{

    public function __construct(private PDO $pdo) {}



    public function save(object $objeto): void
    {
        $tabela = $this->getNomeTabela($objeto);

        $dados = $this->getDadosColunas($objeto);
        $dadosFiltados = array_filter($dados, fn($v) => $v !== null); //Importante compreender arrow function e callback !!! 
        $colunas = array_keys($dadosFiltados);

        $stringColunas = implode(", ", $colunas);
        $placeholders = ":" . implode(", :", $colunas);

        $sql = "INSERT INTO  `{$tabela}` ({$stringColunas}) VALUE ($placeholders)";
        $stm = $this->pdo->prepare($sql);
        $stm->execute($dadosFiltados);

        //return ["sql" => $sql, "parametros" => $dadosFiltados];
    }

    public function update(int $id,object $objeto): void
    {
        $tabela = $this->getNomeTabela($objeto);

        $dados = $this->getDadosColunas($objeto);
        $dadosFiltados = array_filter($dados, fn($v) => $v !== null); //Importante compreender arrow function e callback !!! 
        $sets = "";

        foreach ($dadosFiltados as $key => $value) {
            $sets .= $key . "=" . $value . ",";
        }
        

        $sets = substr_replace($sets,"",-1);

        $sql = "UPDATE `{$tabela}`  SET {$sets} WHERE `{$tabela}`.id = :id";

        $stm = $this->pdo->prepare($sql);
        $stm->execute([":id" => $id]);

        //return ["sql" => $sql, "parametros" => $dadosFiltados];
    }


    public function delete(int $id, string $classe): void
    {
        $tabela = $this->getNomeTabela($classe);
        $sql = "DELETE FROM {$tabela} WHERE {$tabela}.id = :id";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([":id" => $id]);
    }



    //listagem
    public function listAll(string $classe): array
    {
        $tabela = $this->getNomeTabela($classe);
        $sql = "SELECT * FROM {$tabela}";
        $stm = $this->pdo->query($sql);
        return $stm->fetchAll(PDO::FETCH_CLASS, $classe);
    }



    //Adquirindo Nome das [Tabela] etiquetada
    private function getNomeTabela(object|string $objetoOuString): string
    {
        $espelho = new ReflectionClass($objetoOuString);
        $etiquetas = $espelho->getAttributes(Tabela::class); // Retorna o nome e demais atributos da classe Tabela ([Tabela::class])
        $etiquetaTabela = $etiquetas[0]->newInstance(); //Como só existe uma etiqueta tabela o indice 0 se mostra ideal.

        return $etiquetaTabela->nome;
    }


    private function getDadosColunas(object $objeto): array
    {
        $espelho = new ReflectionClass($objeto);
        $dados = [];
        foreach ($espelho->getProperties() as $propriedade) //As propriedas de espelho é toda aquela que tem a etiqueta [Coluna] ou seja ([nome],[id],[email])
        {
            $etiquetas = $propriedade->getAttributes(Coluna::class); // Adquire os atributos da coluna (nome : public);
            if (empty($etiquetas)) {
                continue;
            }

            $nomeColuna = $propriedade->getName();
            $valor = $propriedade->getValue($objeto);
            $dados[$nomeColuna] = $valor;
        }

        return $dados;
    }
}

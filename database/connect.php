<?php
$host = "192.168.10.72";
$dbname = "liga_pereba";
$user = "timas";
$pass = "timas";

try {
    $conexao = new PDO(
        "pgsql:host=$host;dbname=$dbname",
        $user,
        $pass
    );

    return $conexao;
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

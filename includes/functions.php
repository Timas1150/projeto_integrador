<?php
require_once __DIR__ . '/../database/connect.php';

function cadastra_time($conexao, $nome_clube, $temporada, $historia_temporada, $escudo_url, $usuario_id)
{
    $sql = "INSERT INTO times_historicos (nome_clube, temporada, historia_temporada, escudo_url, usuario_id) 
            VALUES (:nome_clube, :temporada, :historia_temporada, :escudo_url, :usuario_id)";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":nome_clube", $nome_clube);
        $stmt->bindParam(":temporada", $temporada);
        $stmt->bindParam(":historia_temporada", $historia_temporada);
        $stmt->bindParam(":escudo_url", $escudo_url);
        $stmt->bindParam(":usuario_id", $usuario_id);

        return $stmt->execute();
    } catch (PDOException $e) {
        return "Erro no banco: " . $e->getMessage();
    }
}

function listar_times($conexao)
{
    $sql = "SELECT id, nome_clube, temporada, historia_temporada, escudo_url FROM times_historicos ORDER BY criado_em DESC";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function consultar_time($conexao, $nome = '')
{
    $nome = trim($nome);

    if (!empty($nome)) {
        $sql = "SELECT * FROM times_historicos WHERE LOWER(nome_clube) LIKE LOWER(?) ORDER BY id DESC";
        $stmt = $conexao->prepare($sql);
        $stmt->execute(["%$nome%"]);
    } else {
        $sql = "SELECT * FROM times_historicos ORDER BY id DESC";
        $stmt = $conexao->query($sql);
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


//Funções para login:

function cadastra_user($conexao, $nome, $email, $senha)
{
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senhaHash);

        return $stmt->execute();
    } catch (PDOException $e) {
        if ($e->getCode() == '23505') {
            return "Este e-mail já está cadastrado!";
        }
        return "Erro ao realizar o cadastro.";
    }
}

function login_user($conexao, $email, $senha)
{

    $sql = "SELECT id, nome, email, senha, perfil FROM usuarios WHERE email = :email";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return false;
    }
}

// PARA ADMINISTRADORES:

// Função para deletar os times

function deletar_time($conexao, $id)
{
    $sql = "DELETE FROM times_historicos WHERE id = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    return $stmt->execute();
}

// Função para consultar o time sendo admin:

function consultar_time_por_id($conexao, $id)
{
    $sql = "SELECT * FROM times_historicos WHERE id = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna só 1 time
}

// Função para atualizar times
function atualizar_time($conexao, $id, $nome_clube, $temporada, $historia_temporada, $escudo_url)
{
    $sql = "UPDATE times_historicos 
            SET nome_clube = :nome_clube, 
                temporada = :temporada, 
                historia_temporada = :historia_temporada, 
                escudo_url = :escudo_url 
            WHERE id = :id";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":nome_clube", $nome_clube);
        $stmt->bindParam(":temporada", $temporada);
        $stmt->bindParam(":historia_temporada", $historia_temporada);
        $stmt->bindParam(":escudo_url", $escudo_url);

        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }
}
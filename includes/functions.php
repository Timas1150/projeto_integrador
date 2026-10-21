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

function apagar($conexao, $id)
{
    $sql = "DELETE FROM alunos WHERE id = :id";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        echo "Usuário $id removido com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function consultar($conexao, $id)
{

    $sql = "SELECT nome,turma,nasc,ativo FROM alunos WHERE id = :id";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $aluno = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "Aluno: {$aluno['nome']} <br>";
        echo "Turma: {$aluno['turma']}<br>";
        echo "Nasc: {$aluno['nasc']}<br>";
        echo "Ativo: {$aluno['ativo']}";
    } catch (PDOException $e) {
        echo "ERRO: " . $e->getMessage();
    }
}

function atualizar($conexao, $id, $nome, $turma, $email, $nasc, $ativo,)
{

    $sql = "UPDATE alunos SET nome = :nome, turma = :turma, email = :email, nasc = :nasc, ativo = :ativo WHERE id = :id";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":turma", $turma);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":nasc", $nasc);
        $stmt->bindParam(":ativo", $ativo);

        $stmt->execute();
        echo "Aluno atualizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
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

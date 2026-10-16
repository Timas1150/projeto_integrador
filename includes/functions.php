<?php
require_once __DIR__ . '/../database/connect.php';

function cadastrar($conexao, $nome, $turma, $nasc, $ativo, $email)
{

    $sql = "INSERT INTO alunos (nome, turma, nasc, ativo, email) VALUES (:nome, :turma, :nasc, :ativo, :email)";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":turma", $turma);
        $stmt->bindParam(":nasc", $nasc);
        $stmt->bindParam(":ativo", $ativo);
        $stmt->bindParam(":email", $email);

        $stmt->execute();
        echo "Aluno inserido com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function relatorio($conexao)
{
    $sql = "SELECT * FROM alunos ORDER BY id ";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($alunos as $aluno) {
            echo "ID: . {$aluno['id']} . <br>";
            echo "Nome: . {$aluno['nome']} . <br>";
            echo "Turma: . {$aluno['turma']} . <br>";
            echo "Data de Nascimento: . {$aluno['nasc']} . <br>";
            echo "Ativo: . {$aluno['ativo']} . <br>";
            echo "Email: . {$aluno['email']} . <br><br>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
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

function cadastra_user($conexao, $email, $senha)
{
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (email, senha) VALUES (:email, :senha)";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senhaHash);

        $stmt->execute();
        echo "Usuário inserido com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function login_user($conexao, $email, $senha)
{

    $sql = "SELECT id, email, senha FROM usuarios WHERE email = :email";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }else{

        return false;
        }
    } catch (PDOException $e) {
        return false;
    }
}

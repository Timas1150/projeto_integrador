<?php require_once __DIR__ . '/../includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main style="background-color: black;">
        <h3 style="font-family: 'Times New Roman', Times, serif;">SISTEMA DE LOGIN</h3>
        <form action="" method="post">
            <label for="nome">E-mail: </label> <br>
            <input type="text" name="email" id="email"><br>
            <label for="senha">Senha: </label> <br>
            <input type="password" name="senha" id="senha"><br>
            <a href="/login/esqueceu.php">Esqueceu a senha?</a> <br>
            <input type="submit" value="Enviar">
            <input type="reset" value="Limpar"> <br>
            <a style="font-family: Verdana, Geneva, Tahoma, sans-serif;" href="/login/cadastrar.php">Não tem uma conta? Crie uma</a>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $usuario = consulta_user($conexao, $_POST['email']);
            if ($usuario['email'] == $_POST['email'] && $usuario['senha'] == $_POST['senha']) {
                    session_start();
                    $_SESSION['id'] = $usuario['id'];
                    header("Location: ../index.php");
                    exit();
            } else {
                    echo "Hmm tem alguma coisa errada";
            }
        }
        ?>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
<?php require_once __DIR__ . '/../includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir senha</title>
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
        <h3 style="font-family: 'Times New Roman', Times, serif;">REDEFINIR SENHA</h3>
        <form action="" method="post">
            <label for="nome">E-mail: </label> <br>
            <input type="text" name="email" id="email"><br>
            <label for="senha">Nova senha: </label> <br>
            <input type="password" name="senha" id="senha"><br>
            <input type="submit" value="Enviar">
            <input type="reset" value="Limpar">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            cadastra_user($conexao, $_POST['email'], $_POST['senha']);
            header("Location: ../index.php");
            exit();
        }
        ?>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
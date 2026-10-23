<?php require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../database/connect.php';
$mensagem_de_erro = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $resultado = cadastra_user($conexao, $nome, $email, $senha);

    if ($resultado === true) {

        header("Location: /projeto_integrador/login.php");
        exit();
    } else {
        $mensagem_de_erro = $resultado;
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>

        <h3 style="font-family: 'Times New Roman', Times, serif;">CADASTRE-SE</h3>
        <form action="" method="post">
            <label for="nome">Nome: </label><br>
            <input type="text" name="nome" id="nome"><br>
            <label for="email">E-mail: </label> <br>
            <input type="email" name="email" id="email"><br>
            <label for="senha">Senha: </label> <br>
            <input type="password" name="senha" id="senha"><br>
            <label for="confirmar_senha">Confirmar senha: </label> <br>
            <input type="password" name="confirmar_senha" id="confirmar_senha"><br>
            <input type="submit" value="Criar conta">
            <?php if (!empty($mensagem_de_erro)): ?>
                <p style="color: red;"><?= $mensagem_de_erro; ?></p>
            <?php endif; ?>

        </form>
    </main>
    <?php include __DIR__ . '/projeto_integrador/includes/footer.php'; ?>
</body>

</html>
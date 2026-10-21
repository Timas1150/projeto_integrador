<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../database/connect.php';

if (isset($_SESSION['usuario_id'])) {
    header("Location: ../app/select.php");
    exit();
}
$mensagem_de_erro = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") { 
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $usuario = login_user($conexao, $email, $senha);

    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_perfil'] = $usuario['perfil'];
        $_SESSION['perfil'] = $usuario['perfil'];

        header("Location: ../index.php");
        exit(); 
    } else {
        $mensagem_de_erro = "E-mail ou senha incorretos!";
    }
} 
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main style="background-color: black;">
        <h3 style="font-family: 'Times New Roman', Times, serif;">SISTEMA DE LOGIN</h3>
        <form action="" method="post">
            <label for="email">E-mail: </label> <br>
            <input type="email" name="email" id="email"><br>
            <label for="senha">Senha: </label> <br>
            <input type="password" name="senha" id="senha" required><br>
            <a href="/login/esqueceu.php">Esqueceu a senha?</a> <br>
            <input type="submit" value="Enviar">
            <input type="reset" value="Limpar"> <br>
            <a style="font-family: Verdana, Geneva, Tahoma, sans-serif;" href="/login/cadastrar.php">Não tem uma conta? Crie uma</a>

            <?php if (!empty($mensagem_de_erro)): ?>
                <p style="color: red;"><?= $mensagem_de_erro; ?></p>
            <?php endif; ?>
        </form>


    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../database/connect.php';
require_once __DIR__ . '/../login/verifica_user.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $temporada = $_POST['temporada'] ?? '';
    $historia = $_POST['historia'] ?? '';
    $escudo_url = $_POST['escudo_url'] ?? '';
    $usuario_id = $_SESSION['usuario_id'] ?? null;

    $resultado = cadastra_time($conexao, $nome, $temporada, $historia, $escudo_url, $usuario_id);

    if ($resultado === true) {
        header("Location: select.php");
        exit();
    } else {
        $mensagem = $resultado;
    }
}
?>

</html>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
        <h1>Cadastrar Time Histórico</h1>

        <?php if (!empty($mensagem)): ?>
            <p style="color: red;"><?= $mensagem; ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <label for="nome">Nome do Time: </label><br>
            <input type="text" name="nome" id="nome" placeholder="Ex: Milan" required><br>

            <label for="temporada">Temporada / Ano: </label><br>
            <input type="text" name="temporada" id="temporada" placeholder="Ex: 2006/07" required><br>

            <label for="historia">História / Narrativa do Esquadrão: </label><br>
            <textarea name="historia" id="historia" rows="6" cols="40" required></textarea><br><br>

            <label for="escudo_url">URL do Escudo / Imagem: </label><br>
            <input type="url" name="escudo_url" id="escudo_url" placeholder="https://exemplo.com/escudo.png"><br>

            <input type="submit" value="Cadastrar Time">
            <input type="reset" value="Limpar">
        </form>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
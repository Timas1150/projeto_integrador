<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../database/connect.php';
require_once __DIR__ . '/../login/verifica_user.php';

// 1. Pega o ID da URL
$id = $_GET['id'] ?? null;

// Se não tiver ID ou não for admin, volta pro select.php
if (!$id || !isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'admin') {
    header("Location: select.php");
    exit();
}

// 2. Quando o formulário for enviado (Salvar Alterações)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome_clube'] ?? '';
    $temporada = $_POST['temporada'] ?? '';
    $historia = $_POST['historia_temporada'] ?? '';
    $escudo = $_POST['escudo_url'] ?? '';

    atualizar_time($conexao, $id, $nome, $temporada, $historia, $escudo);

    header("Location: select.php");
    exit();
}

// 3. Busca os dados do time para preencher os campos
$time = consultar_time_por_id($conexao, $id);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main>
        <h2>Editar</h2>

        <form action="" method="POST">
            <label>Nome do Clube:</label><br>
            <input type="text" name="nome_clube" value="<?= $time['nome_clube']; ?>" required><br><br>

            <label>Temporada:</label><br>
            <input type="text" name="temporada" value="<?= $time['temporada']; ?>" required><br><br>

            <label>URL do Escudo:</label><br>
            <input type="text" name="escudo_url" value="<?= $time['escudo_url']; ?>"><br><br>

            <label>História:</label><br>
            <textarea name="historia_temporada" rows="5" required><?= $time['historia_temporada']; ?></textarea><br><br>

            <button type="submit">Salvar Alterações</button>
            <a href="select.php">Cancelar</a>
        </form>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
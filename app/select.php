<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../database/connect.php';
require_once __DIR__ . '/../login/verifica_user.php';

$termo_busca = $_GET['busca'] ?? '';

$times = consultar_time($conexao, $termo_busca);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar o time</title>
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
        <h2>Times</h2>
        <form action="select.php" method="GET" style="margin-bottom: 20px;">
            <input type="text" name="busca" placeholder="Digite o nome do clube..." value="<?= htmlspecialchars($termo_busca); ?>">
            <button type="submit">Pesquisar</button>
        </form>

        <?php foreach ($times as $time): ?>
            <div>
                <?php if (!empty($time['escudo_url'])): ?>
                    <img src="<?= $time['escudo_url']; ?>" alt="Escudo" width="50"><br>
                <?php endif; ?>


                <h3><?= $time['nome_clube']; ?> - <?= $time['temporada']; ?></h3>
                <p><?= $time['historia_temporada']; ?></p>
            </div>
            <hr>
        <?php endforeach; ?>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../database/connect.php';
require_once __DIR__ . '/../login/verifica_user.php';

$times = listar_times($conexao);
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
        <h2>Times Cadastrados</h2>

        <?php foreach ($times as $time): ?>
            <div>
                <?php if (!empty($time['escudo_url'])): ?>
                    <img src="<?= htmlspecialchars($time['escudo_url']); ?>" alt="Escudo <?= htmlspecialchars($time['nome_clube']); ?>" style="max-width: 70px; height: auto;"><br>
                <?php endif; ?>


                <h3><?= $time['nome_clube']; ?> - <?= $time['temporada']; ?></h3>
                <p><?= $time['historia_temporada']; ?></p>
                <a href="ver_time.php?id=<?= $time['id']; ?>">Ver detalhes</a>
            </div>
            <hr>
        <?php endforeach; ?>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
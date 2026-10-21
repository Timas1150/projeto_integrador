<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <img src="/includes/download.png" alt="">
    <nav>
        <div>
            <a href="../index.php">Home</a>

            <?php if (isset($_SESSION['usuario_id'])): ?>
                <span>Olá, <?= $_SESSION['usuario_nome']; ?></span>

                <?php if ($_SESSION['usuario_perfil'] === 'admin'): ?>
                    <span>(Admin)</span>
                <?php endif; ?>

                <a href="../app/create.php">Cadastrar Time</a>
                <a href="../login/logout.php">Sair</a>
                <a href="../app/select.php">Ver time</a>
            <?php else: ?>
                <a href="../login/login.php">Entrar</a>
                <a href="../login/cadastrar.php">Criar Conta</a>
            <?php endif; ?>

        </div>
    </nav>
</header>
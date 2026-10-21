<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="header-uefa">
    <div class="nav-container">
        <a href="/index.php" class="nav-logo">LIGA DOS PEREBA</a>

        <nav class="nav-menu">
            <a href="/index.php" class="nav-item">Home</a>
            <a href="/app/select.php" class="nav-item">Times</a>
            
            <!-- Mostra para qualquer pessoa logada -->
            <?php if (isset($_SESSION['usuario_id']) || isset($_SESSION['usuario_nome'])): ?>
                <a href="/app/create.php" class="nav-item btn-pill-uefa">Cadastrar Time</a>
            <?php endif; ?>
        </nav>

        <div class="user-nav-right">
            <?php if (isset($_SESSION['usuario_nome'])): ?>
                <span class="user-greeting">Olá, <?= $_SESSION['usuario_nome']; ?></span>
                <a href="/login/logout.php" class="profile-avatar">👤</a>
            <?php endif; ?>
        </div>
    </div>
</header>
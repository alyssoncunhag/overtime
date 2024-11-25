<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OVERTIME - Área Administrativa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css"> <!-- Linkando o CSS -->
</head>
<body>
    <?php
    session_start();
    include 'classes/usuarios.class.php';
    if (!isset($_SESSION['logado'])) {
        header("Location: login.php");
        exit;
    }

    $usuario = new Usuarios();
    $usuario->setUsuario($_SESSION['logado']);
    ?>

    <!-- Header -->
    <header>
        <h1>Bem-vindo à Área Administrativa da OVERTIME</h1>
        <p class="subtitle">Aqui você pode gerenciar todas as seções do site.</p>
    </header>

    <!-- Conteúdo principal -->
    <div class="main-content">
        <div class="button-container">
            <!-- Botões com base nas permissões do usuário -->
            <?php if ($usuario->temPermissoes("ADMIN")): ?>
                <button onclick="window.location.href='gestaoUsuario.php';">Gerenciar Usuários</button>
                <button onclick="window.location.href='gestaoCategoria.php';">Gerenciar Categorias</button>
                <button onclick="window.location.href='gestaoTime.php';">Gerenciar Times</button>
                <button onclick="window.location.href='gestaoTorneio.php';">Gerenciar Torneios</button>
                <button onclick="window.location.href='gestaoNoticia.php';">Gerenciar Notícias</button>
                <button onclick="window.location.href='gestaoJogo.php';">Gerenciar Jogos</button>
            <?php endif; ?>
        </div>

        <!-- Botão de sair -->
        <button class="logout-btn" onclick="window.location.href='sair.php';">SAIR</button>
    </div>

    <!-- Footer -->
    <footer>
        <p>© 2024 OVERTIME. Todos os direitos reservados. <a href="sobre.php">Sobre Nós</a> | <a href="contato.php">Contato</a></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

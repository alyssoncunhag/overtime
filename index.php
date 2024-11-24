<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OVERTIME - Área Administrativa</title>
    <link rel="stylesheet" href="css/index.css"> <!-- Linkando o CSS -->
</head>
<body>
    <?php
    session_start();
    include 'classes/usuarios.class.php';
    if(!isset($_SESSION['logado'])){
        header("Location: login.php");
        exit;
    }

    $usuario = new Usuarios();
    $usuario->setUsuario($_SESSION['logado']);
    ?>

    <header>
        <h1>Bem-vindo à Área Administrativa da OVERTIME</h1>
        <p class="subtitle">Aqui você pode gerenciar todas as seções do site.</p>
    </header>
    
    <div class="button-container">
        <!-- Botões com base nas permissões do usuário -->
        <?php if($usuario->temPermissoes("ADMIN")): ?>
            <button onclick="window.location.href='gestaoUsuario.php';">Gerenciar Usuários</button>
            <button onclick="window.location.href='gestaoCategoria.php';">Gerenciar Categorias</button>
            <button onclick="window.location.href='gestaoTime.php';">Gerenciar Times</button>
            <button onclick="window.location.href='gestaoTorneio.php';">Gerenciar Torneios</button>
            <button onclick="window.location.href='gestaoNoticia.php';">Gerenciar Notícias</button>
            <button onclick="window.location.href='gestaoJogo.php';">Gerenciar Jogos</button>
        <?php endif; ?>
    </div>

    <button class="logout-btn" onclick="window.location.href='sair.php';">SAIR</button>
</body>
</html>

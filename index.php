<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Definição do charset da página como UTF-8, que permite o uso de caracteres especiais do português -->
    <meta charset="UTF-8">
    
    <!-- Definição da viewport para tornar a página responsiva em dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título da página que aparecerá na aba do navegador -->
    <title>OVERTIME - Área Administrativa</title>
    
    <!-- Inclusão do Bootstrap (CSS) para facilitar a criação de uma interface visual moderna e responsiva -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Link para o arquivo CSS personalizado da página -->
    <link rel="stylesheet" href="css/index.css"> <!-- Linkando o CSS -->
</head>
<body>

    <?php
    // Inicia a sessão para permitir o acesso à variável global $_SESSION
    session_start();

    // Inclui a classe Usuarios para manipulação de dados dos usuários
    include 'classes/usuarios.class.php';

    // Verifica se o usuário está logado, se não estiver, redireciona para a página de login
    if (!isset($_SESSION['logado'])) {
        header("Location: login.php");
        exit;
    }

    // Cria uma instância da classe Usuarios e define o usuário logado na sessão
    $usuario = new Usuarios();
    $usuario->setUsuario($_SESSION['logado']);
    ?>

    <!-- Cabeçalho da página -->
    <header>
        <h1>Bem-vindo à Área Administrativa da OVERTIME</h1>
        <p class="subtitle">Aqui você pode gerenciar todas as seções do site.</p>
    </header>

    <!-- Conteúdo principal da página -->
    <div class="main-content">
        
        <!-- Container de botões de navegação -->
        <div class="button-container">
            <!-- Verifica se o usuário tem permissões de administrador para exibir os botões -->
            <?php if ($usuario->temPermissoes("ADMIN")): ?>
                <!-- Botões que redirecionam para as páginas de gerenciamento de diferentes seções -->
                <button onclick="window.location.href='gestaoUsuario.php';">Gerenciar Usuários</button>
                <button onclick="window.location.href='gestaoCategoria.php';">Gerenciar Categorias</button>
                <button onclick="window.location.href='gestaoTime.php';">Gerenciar Times</button>
                <button onclick="window.location.href='gestaoTorneio.php';">Gerenciar Torneios</button>
                <button onclick="window.location.href='gestaoNoticia.php';">Gerenciar Notícias</button>
                <button onclick="window.location.href='gestaoJogo.php';">Gerenciar Jogos</button>
            <?php endif; ?>
        </div>

        <!-- Botão de logout, que redireciona para a página de logout -->
        <button class="logout-btn" onclick="window.location.href='sair.php';">SAIR</button>
    </div>

    <!-- Rodapé da página -->
    <footer>
        <p>© 2024 OVERTIME. Todos os direitos reservados. 
            <a href="sobre.php">Sobre Nós</a> | <a href="contato.php">Contato</a>
        </p>
    </footer>

    <!-- Inclusão do script Bootstrap (JavaScript) para funcionalidade do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Definição do charset para UTF-8, garantindo a exibição correta de caracteres especiais -->
    <meta charset="UTF-8">
    
    <!-- Definição da viewport para tornar a página responsiva em dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Título da página -->
    <title>OVERTIME - Login</title>
    
    <!-- Inclusão do Bootstrap (CSS) para facilitar a criação de uma interface moderna e responsiva -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Link para o arquivo CSS personalizado da página de login -->
    <link rel="stylesheet" href="css/login.css"> <!-- Linkando o CSS -->
</head>
<body>
    <?php
    // Inicia a sessão para manipulação de variáveis de sessão
    session_start();

    // Inclui a classe Usuarios que contém os métodos necessários para realizar o login
    require 'classes/usuarios.class.php';

    // Verifica se o formulário foi submetido com os campos 'email' e 'senha' preenchidos
    if (!empty($_POST['email']) && !empty($_POST['senha'])) {
        // Escapa as variáveis de entrada para evitar injeção de SQL
        $email = addslashes($_POST['email']);
        $senha = $_POST['senha']; // A senha será verificada usando password_verify (sem criptografia aqui)

        // Cria uma instância da classe Usuarios
        $usuarios = new Usuarios();
        
        // Verifica se o login é bem-sucedido
        if ($usuarios->fazerLogin($email, $senha)) {
            // Caso o login seja bem-sucedido, redireciona para a página principal
            header("Location: index.php");
            exit;
        } else {
            // Caso contrário, exibe uma mensagem de erro
            $erro = "Usuário e/ou senha incorretos!";
        }
    }
    ?>

    <!-- Cabeçalho da página -->
    <header>
        <h1>Login</h1>
        
        <!-- Exibe a mensagem de erro caso o login tenha falhado -->
        <?php if (isset($erro)): ?>
            <p class="error-message"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>
    </header>

    <!-- Container que envolve o formulário de login -->
    <div class="login-container">
        <form method="POST">
            <!-- Campo de entrada para o email -->
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required><br><br>

            <!-- Campo de entrada para a senha -->
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required><br><br>

            <!-- Link para recuperação de senha -->
            <div class="forgot-password">
                <a href="esqueceuSenha.php">Esqueceu sua senha? Clique aqui</a>
            </div>

            <!-- Botão de envio do formulário -->
            <button type="submit">Entrar</button>
        </form>
    </div>

    <!-- Inclusão do Bootstrap (JavaScript) para funcionalidade do framework -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

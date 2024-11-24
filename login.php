<?php
session_start();
require 'classes/usuarios.class.php';

if (!empty($_POST['email']) && !empty($_POST['senha'])) {
    $email = addslashes($_POST['email']);
    $senha = $_POST['senha']; // A senha será verificada usando password_verify, sem criptografia aqui.

    $usuarios = new Usuarios();
    if ($usuarios->fazerLogin($email, $senha)) {
        header("Location: index.php");
        exit;
    } else {
        $erro = "Usuário e/ou senha incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OVERTIME - Login</title>
    <link rel="stylesheet" href="css/login.css"> <!-- Linkando o CSS -->
</head>
<body>
    <header>
        <h1>Login</h1>
        <?php if (isset($erro)): ?>
            <p class="error-message"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>
    </header>

    <div class="login-container">
        <form method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required><br><br>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required><br><br>

            <div class="forgot-password">
                <a href="esqueceuSenha.php">Esqueceu sua senha? Clique aqui</a>
            </div>

            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>

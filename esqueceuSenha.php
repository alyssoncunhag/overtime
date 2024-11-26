<?php
session_start();
require 'classes/usuarios.class.php';

$mensagem = '';

if (!empty($_POST['email'])) {
    $email = addslashes($_POST['email']);
    $usuarios = new Usuarios();

    // Verifica se o e-mail está cadastrado
    if ($usuarios->existeEmail($email)) {  // Alterado de verificarEmail para existeEmail
        // Gera um token único
        $token = bin2hex(random_bytes(16));

        // Salva o token no banco de dados com validade de 1 hora
        if ($usuarios->salvarTokenSenha($email, $token)) {
            // Link de redefinição de senha
            $link = "http://localhost/overtime/redefinirSenha.php?token=" . $token;

            // Exibe o link diretamente, para teste local
            $mensagem = "Acesse o link para redefinir sua senha: <a href='" . htmlspecialchars($link) . "'>$link</a>";
        } else {
            $mensagem = "Erro ao salvar o token. Tente novamente.";
        }
    } else {
        $mensagem = "E-mail não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OVERTIME - Esqueceu sua senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <header>
        <h1>Esqueceu sua senha</h1>
        <?php if (!empty($mensagem)): ?>
            <p class="message"><?= $mensagem ?></p>
        <?php endif; ?>
    </header>

    <div class="login-container">
        <form method="POST">
            <label for="email">Digite seu e-mail cadastrado:</label>
            <input type="email" name="email" id="email" required><br><br>

            <button type="submit">Enviar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

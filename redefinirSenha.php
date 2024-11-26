<?php
session_start();
require 'classes/usuarios.class.php';

$mensagem = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $usuarios = new Usuarios();

    // Verifica se o token é válido
    $email = $usuarios->verificarTokenSenha($token);

    if ($email) {
        // O token é válido, exibe o formulário para redefinir a senha
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $novaSenha = $_POST['senha'];
            $confirmarSenha = $_POST['confirmar_senha'];

            if ($novaSenha === $confirmarSenha) {
                // Atualiza a senha no banco de dados
                if ($usuarios->redefinirSenha($email, $novaSenha)) {
                    // Limpa o token após a redefinição
                    $usuarios->limparTokenSenha($email);

                    // Mensagem de sucesso
                    $mensagem = "Senha alterada com sucesso! Você será redirecionado para a tela de login.";

                    // Redireciona após 3 segundos
                    header("refresh:3; url=login.php");
                    exit();
                } else {
                    $mensagem = "Erro ao alterar a senha. Tente novamente.";
                }
            } else {
                $mensagem = "As senhas não coincidem.";
            }
        }
    } else {
        $mensagem = "Token inválido ou expirado.";
    }
} else {
    $mensagem = "Token não fornecido.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OVERTIME - Redefinir Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <header>
        <h1>Redefinir Senha</h1>
        <?php if (!empty($mensagem)): ?>
            <p class="message"><?= $mensagem ?></p>
        <?php endif; ?>
    </header>

    <div class="login-container">
        <?php if (empty($mensagem)): ?>
            <form method="POST">
                <label for="senha">Nova senha:</label>
                <input type="password" name="senha" id="senha" required><br><br>

                <label for="confirmar_senha">Confirmar senha:</label>
                <input type="password" name="confirmar_senha" id="confirmar_senha" required><br><br>

                <button type="submit">Redefinir senha</button>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Inicia a sessão
session_start();
// Inclui a classe Usuarios que contém funções relacionadas ao usuário
require 'classes/usuarios.class.php';

// Inicializa a variável de mensagem, que será usada para exibir feedback ao usuário
$mensagem = '';

// Verifica se o token foi passado na URL (através de um GET)
if (isset($_GET['token'])) {
    $token = $_GET['token'];  // Recupera o token da URL
    $usuarios = new Usuarios();  // Cria uma instância da classe Usuarios

    // Verifica se o token é válido, chamando o método verificarTokenSenha da classe Usuarios
    $email = $usuarios->verificarTokenSenha($token);

    // Se o token for válido (retornar um e-mail associado), permite que o usuário redefina a senha
    if ($email) {
        // Verifica se o formulário foi enviado via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recupera os valores das senhas do formulário
            $novaSenha = $_POST['senha'];
            $confirmarSenha = $_POST['confirmar_senha'];

            // Verifica se a nova senha e a confirmação da senha são iguais
            if ($novaSenha === $confirmarSenha) {
                // Tenta atualizar a senha no banco de dados chamando o método redefinirSenha
                if ($usuarios->redefinirSenha($email, $novaSenha)) {
                    // Limpa o token após a redefinição de senha
                    $usuarios->limparTokenSenha($email);

                    // Define a mensagem de sucesso e redireciona o usuário após 3 segundos
                    $mensagem = "Senha alterada com sucesso! Você será redirecionado para a tela de login.";
                    header("refresh:3; url=login.php");  // Redireciona para a página de login após 3 segundos
                    exit();
                } else {
                    // Se ocorrer um erro ao tentar alterar a senha, exibe uma mensagem de erro
                    $mensagem = "Erro ao alterar a senha. Tente novamente.";
                }
            } else {
                // Se as senhas não coincidirem, exibe uma mensagem de erro
                $mensagem = "As senhas não coincidem.";
            }
        }
    } else {
        // Se o token for inválido ou expirado, exibe uma mensagem de erro
        $mensagem = "Token inválido ou expirado.";
    }
} else {
    // Se não foi fornecido um token na URL, exibe uma mensagem de erro
    $mensagem = "Token não fornecido.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OVERTIME - Redefinir Senha</title>
    <!-- Link para o CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link para o CSS customizado -->
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <!-- Cabeçalho da página -->
    <header>
        <h1>Redefinir Senha</h1>
        <!-- Se houver uma mensagem, exibe ela para o usuário -->
        <?php if (!empty($mensagem)): ?>
            <p class="message"><?= $mensagem ?></p>
        <?php endif; ?>
    </header>

    <div class="login-container">
        <!-- Se não houver mensagem (significa que o formulário pode ser enviado), exibe o formulário de redefinição de senha -->
        <?php if (empty($mensagem)): ?>
            <form method="POST">
                <!-- Campo para a nova senha -->
                <label for="senha">Nova senha:</label>
                <input type="password" name="senha" id="senha" required><br><br>

                <!-- Campo para confirmar a nova senha -->
                <label for="confirmar_senha">Confirmar senha:</label>
                <input type="password" name="confirmar_senha" id="confirmar_senha" required><br><br>

                <!-- Botão para submeter o formulário -->
                <button type="submit">Redefinir senha</button>
            </form>
        <?php endif; ?>
    </div>

    <!-- Link para o JavaScript do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
session_start(); // Inicia a sessão para gerenciar dados temporários, como mensagens entre páginas
require 'classes/usuarios.class.php'; // Inclui a classe 'usuarios.class.php' que manipula dados do usuário no banco de dados

$mensagem = ''; // Inicializa a variável $mensagem para armazenar as mensagens de retorno (sucesso ou erro)

if (!empty($_POST['email'])) { // Verifica se o campo 'email' foi preenchido no formulário
    $email = addslashes($_POST['email']); // Sanitiza o e-mail para evitar injeção de SQL, escapando caracteres especiais
    $usuarios = new Usuarios(); // Cria um objeto da classe 'Usuarios' para acessar seus métodos

    // Verifica se o e-mail fornecido existe no banco de dados
    if ($usuarios->existeEmail($email)) {  // Alterado de verificarEmail para existeEmail
        // Gera um token único de 16 bytes, que é convertido em uma string hexadecimal
        $token = bin2hex(random_bytes(16));

        // Salva o token gerado no banco de dados com uma validade de 1 hora
        if ($usuarios->salvarTokenSenha($email, $token)) {
            // Cria um link para a página de redefinição de senha, incluindo o token gerado na URL
            $link = "http://localhost/overtime/redefinirSenha.php?token=" . $token;

            // Exibe o link gerado para o usuário, para que ele possa acessar e redefinir sua senha
            $mensagem = "Acesse o link para redefinir sua senha: <a href='" . htmlspecialchars($link) . "'>$link</a>";
        } else {
            // Caso ocorra um erro ao salvar o token no banco de dados
            $mensagem = "Erro ao salvar o token. Tente novamente.";
        }
    } else {
        // Caso o e-mail não seja encontrado no banco de dados
        $mensagem = "E-mail não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- Define o charset para UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Define as configurações de viewport para responsividade -->
    <title>OVERTIME - Esqueceu sua senha</title> <!-- Título da página -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Link para o Bootstrap CSS -->
    <link rel="stylesheet" href="css/login.css"> <!-- Link para o arquivo CSS customizado para o layout da página -->
</head>
<body>
    <header>
        <h1>Esqueceu sua senha</h1> <!-- Título principal da página -->
        <?php if (!empty($mensagem)): ?> <!-- Se houver alguma mensagem de erro ou sucesso, exibe -->
            <p class="message"><?= $mensagem ?></p> <!-- Exibe a mensagem gerada no código PHP -->
        <?php endif; ?>
    </header>

    <div class="login-container">
        <!-- Formulário para o usuário digitar seu e-mail e solicitar a redefinição de senha -->
        <form method="POST">
            <label for="email">Digite seu e-mail cadastrado:</label> <!-- Label para o campo de e-mail -->
            <input type="email" name="email" id="email" required> <!-- Campo de entrada para o e-mail, com validação obrigatória -->
            <br><br>

            <button type="submit">Enviar</button> <!-- Botão de envio do formulário -->
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> <!-- Link para o script Bootstrap necessário para componentes interativos -->
</body>
</html>

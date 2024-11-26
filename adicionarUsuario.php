<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Definição do charset da página para UTF-8 -->
    <meta charset="UTF-8">
    <!-- Definição da meta tag para visualização em dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título da página -->
    <title>Adicionar Usuário - OVERTIME</title>
    <!-- Link para o arquivo de estilo CSS (adicionarUsuario.css) -->
    <link rel="stylesheet" href="css/adicionarUsuario.css"> <!-- Linkando o CSS -->
</head>
<body>
    <!-- Header da página -->
    <header>
        <!-- Título principal da página, indicando que é a seção para adicionar um usuário -->
        <h1>Adicionar Usuário</h1>
    </header>

    <!-- Formulário para adicionar um novo usuário -->
    <div class="form-container">
        <!-- O formulário usa o método POST para enviar os dados ao arquivo PHP adicionarUsuarioSubmit.php -->
        <form method="POST" action="adicionarUsuarioSubmit.php">
            
            <!-- Campo para o nome do usuário -->
            <div class="input-group">
                <label for="nome">Nome:</label>
                <!-- Campo de texto obrigatório para inserir o nome do usuário -->
                <input type="text" id="nome" name="nome" required />
            </div>

            <!-- Campo para o email do usuário -->
            <div class="input-group">
                <label for="email">Email:</label>
                <!-- Campo de email obrigatório para inserir o email do usuário -->
                <input type="email" id="email" name="email" required />
            </div>

            <!-- Campo para a senha do usuário -->
            <div class="input-group">
                <label for="senha">Senha:</label>
                <!-- Campo de senha obrigatório para inserir a senha do usuário -->
                <input type="password" id="senha" name="senha" required />
            </div>

            <!-- Campo para as permissões do usuário -->
            <div class="input-group">
                <label for="permissoes">Permissões:</label>
                <!-- Campo de texto obrigatório para inserir as permissões do usuário -->
                <input type="text" id="permissoes" name="permissoes" required />
            </div>

            <!-- Botão de envio do formulário -->
            <div class="button-container">
                <!-- O botão de envio tem o valor "Adicionar", que será exibido no botão -->
                <input type="submit" name="btCadastrar" value="Adicionar" class="submit-button" />
            </div>
        </form>
    </div>
</body>
</html>

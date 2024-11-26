<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Definindo a codificação de caracteres como UTF-8 -->
    <meta charset="UTF-8">

    <!-- Tornando a página responsiva, ajustando a escala para dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Título da página que aparecerá na aba do navegador -->
    <title>Adicionar Categoria - OVERTIME</title>

    <!-- Vinculando o arquivo CSS para estilizar a página -->
    <link rel="stylesheet" href="css/adicionarCategoria.css">
</head>
<body>

    <!-- Cabeçalho da página com o título principal -->
    <header>
        <h1>ADICIONAR CATEGORIA</h1>
    </header>

    <!-- Container para o formulário de adição de categoria -->
    <div class="form-container">
        <!-- O formulário envia os dados via método POST para o arquivo 'adicionarCategoriaSubmit.php' -->
        <form method="POST" action="adicionarCategoriaSubmit.php">
            
            <!-- Grupo de inputs para o nome da categoria -->
            <div class="input-group">
                <!-- Label associada ao campo de nome -->
                <label for="nome">Nome:</label>
                <!-- Campo de texto para o nome da categoria, com validação obrigatória -->
                <input type="text" id="nome" name="nome" required />
            </div>
            
            <!-- Grupo de inputs para a descrição da categoria -->
            <div class="input-group">
                <!-- Label associada ao campo de descrição -->
                <label for="descricao">Descrição:</label>
                <!-- Campo de texto para a descrição da categoria, também com validação obrigatória -->
                <input type="text" id="descricao" name="descricao" required />
            </div>

            <!-- Container para o botão de envio do formulário -->
            <div class="button-container">
                <!-- Botão de envio do formulário com o texto 'ADICIONAR' -->
                <input type="submit" name="btCadastrar" value="ADICIONAR" class="submit-button" />
            </div>
        </form>
    </div>

</body>
</html>

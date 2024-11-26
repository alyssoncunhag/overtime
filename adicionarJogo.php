<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- Definindo a codificação de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Tornando o layout responsivo -->
    <title>Adicionar Jogo - OVERTIME</title> <!-- Título da página -->
    <link rel="stylesheet" href="css/adicionarJogo.css"> <!-- Linkando o arquivo CSS para estilizar a página -->
</head>
<body>
    <header>
        <h1>ADICIONAR JOGO</h1> <!-- Cabeçalho da página com o título "ADICIONAR JOGO" -->
    </header>

    <div class="form-container">
        <!-- Formulário para adicionar um novo jogo -->
        <form action="adicionarJogoSubmit.php" method="post" enctype="multipart/form-data">
            <!-- Campo para o nome do jogo -->
            <div class="input-group">
                <label for="nome">Nome do Jogo:</label> <!-- Label indicando o campo "Nome do Jogo" -->
                <input type="text" id="nome" name="nome" required /> <!-- Input para o nome do jogo, campo obrigatório -->
            </div>
            
            <!-- Campo para a descrição do jogo -->
            <div class="input-group">
                <label for="descricao">Descrição:</label> <!-- Label indicando o campo "Descrição" -->
                <input type="text" id="descricao" name="descricao" required /> <!-- Input para a descrição do jogo, campo obrigatório -->
            </div>
            
            <!-- Campo para a data de lançamento do jogo -->
            <div class="input-group">
                <label for="data_lancamento">Data de Lançamento:</label> <!-- Label indicando o campo "Data de Lançamento" -->
                <input type="date" id="data_lancamento" name="data_lancamento" required /> <!-- Input para a data de lançamento, campo obrigatório -->
            </div>
            
            <!-- Campo para a imagem do jogo -->
            <div class="input-group">
                <label for="imagem">Imagem:</label> <!-- Label indicando o campo "Imagem" -->
                <input type="file" id="imagem" name="imagem" required /> <!-- Input para fazer upload da imagem do jogo, campo obrigatório -->
            </div>

            <!-- Botão de envio do formulário -->
            <div class="button-container">
                <input type="submit" name="btCadastrar" value="ADICIONAR" class="submit-button" /> <!-- Botão para enviar o formulário -->
            </div>
        </form>
    </div>
</body>
</html>

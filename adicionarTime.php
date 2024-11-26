<!DOCTYPE html>
<html lang="pt-br"> <!-- Define o idioma do documento como português do Brasil -->
<head>
    <meta charset="UTF-8"> <!-- Define o conjunto de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Garante que a página seja responsiva em dispositivos móveis -->
    <title>Adicionar Time - OVERTIME</title> <!-- Título da página que será exibido na aba do navegador -->
    <link rel="stylesheet" href="css/adicionarTime.css"> <!-- Link para o arquivo CSS de estilo da página -->
</head>
<body>
    <header>
        <h1>ADICIONAR TIME</h1> <!-- Cabeçalho principal com o título da página -->
    </header>

    <div class="form-container"> <!-- Container para o formulário -->
        <!-- Formulário para adicionar informações de um novo time -->
        <form method="POST" action="adicionarTimeSubmit.php" enctype="multipart/form-data"> <!-- Método POST envia dados para 'adicionarTimeSubmit.php', 'enctype' permite o envio de arquivos -->
        
            <!-- Grupo de input para o nome do time -->
            <div class="input-group">
                <label for="nome">Nome:</label> <!-- Rótulo para o campo de nome -->
                <input type="text" id="nome" name="nome" required /> <!-- Campo de entrada para o nome do time, o atributo 'required' obriga o preenchimento -->
            </div>
            
            <!-- Grupo de input para o país do time -->
            <div class="input-group">
                <label for="pais">País:</label> <!-- Rótulo para o campo de país -->
                <input type="text" id="pais" name="pais" required /> <!-- Campo de entrada para o país do time -->
            </div>
            
            <!-- Grupo de input para a descrição do time -->
            <div class="input-group">
                <label for="descricao">Descrição:</label> <!-- Rótulo para o campo de descrição -->
                <input type="text" id="descricao" name="descricao" required /> <!-- Campo de entrada para a descrição do time -->
            </div>
            
            <!-- Grupo de input para o upload de imagem -->
            <div class="input-group">
                <label for="imagem">Imagem:</label> <!-- Rótulo para o campo de imagem -->
                <input type="file" id="imagem" name="imagem" accept="image/jpeg, image/png" required /> <!-- Campo de entrada para o upload de imagem, aceitando apenas formatos JPEG e PNG -->
            </div>

            <!-- Botão de submissão do formulário -->
            <div class="button-container">
                <input type="submit" name="btCadastrar" value="ADICIONAR" class="submit-button" /> <!-- Botão para enviar o formulário -->
            </div>
        </form>
    </div>
</body>
</html>

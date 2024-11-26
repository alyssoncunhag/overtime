<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Faz com que a página seja responsiva em dispositivos móveis -->
    <title>Adicionar Notícia - OVERTIME</title> <!-- Título da página -->
    <link rel="stylesheet" href="css/adicionarNoticia.css"> <!-- Linkando o arquivo CSS que será utilizado para estilizar a página -->
</head>
<body>
    <header>
        <h1>ADICIONAR NOTÍCIA</h1> <!-- Título principal da página -->
    </header>

    <div class="form-container"> <!-- Div que envolve o formulário -->
        <!-- Formulário para adicionar a notícia. Método POST para enviar os dados e enctype para permitir o envio de arquivos -->
        <form method="POST" action="adicionarNoticiaSubmit.php" enctype="multipart/form-data">
            <!-- Campo para o título da notícia -->
            <div class="input-group">
                <label for="titulo">Título:</label> <!-- Rótulo do campo -->
                <input type="text" id="titulo" name="titulo" required /> <!-- Campo de texto para o título, o atributo required torna este campo obrigatório -->
            </div>
            
            <!-- Campo para o conteúdo da notícia -->
            <div class="input-group">
                <label for="conteudo">Conteúdo:</label> <!-- Rótulo do campo -->
                <input type="text" id="conteudo" name="conteudo" required /> <!-- Campo de texto para o conteúdo da notícia -->
            </div>
            
            <!-- Campo para o upload de uma imagem -->
            <div class="input-group">
                <label for="imagem">Imagem:</label> <!-- Rótulo para o campo de imagem -->
                <input type="file" id="imagem" name="imagem" required /> <!-- Campo para enviar arquivos, neste caso uma imagem, o atributo required torna-o obrigatório -->
            </div>
            
            <!-- Campo para o ID da categoria da notícia -->
            <div class="input-group">
                <label for="id_categorias">ID Categoria:</label> <!-- Rótulo para o ID da categoria -->
                <input type="text" id="id_categorias" name="id_categorias" required /> <!-- Campo de texto para o ID da categoria -->
            </div>

            <!-- Campo para o ID do autor da notícia -->
            <div class="input-group">
                <label for="id_autor">ID Autor:</label> <!-- Rótulo para o ID do autor -->
                <input type="text" id="id_autor" name="id_autor" required /> <!-- Campo de texto para o ID do autor -->
            </div>

            <!-- Campo para a data de publicação da notícia -->
            <div class="input-group">
                <label for="data_publicacao">Data de Publicação:</label> <!-- Rótulo para a data de publicação -->
                <input type="date" id="data_publicacao" name="data_publicacao" required /> <!-- Campo de data para a data de publicação -->
            </div>

            <!-- Botão de envio do formulário -->
            <div class="button-container">
                <input type="submit" name="btCadastrar" value="ADICIONAR" class="submit-button" /> <!-- Botão de submissão do formulário -->
            </div>
        </form>
    </div>
</body>
</html>

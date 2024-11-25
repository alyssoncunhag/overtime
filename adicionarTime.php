<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Notícia - OVERTIME</title>
    <link rel="stylesheet" href="css/adicionarNoticia.css"> <!-- Linkando o CSS -->
</head>
<body>
    <header>
        <h1>ADICIONAR NOTÍCIA</h1>
    </header>

    <div class="form-container">
        <form method="POST" action="adicionarNoticiaSubmit.php">
            <div class="input-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required />
            </div>
            
            <div class="input-group">
                <label for="conteudo">Conteúdo:</label>
                <input type="text" id="conteudo" name="conteudo" required />
            </div>
            
            <div class="input-group">
                <label for="imagem">Imagem:</label>
                <input type="text" id="imagem" name="imagem" required />
            </div>
            
            <div class="input-group">
                <label for="id_categoria">ID Categoria:</label>
                <input type="hidden" id="id_categoria" name="id_categoria" value="1" />
            </div>

            <div class="input-group">
                <label for="id_autor">ID Autor:</label>
                <input type="hidden" id="id_autor" name="id_autor" value="1" />
            </div>

            <div class="input-group">
                <label for="data_publicacao">Data de Publicação:</label>
                <input type="date" id="data_publicacao" name="data_publicacao" required />
            </div>

            <div class="button-container">
                <input type="submit" name="btCadastrar" value="ADICIONAR" class="submit-button" />
            </div>
        </form>
    </div>
</body>
</html>
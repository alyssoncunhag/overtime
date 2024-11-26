<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Time - OVERTIME</title>
    <link rel="stylesheet" href="css/adicionarTime.css"> <!-- Linkando o CSS -->
</head>
<body>
    <header>
        <h1>ADICIONAR TIME</h1>
    </header>

    <div class="form-container">
        <form method="POST" action="adicionarTimeSubmit.php">
            <div class="input-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required />
            </div>
            
            <div class="input-group">
                <label for="pais">País:</label>
                <input type="text" id="pais" name="pais" required />
            </div>
            
            <div class="input-group">
                <label for="descricao">Descrição:</label>
                <input type="text" id="descricao" name="descricao" required />
            </div>
            
            <div class="input-group">
                <label for="imagem">imagem</label>
                <input type="file" id="imagem" name="imagem" required />
            </div>

            <div class="button-container">
                <input type="submit" name="btCadastrar" value="ADICIONAR" class="submit-button" />
            </div>
        </form>
    </div>
</body>
</html>
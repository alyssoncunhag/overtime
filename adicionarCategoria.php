<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Categoria - OVERTIME</title>
    <link rel="stylesheet" href="css/adicionarCategoria.css">
</head>
<body>
    <header>
        <h1>ADICIONAR CATEGORIA</h1>
    </header>

    <div class="form-container">
        <form method="POST" action="adicionarCategoriaSubmit.php">
            <div class="input-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required />
            </div>
            
            <div class="input-group">
                <label for="descricao">Descrição:</label>
                <input type="text" id="descricao" name="descricao" required />
            </div>

            <div class="button-container">
                <input type="submit" name="btCadastrar" value="ADICIONAR" class="submit-button" />
            </div>
        </form>
    </div>
</body>
</html>

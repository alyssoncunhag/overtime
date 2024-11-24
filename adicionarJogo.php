<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Jogo - OVERTIME</title>
    <link rel="stylesheet" href="css/adicionarJogo.css"> <!-- Linkando o CSS -->
</head>
<body>
    <header>
        <h1>ADICIONAR JOGO</h1>
    </header>

    <div class="form-container">
        <form method="POST" action="adicionarJogoSubmit.php">
            <div class="input-group">
                <label for="nome">Nome do Jogo:</label>
                <input type="text" id="nome" name="nome" required />
            </div>
            
            <div class="input-group">
                <label for="descricao">Descrição:</label>
                <input type="text" id="descricao" name="descricao" required />
            </div>
            
            <div class="input-group">
                <label for="data_lancamento">Data de Lançamento:</label>
                <input type="date" id="data_lancamento" name="data_lancamento" required />
            </div>
            
            <div class="input-group">
                <label for="imagem">Imagem:</label>
                <input type="text" id="imagem" name="imagem" required />
            </div>

            <div class="button-container">
                <input type="submit" name="btCadastrar" value="ADICIONAR" class="submit-button" />
            </div>
        </form>
    </div>
</body>
</html>

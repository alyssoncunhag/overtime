<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Torneio - OVERTIME</title>
    <link rel="stylesheet" href="css/adicionarTorneio.css"> <!-- Linkando o CSS -->
</head>
<body>
    <header>
        <h1>ADICIONAR TORNEIO</h1>
    </header>

    <div class="form-container">
        <form method="POST" action="adicionarTorneioSubmit.php">
            <div class="input-group">
                <label for="nome">Nome do Torneio:</label>
                <input type="text" id="nome" name="nome" required />
            </div>
            
            <div class="input-group">
                <label for="id_jogo">ID Jogo:</label>
                <input type="text" id="id_jogo" name="id_jogo" required />
            </div>
            
            <div class="input-group">
                <label for="descricao">Descrição:</label>
                <input type="text" id="descricao" name="descricao" required />
            </div>
            
            <div class="input-group">
                <label for="data_inicio">Data de Início:</label>
                <input type="date" id="data_inicio" name="data_inicio" required />
            </div>

            <div class="input-group">
                <label for="data_fim">Data de Fim:</label>
                <input type="date" id="data_fim" name="data_fim" required />
            </div>

            <div class="button-container">
                <input type="submit" name="btCadastrar" value="ADICIONAR" class="submit-button" />
            </div>
        </form>
    </div>
</body>
</html>

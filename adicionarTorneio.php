<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Define o conjunto de caracteres utilizado (UTF-8) -->
    <meta charset="UTF-8">
    
    <!-- Configura o layout para ser responsivo, ajustando a largura conforme o dispositivo -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Define o título da página (aparece na aba do navegador) -->
    <title>Adicionar Torneio - OVERTIME</title>
    
    <!-- Link para o arquivo CSS externo que estiliza a página -->
    <link rel="stylesheet" href="css/adicionarTorneio.css"> <!-- Linkando o CSS -->
</head>
<body>
    <!-- Cabeçalho da página -->
    <header>
        <h1>ADICIONAR TORNEIO</h1> <!-- Título principal da página -->
    </header>

    <!-- Container do formulário -->
    <div class="form-container">
        <!-- Formulário com método POST para enviar os dados e enctype multipart/form-data para permitir o envio de arquivos -->
        <form method="POST" action="adicionarTorneioSubmit.php" enctype="multipart/form-data">
            
            <!-- Campo para o nome do torneio -->
            <div class="input-group">
                <label for="nome">Nome do Torneio:</label> <!-- Rótulo explicativo -->
                <input type="text" id="nome" name="nome" required /> <!-- Campo de entrada de texto obrigatório -->
            </div>
            
            <!-- Campo para o ID do jogo associado ao torneio -->
            <div class="input-group">
                <label for="id_jogos">ID Jogo:</label> <!-- Rótulo explicativo -->
                <input type="text" id="id_jogos" name="id_jogos" required /> <!-- Campo de entrada de texto obrigatório -->
            </div>
            
            <!-- Campo para a descrição do torneio -->
            <div class="input-group">
                <label for="descricao">Descrição:</label> <!-- Rótulo explicativo -->
                <input type="text" id="descricao" name="descricao" required /> <!-- Campo de entrada de texto obrigatório -->
            </div>
            
            <!-- Campo para a data de início do torneio -->
            <div class="input-group">
                <label for="data_inicio">Data de Início:</label> <!-- Rótulo explicativo -->
                <input type="date" id="data_inicio" name="data_inicio" required /> <!-- Campo de data obrigatório -->
            </div>

            <!-- Campo para a data de fim do torneio -->
            <div class="input-group">
                <label for="data_fim">Data de Fim:</label> <!-- Rótulo explicativo -->
                <input type="date" id="data_fim" name="data_fim" required /> <!-- Campo de data obrigatório -->
            </div>

            <!-- Campo para upload de imagem relacionada ao torneio -->
            <div class="input-group">
                <label for="imagem">Imagem do Torneio:</label> <!-- Rótulo explicativo -->
                <input type="file" id="imagem" name="imagem" accept="image/*" /> <!-- Campo para envio de arquivo (imagem) -->
            </div>

            <!-- Container para o botão de envio -->
            <div class="button-container">
                <!-- Botão de envio do formulário -->
                <input type="submit" name="btCadastrar" value="ADICIONAR" class="submit-button" /> <!-- Botão com classe para estilização -->
            </div>
        </form>
    </div>
</body>
</html>

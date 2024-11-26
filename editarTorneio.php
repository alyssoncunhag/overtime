<?php
// Incluir a classe 'Torneios' para acessar os métodos relacionados ao torneio
require 'classes/torneios.class.php';

// Verifica se foi passado um ID de torneio via GET na URL
if(isset($_GET['id'])){
    // Cria uma instância da classe Torneios
    $torneio = new Torneios();
    // Chama o método 'buscar' passando o ID para obter os dados do torneio
    $dadosTorneio = $torneio->buscar($_GET['id']);
    
    // Se os dados do torneio não forem encontrados, exibe uma mensagem de erro
    if(empty($dadosTorneio)){
        echo "Torneio não encontrado!";
        exit; // Encerra a execução do script
    }
} else {
    // Caso o ID não tenha sido fornecido via URL, exibe uma mensagem de erro
    echo "ID do torneio não fornecido!";
    exit; // Encerra a execução do script
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Torneio</title> <!-- Título da página -->
    <!-- Vinculando o arquivo CSS -->
    <link rel="stylesheet" href="css/editarTorneio.css">
</head>
<body>
    <!-- Cabeçalho -->
    <header>
        <h1>Editar Torneio</h1>
    </header>

    <!-- Formulário para editar os dados do torneio -->
    <div class="form-container">
        <form action="editarTorneioSubmit.php" method="POST" enctype="multipart/form-data">
            <!-- Campo oculto para enviar o ID do torneio com o formulário -->
            <input type="hidden" name="id" value="<?= $dadosTorneio['id']; ?>">

            <!-- Campo para editar o nome do torneio -->
            <div class="input-group">
                <label for="nome">Nome do Torneio</label>
                <input type="text" id="nome" name="nome" value="<?= $dadosTorneio['nome']; ?>" required>
            </div>

            <!-- Campo para editar o ID do jogo associado ao torneio -->
            <div class="input-group">
                <label for="id_jogos">ID Jogo</label>
                <input type="text" name="id_jogos" value="<?= $dadosTorneio['id_jogos']; ?>" required>
            </div>

            <!-- Campo para editar a descrição do torneio -->
            <div class="input-group">
                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" required><?= $dadosTorneio['descricao']; ?></textarea>
            </div>

            <!-- Campo para editar a data de início do torneio -->
            <div class="input-group">
                <label for="data_inicio">Data de Início</label>
                <input type="date" id="data_inicio" name="data_inicio" value="<?= $dadosTorneio['data_inicio']; ?>" required>
            </div>

            <!-- Campo para editar a data de fim do torneio -->
            <div class="input-group">
                <label for="data_fim">Data de Fim</label>
                <input type="date" id="data_fim" name="data_fim" value="<?= $dadosTorneio['data_fim']; ?>" required>
            </div>

            <!-- Campo para enviar uma nova imagem (opcional) -->
            <div class="input-group">
                <label for="imagem">Imagem (opcional)</label>
                <input type="file" id="imagem" name="imagem" accept="image/*" />
            </div>

            <!-- Botão para submeter o formulário -->
            <div class="button-container">
                <button type="submit" class="submit-button">Salvar alterações</button>
            </div>
        </form>
    </div>
</body>
</html>

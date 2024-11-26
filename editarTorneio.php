<?php
require 'classes/torneios.class.php';

if(isset($_GET['id'])){
    $torneio = new Torneios();
    $dadosTorneio = $torneio->buscar($_GET['id']); // Obtém o torneio com o ID passado pela URL
    if(empty($dadosTorneio)){
        echo "Torneio não encontrado!";
        exit;
    }
} else {
    echo "ID do torneio não fornecido!";
    exit;
}
?>

<form action="editarTorneioSubmit.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $dadosTorneio['id']; ?>">

    <label for="nome">Nome do Torneio</label>
    <input type="text" id="nome" name="nome" value="<?= $dadosTorneio['nome']; ?>" required>

    <label for="id_jogos">ID Jogo</label>
    <input type="text" name="id_jogos" value="<?= $dadosTorneio['id_jogos']; ?>" required>

    <label for="descricao">Descrição</label>
    <textarea id="descricao" name="descricao" required><?= $dadosTorneio['descricao']; ?></textarea>

    <label for="data_inicio">Data de Início</label>
    <input type="date" id="data_inicio" name="data_inicio" value="<?= $dadosTorneio['data_inicio']; ?>" required>

    <label for="data_fim">Data de Fim</label>
    <input type="date" id="data_fim" name="data_fim" value="<?= $dadosTorneio['data_fim']; ?>" required>

    <label for="imagem">Imagem (opcional)</label>
    <input type="file" id="imagem" name="imagem[]">

    <button type="submit">Salvar alterações</button>
</form>

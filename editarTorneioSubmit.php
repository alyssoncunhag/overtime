<?php
require 'classes/torneios.class.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coletando os dados do formulário
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $id_jogos = $_POST['id_jogos'];
    $descricao = $_POST['descricao'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    // Verificando se a imagem foi enviada
    $imagem = isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK ? $_FILES['imagem'] : null;

    // Atualizando os dados no banco
    $torneio = new Torneios();
    $result = $torneio->editar($id, $nome, $id_jogos, $descricao, $data_inicio, $data_fim, $imagem);

    if ($result) {
        echo "Torneio atualizado com sucesso!";
        header("Location: index.php"); // Redireciona para a página de listagem de torneios
        exit;
    } else {
        echo "Erro ao atualizar o torneio.";
    }
}
?>

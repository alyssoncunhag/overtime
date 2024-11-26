<?php
// Incluir a classe de jogos
require 'classes/jogos.class.php';

$jogo = new Jogos();

// Verificar se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $data_lancamento = $_POST['data_lancamento'];
    $imagem = $_FILES['imagem'];

    // Chamar o método de editar da classe Jogos
    $resultado = $jogo->editar($nome, $descricao, $data_lancamento, $imagem, $id);

    if ($resultado === TRUE) {
        // Redirecionar para a página index.php após sucesso
        header("Location: index.php");
        exit(); // Certifique-se de que o script pare após o redirecionamento
    } else {
        // Caso ocorra algum erro
        echo "Erro ao atualizar o jogo.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>

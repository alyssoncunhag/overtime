<?php
// Incluir a classe 'Torneios' para acessar os métodos de atualização do torneio
require 'classes/torneios.class.php';

// Verifica se o formulário foi enviado via método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Coletando os dados enviados pelo formulário
    // O ID é necessário para identificar o torneio a ser atualizado
    $id = $_POST['id'];
    // O nome do torneio
    $nome = $_POST['nome'];
    // O ID do jogo associado ao torneio
    $id_jogos = $_POST['id_jogos'];
    // A descrição do torneio
    $descricao = $_POST['descricao'];
    // A data de início do torneio
    $data_inicio = $_POST['data_inicio'];
    // A data de fim do torneio
    $data_fim = $_POST['data_fim'];

    // Verificando se foi enviada uma imagem
    // O código verifica se o campo de imagem existe e se não houve erro no upload
    $imagem = isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK ? $_FILES['imagem'] : null;

    // Criando uma instância da classe 'Torneios' para utilizar o método de edição
    $torneio = new Torneios();

    // Chama o método 'editar' da classe Torneios, passando os dados coletados para atualizar o torneio no banco de dados
    $result = $torneio->editar($id, $nome, $id_jogos, $descricao, $data_inicio, $data_fim, $imagem);

    // Verifica se a atualização foi bem-sucedida
    if ($result) {
        // Se a atualização for bem-sucedida, exibe uma mensagem de sucesso
        echo "Torneio atualizado com sucesso!";
        // Redireciona o usuário para a página de listagem de torneios
        header("Location: index.php");
        exit; // Interrompe o script após o redirecionamento
    } else {
        // Caso contrário, exibe uma mensagem de erro
        echo "Erro ao atualizar o torneio.";
    }
}
?>

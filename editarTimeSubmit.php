<?php
// Incluir a classe 'Times' para permitir o acesso aos métodos de manipulação de times
require_once 'classes/times.class.php';

// Verificar se o método de requisição é POST, ou seja, se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar os dados enviados pelo formulário
    $id = $_POST['id']; // ID do time a ser atualizado
    $nome = $_POST['nome']; // Nome do time
    $pais = $_POST['pais']; // País do time
    $descricao = $_POST['descricao']; // Descrição do time
    $imagem = isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK ? $_FILES['imagem'] : null; // Verifica se foi enviado um arquivo de imagem

    // Criar uma instância do objeto 'Times' para acessar seus métodos
    $times = new Times();
    
    // Chama o método 'editar' da classe 'Times' passando os dados do time
    $resultado = $times->editar($nome, $pais, $descricao, $imagem, $id);

    // Verificar se a atualização foi bem-sucedida
    if ($resultado) {
        // Se a atualização foi bem-sucedida, redireciona para a página inicial (index.php)
        header("Location: gestaoTime.php");
        exit(); // Certifica-se de que o código após o redirecionamento não será executado
    } else {
        // Caso a atualização falhe, exibe uma mensagem de erro
        echo "Erro ao atualizar o time.";
    }
}
?>

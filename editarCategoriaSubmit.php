<?php
include 'classes/categorias.class.php'; 

$categoria = new Categorias(); 

// Verifica se os campos 'nome' e 'descricao' foram preenchidos no formulário
if (isset($_POST['nome']) && isset($_POST['descricao'])) {
    // Recupera os valores dos campos 'nome' e 'descricao' do formulário
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    // Verifica se a variável '$id' está definida e não está vazia (indicando que é uma edição)
    if (isset($id) && !empty($id)) {
        // Se o ID estiver presente, chama o método 'editar' da classe 'Categorias' para atualizar a categoria
        $resultado = $categoria->editar($id, $nome, $descricao);
    } else {
        // Se o ID não estiver presente, chama o método 'adicionar' para adicionar uma nova categoria
        $resultado = $categoria->adicionar($nome, $descricao);
    }

    // Verifica se a operação foi bem-sucedida
    if ($resultado === TRUE) {
        // Se a operação foi bem-sucedida, redireciona o usuário para a página principal (index.php)
        header('Location: index.php');
        exit();  // Interrompe a execução do script após o redirecionamento
    } else {
        // Se a operação falhou, exibe um alerta com a mensagem de erro retornada
        echo '<script type="text/javascript">alert("' . $resultado . '");</script>';
    }
}
?>

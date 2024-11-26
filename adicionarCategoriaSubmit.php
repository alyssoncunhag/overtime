<?php
// Inclui o arquivo da classe Categorias, que contém os métodos para manipular as categorias
include 'classes/categorias.class.php';

// Cria um novo objeto da classe Categorias
$categoria = new Categorias();

// Verifica se os campos 'nome' e 'descricao' foram enviados via POST
if (isset($_POST['nome']) && isset($_POST['descricao'])) {
    
    // Atribui os valores enviados pelo formulário às variáveis
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    
    // Chama o método 'adicionar' da classe Categorias para adicionar a nova categoria
    // O método retornar TRUE em caso de sucesso, ou uma mensagem de erro em caso de falha
    $resultado = $categoria->adicionar($nome, $descricao);
    
    // Verifica o resultado retornado pela função 'adicionar'
    if ($resultado === TRUE) {
        // Se o resultado for TRUE, significa que a categoria foi adicionada com sucesso
        // O usuário é redirecionado para a página inicial ('index.php')
        header('Location: index.php');
        exit(); // Garante que o script seja interrompido após o redirecionamento
    } else {
        // Se o resultado não for TRUE, exibe uma mensagem de erro (ex: categoria já cadastrada)
        echo '<script type="text/javascript">alert("' . $resultado . '");</script>';
    }
}
?>

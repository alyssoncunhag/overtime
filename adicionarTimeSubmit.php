<?php
include 'classes/times.class.php';  // Incluindo o arquivo da classe 'Times', onde é definido o comportamento dos times
$time = new Times();  // Criando uma instância da classe 'Times', para poder acessar seus métodos

// Verifica se o campo 'nome' não está vazio (se o nome do time foi preenchido no formulário)
if(!empty($_POST['nome'])){
    // Atribui os valores dos campos do formulário às variáveis
    $nome = $_POST['nome'];  // Recebe o nome do time enviado pelo formulário
    $pais = $_POST['pais'];  // Recebe o país do time
    $descricao = $_POST['descricao'];  // Recebe a descrição do time
    $imagem = $_POST['imagem'];  // Recebe a imagem enviada pelo formulário
    
    // Chama o método 'adicionar' da classe 'Times', passando os dados do time
    $time->adicionar($nome, $pais, $descricao, $imagem);
    
    // Após adicionar o time, redireciona para a página inicial ('index.php')
    header('Location: index.php');
} else {
    // Se o campo 'nome' estiver vazio, exibe um alerta dizendo que o time já foi cadastrado
    echo '<script type="text/javascript">alert("Time já cadastrado!");</script>';
}
?>

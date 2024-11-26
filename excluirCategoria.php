<?php
include 'classes/categorias.class.php'; // Inclui a classe 'categorias.class.php' para manipulação de dados de categoria
$com = new Categorias(); // Cria um objeto da classe 'Categorias', permitindo o uso de seus métodos

if(!empty($_GET['id'])){ // Verifica se o parâmetro 'id' foi passado na URL e não está vazio
    $id = $_GET['id']; // Atribui o valor do parâmetro 'id' à variável $id
    $com ->deletar($id); // Chama o método 'deletar' da classe 'Categorias', passando o id da categoria para ser excluída
    header('Location: /overtime'); // Redireciona para a página inicial '/overtime' após a exclusão
}else{ 
    echo '<script type="text/javascript">alert("Erro ao excluir categoria!");</script>'; // Exibe um alerta JavaScript se o parâmetro 'id' não for encontrado ou estiver vazio
    header('Location: /overtime'); // Redireciona para a página inicial '/overtime' após o erro
}
?>

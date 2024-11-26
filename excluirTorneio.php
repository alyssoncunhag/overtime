<?php
include 'classes/torneios.class.php'; // Inclui o arquivo da classe 'torneios.class.php' para manipulação dos dados dos torneios
$com = new Torneios(); // Cria um objeto da classe 'Torneios', permitindo o uso dos seus métodos

if(!empty($_GET['id'])){ // Verifica se o parâmetro 'id' foi passado na URL e se não está vazio
    $id = $_GET['id']; // Atribui o valor do parâmetro 'id' à variável $id
    $com ->deletar($id); // Chama o método 'deletar' da classe 'Torneios', passando o id do torneio para ser excluído
    header('Location: /overtime'); // Redireciona para a página inicial '/overtime' após a exclusão
}else{ 
    echo '<script type="text/javascript">alert("Erro ao excluir torneio!");</script>'; // Exibe um alerta JavaScript se o parâmetro 'id' não for encontrado ou estiver vazio
    header('Location: /overtime'); // Redireciona para a página inicial '/overtime' após o erro
}
?>

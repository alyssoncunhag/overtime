<?php
include 'classes/jogos.class.php'; // Inclui o arquivo da classe 'jogos.class.php' para manipulação de dados de jogo
$com = new Jogos(); // Cria um objeto da classe 'Jogos', permitindo o uso dos seus métodos

if(!empty($_GET['id'])){ // Verifica se o parâmetro 'id' foi passado na URL e não está vazio
    $id = $_GET['id']; // Atribui o valor do parâmetro 'id' à variável $id
    $com ->deletar($id); // Chama o método 'deletar' da classe 'Jogos', passando o id do jogo para ser excluído
    header('Location: /overtime'); // Redireciona para a página inicial '/overtime' após a exclusão
}else{ 
    echo '<script type="text/javascript">alert("Erro ao excluir jogo!");</script>'; // Exibe um alerta JavaScript se o parâmetro 'id' não for encontrado ou estiver vazio
    header('Location: /overtime'); // Redireciona para a página inicial '/overtime' após o erro
}
?>

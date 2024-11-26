<?php
// Inclui a classe 'Noticias' para manipulação das notícias
include 'classes/noticias.class.php';

// Cria uma instância da classe 'Noticias'
$noticia = new Noticias();

// Verifica se o campo 'titulo' foi preenchido no formulário
if(!empty($_POST['titulo']) && isset($_POST['titulo'])){
    // Atribui os dados do formulário às variáveis
    $titulo = $_POST['titulo']; // Obtém o título da notícia
    $conteudo = $_POST['conteudo']; // Obtém o conteúdo da notícia
    $imagem = $_POST['imagem']; // Obtém o arquivo da imagem (mas deve ser alterado para $_FILES)
    $id_categorias = $_POST['id_categorias']; // Obtém o ID da categoria
    $id_autor = $_POST['id_autor']; // Obtém o ID do autor
    $data_publicacao = $_POST['data_publicacao']; // Obtém a data de publicação

    // Chama o método 'adicionar' da classe Noticias, passando os dados da notícia
    $resultado = $noticia->adicionar($titulo, $conteudo, $imagem, $id_categorias, $id_autor, $data_publicacao); 

    // Verifica se a inserção foi bem-sucedida
    if ($resultado) {
        // Caso a notícia tenha sido adicionada com sucesso, redireciona para a página inicial
        header('Location: index.php'); // Redireciona para 'index.php'
    } else {
        // Caso ocorra um erro (como a notícia já estar cadastrada), exibe uma mensagem de erro
        echo '<script type="text/javascript">alert("Notícia já cadastrada!");</script>';
    }
} else {
    // Se algum campo obrigatório não for preenchido, exibe uma mensagem de erro
    echo '<script type="text/javascript">alert("Preencha todos os campos!");</script>';
}
?>

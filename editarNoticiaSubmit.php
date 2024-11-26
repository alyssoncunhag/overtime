<?php
// Incluir a classe Noticias para manipulação de dados de notícias
include 'classes/noticias.class.php';
$noticia = new Noticias(); // Cria um objeto da classe Noticias para interagir com o banco de dados

// Verifica se o formulário foi enviado (se o campo id não estiver vazio)
if (!empty($_POST['id'])) {
    // Captura os dados enviados via POST pelo formulário
    $titulo = $_POST['titulo']; // Título da notícia
    $conteudo = $_POST['conteudo']; // Conteúdo da notícia
    $imagem = $_FILES['imagem']; // Arquivo de imagem enviado (caso exista)
    $id_categorias = $_POST['id_categorias']; // ID da categoria da notícia
    $id_autor = $_POST['id_autor']; // ID do autor da notícia
    $data_publicacao = $_POST['data_publicacao']; // Data de publicação da notícia
    $id = $_POST['id']; // ID da notícia (para saber qual notícia editar)

    // Verifica se o título da notícia não está vazio antes de tentar editar
    if (!empty($titulo)) {
        // Chama o método 'editar' da classe Noticias para atualizar a notícia no banco de dados
        $noticia->editar($titulo, $conteudo, $imagem, $id_categorias, $id_autor, $data_publicacao, $id);
    }

    // Após editar a notícia, redireciona para a página inicial ("/overtime")
    header("Location: /overtime");
}

// Verifica se o parâmetro 'id' foi passado via GET para obter a notícia a ser editada
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Busca as informações da notícia com o ID fornecido
    $info = $noticia->buscar($_GET['id']);
} else {
    // Caso não tenha sido passado um ID válido, redireciona para a página inicial
    ?>
    <script type="text/javascript">
        window.location.href="index.php"; // Redireciona para a página principal (index)
    </script>
    <?php
    exit; // Interrompe a execução do script, evitando a continuação do processamento
}
?>

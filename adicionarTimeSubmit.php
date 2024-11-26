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
    
    // Inicializa a variável de imagem como null
    $imagem = null;

    // Verifica se um arquivo de imagem foi enviado e não há erros
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        // Define o diretório onde a imagem será salva
        $diretorio = 'img/times/';
        // Pega o nome da imagem
        $nome_imagem = $_FILES['imagem']['name'];
        // Define o caminho completo para salvar a imagem
        $caminho_imagem = $diretorio . basename($nome_imagem);
        
        // Tenta mover a imagem para o diretório especificado
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_imagem)) {
            // Se o upload for bem-sucedido, atribui o nome da imagem à variável $imagem
            $imagem = $nome_imagem;  // Nome da imagem que será armazenado no banco de dados
        } else {
            // Se ocorrer um erro no upload da imagem, exibe uma mensagem de erro
            echo '<script type="text/javascript">alert("Erro no upload da imagem!");</script>';
        }
    }
    // Chama o método 'adicionar' da classe 'Times', passando os dados do time
    $time->adicionar($nome, $pais, $descricao, $imagem);
    
    // Após adicionar o time, redireciona para a página inicial ('index.php')
    header('Location: gestaoTime.php');
} else {
    // Se o campo 'nome' estiver vazio, exibe um alerta dizendo que o time já foi cadastrado
    echo '<script type="text/javascript">alert("Time já cadastrado!");</script>';
}
?>

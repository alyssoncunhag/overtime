<?php
include 'classes/categorias.class.php'
$categoria = new Categorias();

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $info = $categorias->buscar($id);
    if(empty($info['nome'])){
        header("Location: /overtime");
        exit;
    }else{
        header("Location: /overtime");
        exit;
    }

if(!empty($_POST['id'])){
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

if(!empty($nome)){
    $categoria->editar($nome, $descricao, $_GET('id'));
}
header('Location: /overtime');
}
if(isset($_GET['id']) && !empty($_GET['id'])){
    $info = $categorias->getCategoria($_GET['id']);
}else{
    ?>
    <script type ="text/javascript">window.location.href="index.php";</script>
    <?php
    exit;
}

?>

<h1>EDITAR CATEGORIA</h1>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
    Nome: <br>
    <input type="text" name="nome" value="<?php echo $info['nome']; ?>">
    Descrição: <br>
    <input type="text" name="descricao" value="<?php echo $info['descricao']; ?>">
</form>


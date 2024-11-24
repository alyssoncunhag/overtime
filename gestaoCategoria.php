<?php
session_start();
include 'classes/categorias.class.php';
if(!isset($_SESSION['logado'])){
    header("Location: login.php");
    exit;
}


$categoria = new Categorias();

?>

<h1>Gestão de Categorias</h1>
<hr>
<button><a href="#">ADICIONAR</a></button>
<br><br>
<table border="3" width="100%">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Descrição</th>
    </tr>
<?php
$lista = $descricao->listar();
foreach($lista as $item):
?>
<tbody>
    <tr>
        <td><?php echo $item['id']?></td>
        <td><?php echo $item['nome']?></td>
        <td><?php echo $item['descricao']?></td>
            <a href="#">Editar</a>
            <a href="#"> | Excluir</a>
        </td>
    </tr>
</tbody>
<?php
endforeach;
?>
</table>
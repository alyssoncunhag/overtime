<?php
session_start();
include 'classes/times.class.php';
if(!isset($_SESSION['logado'])){
    header("Location: login.php");
    exit;
}

$time = new Times();

?>

<h1>Gestão de Times</h1>
<hr>
<button><a href="#">ADICIONAR</a></button>
<br><br>
<table border="3" width="100%">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>País</th>
        <th>Descrição</th>
        <th>Imagem</th>
    </tr>
<?php
$lista = $time->listar();
foreach($lista as $item):
?>
<tbody>
    <tr>
        <td><?php echo $item['id']?></td>
        <td><?php echo $item['nome']?></td>
        <td><?php echo $item['pais']?></td>
        <td><?php echo $item['descricao']?></td>
        <td><?php echo $item['imagem']?></td>
            <a href="#">Editar</a>
            <a href="#"> | Excluir</a>
        </td>
    </tr>
</tbody>
<?php
endforeach;
?>
</table>
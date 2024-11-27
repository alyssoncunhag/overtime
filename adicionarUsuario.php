<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Usuário - OVERTIME</title>
    <link rel="stylesheet" href="css/adicionarUsuario.css">
</head>
<body>
    <header>
        <h1>Adicionar Usuário</h1>
    </header>

    <div class="form-container">
        <form method="POST" action="adicionarUsuarioSubmit.php">
            
     
            <div class="input-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required />
            </div>

            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required />
            </div>

            <div class="input-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required />
            </div>

            <div class="input-group">
                <label for="permissoes">Permissões:</label>
                <input type="text" id="permissoes" name="permissoes" required />
            </div>

            <div class="button-container">
                <input type="submit" name="btCadastrar" value="Adicionar" class="submit-button" />
            </div>
        </form>
    </div>
</body>
</html>

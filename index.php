<?php
include 'conexao.php';

// Variável para armazenar a mensagem de retorno ao usuário
$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validação básica das entradas
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    
    if (empty($nome) || empty($email) || empty($senha)) {
        $mensagem = "<div class='alert alert-danger'>Todos os campos são obrigatórios.</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "<div class='alert alert-danger'>Formato de e-mail inválido.</div>";
    } else {
        // Hash da senha para segurança
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        try {
            // Insere os dados no banco de dados
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha_hash);
            $stmt->execute();
            $mensagem = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
        } catch (PDOException $e) {
            // Tratamento de erro para e-mail duplicado
            if ($e->getCode() == 23000) {
                $mensagem = "<div class='alert alert-danger'>E-mail já cadastrado. Por favor, use outro e-mail.</div>";
            } else {
                $mensagem = "<div class='alert alert-danger'>Erro: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Cadastrar Usuário</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Cadastrar Novo Usuário</h2>
        <?php
        // Exibir a mensagem de retorno, se existir
        if (!empty($mensagem)) {
            echo $mensagem;
        }
        ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form><br><br>
        <a href="read.php" class="btn btn-primary">ver usuarios</a>

    </div>
</body>
</html>

<?php
include 'conexao.php';

try {
    $sql = "SELECT * FROM usuarios";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $usuarios = $stmt->fetchAll();

    echo "<table class='table table-bordered mt-4'>";
    echo "<thead><tr><th>ID</th><th>Nome</th><th>Email</th><th>Data de Criação</th><th>Ações</th></tr></thead>";
    echo "<tbody>";
    foreach ($usuarios as $usuario) {
        echo "<tr>";
        echo "<td>" . $usuario['id'] . "</td>";
        echo "<td>" . $usuario['nome'] . "</td>";
        echo "<td>" . $usuario['email'] . "</td>";
        echo "<td>" . $usuario['data_criacao'] . "</td>";
        echo "<td><a href='update.php?id=" . $usuario['id'] . "' class='btn btn-warning'>Editar</a> ";
        echo "<a href='delete.php?id=" . $usuario['id'] . "' class='btn btn-danger'>Excluir</a></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>

<a href="index.php" class="btn btn-primary">Adicionar Novo Usuário</a>

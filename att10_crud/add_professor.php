<?php

include 'bd.php';

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome_professor'];

    $sql = "INSERT INTO professores (nome_professor) VALUES ('$nome')";

    if ($conn->query($sql) === TRUE) {
        echo "Novo professor registrado com sucesso";
    }
}

$conn->close();

?>

<form method="POST" action="add_professor.php">
    Nome: <input type="text" name="nome_professor" required>
    <input type="submit" value="adicionar">
</form>

<a href="index.php">visualizar diário</a>

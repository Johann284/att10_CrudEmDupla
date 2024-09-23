<?php

include 'bd.php';

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome_professor'];
    $formacao = $_POST['formacao'];
    $cpf = $_POST['cpf'];

    $sql = "INSERT INTO professores (nome_professor, formacao, cpf) VALUES ('$nome', '$formacao', '$cpf')";

    if ($conn->query($sql) === TRUE) {
        echo "Novo professor registrado com sucesso";
    }
}

$conn->close();

?>

<form method="POST" action="add_professor.php">
    Nome: <input type="text" name="nome_professor" required>
    Formação: <input type="text" name="formacao" required>
    CPF: <input type="text" name="cpf" required>
    <input type="submit" value="adicionar">
</form>

<a href="index.php">visualizar diário</a>

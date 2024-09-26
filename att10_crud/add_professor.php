<?php

include 'bd.php';

if (isset($_POST["adicionar"])) {
    $nome = $_POST['nome_professor'];
    $formacao = $_POST['formacao'];
    $cpf = $_POST['cpf'];

    $sql = "INSERT INTO professores (nome_professor, formacao, cpf) VALUES ('$nome', '$formacao', '$cpf')";

    if ($conn->query($sql) === TRUE) {
        echo "Novo professor registrado com sucesso";
    }
}


$sql = "SELECT * FROM professores";
$result = $conn->query($sql);

// Exibindo a tabela de aulas
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID do Professor</th>
                <th>Nome do professor</th>
                <th>Formação</th>
                <th>CPF</th>
                <th>Ações</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id_professor']}</td>
                <td>{$row['nome_professor']}</td> 
                <td>{$row['formacao']}</td>
                <td>{$row['cpf']}</td>
                <td>
                    <form method='POST' action=''>
                        <input type='hidden' name='id_professor' value='{$row['id_professor']}'>
                        <input type='submit' name='delete' value='Deletar Dados'>
                    </form>
                    <form method='POST' action=''>
                        <input type='hidden' name='id_professor' value='{$row['id_professor']}'>
                        <input type='submit' name='alterar' value='Alterar Dados'>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum registro encontrado";
}

// Deletar após apertar o botão "Deletar Dados"
if (isset($_POST["delete"])) {
    if (isset($_POST['id_professor']) && !empty($_POST['id_professor'])) {
        $id_del = $_POST['id_professor']; // Obtém o ID da aula a ser deletada
        
        // Deletar da tabela `diario` e da tabela `aulas`
        $sql_delete_professor = "DELETE FROM professores WHERE id_professor = ?";
        
        // Preparar e executar a exclusão da tabela `professores`
        $stmt_del_professor = $conn->prepare($sql_delete_professor);
        $stmt_del_professor->bind_param('i', $id_del);
        $stmt_del_professor->execute();
        

        if ($stmt_del_professor->affected_rows > 0) {
            echo "Registro deletado com sucesso!";
        } else {
            echo "Erro ao deletar o registro.";
        }
    } else {
        echo "ID do professor não encontrado.";
    }
    header ("Location: add_professor.php");
    exit();
}


$conn->close();

?>

<form method="POST" action="add_professor.php">
    Nome: <input type="text" name="nome_professor" required>
    Formação: <input type="text" name="formacao" required>
    CPF: <input type="text" name="cpf" required>
    <input type="submit" name="adicionar">
</form>

    <a href="index.php"><button>Ver Quadro de Horário</button></a>
    <a href="add_aula.php"><button>Criar Aulas</button></a>
<?php
// Deve ser possível alterar o dado de um professor no banco de dados.
// Deve ser possível alerar os dados de uma aula no banco de dados. 
include "bd.php";

// Verifica se o formulário foi enviado


// Consulta SQL para exibir os registros do diário
$sql = "SELECT d.fk_professor, d.fk_aula, a.sala_aula, a.dia_aula, a.hora_aula, a.materia_aula, a.anotacoes, p.nome_professor 
        FROM aulas AS a 
        INNER JOIN diario AS d ON a.id_aula = d.fk_aula 
        INNER JOIN professores AS p ON d.fk_professor = p.id_professor";
$result = $conn->query($sql);

// Exibindo a tabela de aulas
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Id da Aula</th>
                <th>Dia da Aula</th>
                <th>Sala da Aula</th>
                <th>Hora da Aula</th>
                <th>Professor Responsável</th>
                <th>Matéria da Aula</th>
                <th>Anotações</th>
                <th>Ações</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['fk_aula']}</td>
                <td>{$row['dia_aula']}</td> 
                <td>{$row['sala_aula']}</td>
                <td>{$row['hora_aula']}</td>
                <td>{$row['nome_professor']}</td>
                <td>{$row['materia_aula']}</td>
                <td>{$row['anotacoes']}</td>
                <td>
                    <form method='POST' action=''>
                        <input type='hidden' name='id_aula' value='{$row['fk_aula']}'>
                        <input type='submit' name='alterar' value='Alterar Dados'>
                    </form>
                    </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum registro encontrado";
}

if (isset($_POST["alterar"])) {
    $id_update = $_POST["id_aula"]; // achando o valor do que foi clicado na tabela
    echo "ID da aula a ser alterada: $id_update";
}

// Consulta SQL para buscar os professores
$sql = "SELECT id_professor, nome_professor FROM professores";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
</head>
<body>
<br>



    </form>
    <a href="index.php"><button>Ver Quadro de Horário</button></a>
    <a href="add_professor.php"><button>Inserir Professor</button></a>

</body>
</html>



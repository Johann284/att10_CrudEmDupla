<?php
// Deve ser possível ver o quadro de horários com os dados da aula e tudo mais.

// Além disso, deve ser possível ir até uma página para inserir um professor ou aula.

// Ideia: no quadro de horário pode ser possível deletar o horário/aula.

// Ideia: no quadro de horário pode ser possível alterar o dado de uma aula


// nome Professor, ID do professor, dia da aula, sala da aula, ID da aula

// ============== READ ============== //

include 'bd.php';

$sql = "SELECT d.fk_professor, d.fk_aula, a.sala_aula, a.dia_aula, a.hora_aula, a.materia_aula, a.anotacoes, p.nome_professor 
        FROM aulas AS a 
        INNER JOIN diario AS d ON a.id_aula = d.fk_aula 
        INNER JOIN professores AS p ON d.fk_professor = p.id_professor";
$result = $conn->query($sql);

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
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['fk_aula']}</td>
                <td>{$row['dia_aula']}</td> 
                <td>{$row['sala_aula']}</td>
                <td>{$row['hora_aula']}</td>
                <td>{$row['nome_professor']}</td>
                <td>{$row['materia_aula']}</td>
                <td>{$row['anotacoes']}</td>
                <td>
                    <a href='alterar_dados.php?id={$row['fk_aula']}'>Editar</a>
                    <a href='deletar.php'>Excluir</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum registro encontrado";
}

$conn -> close();
?>

<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud em dupla</title>
</head>
<body>
    <h3>Quadro de Horário</h3>
    <a href="add_professor.php"><button>Adicionar Professor</button></a>
    <a href="add_aula.php"><button>Criar Aulas</button></a>

</body>
</html>
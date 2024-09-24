<?php 
include "bd.php";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sala_aula = $_POST['sala'];
    $dia = $_POST['dia'];
    $materia = $_POST['materia'];
    $hora = $_POST['hora'];
    $anotacoes = $_POST['anotacoes'];
    $professor_id = $_POST['professor']; // Agora estamos pegando o ID diretamente do select
    
    // Valida os campos
    if (empty($sala_aula) || empty($dia) || empty($materia) || empty($hora) || empty($anotacoes) || empty($professor_id)) {
        echo 'Valor inválido';
    } else {
        // Inserir os dados na tabela `aulas`
        $sql_aula = "INSERT INTO aulas (sala_aula, dia_aula, materia_aula, hora_aula, anotacoes) 
                     VALUES (?, ?, ?, ?, ?)";
        $stmt_aula = $conn->prepare($sql_aula);
        $stmt_aula->bind_param('sssss', $sala_aula, $dia, $materia, $hora, $anotacoes);
        $stmt_aula->execute();
        
        // Verifica se a aula foi inserida com sucesso
        if ($stmt_aula->affected_rows > 0) {
            // Obtém o ID da aula recém-inserida
            $id_aula = $stmt_aula->insert_id;

            // Inserir na tabela `diario` relacionando professor e aula
            $sql_diario = "INSERT INTO diario (fk_professor, fk_aula) VALUES (?, ?)";
            $stmt_diario = $conn->prepare($sql_diario);
            $stmt_diario->bind_param('ii', $professor_id, $id_aula);
            $stmt_diario->execute();

            if ($stmt_diario->affected_rows > 0) {
                echo "Novo registro criado com sucesso!";
            } else {
                echo "Erro ao inserir no diário.";
            }
        } else {
            echo "Erro ao inserir a aula.";
        }
    }
}

// Consulta SQL para exibir os registros do diário
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


    <form method="POST" action="">
        <label for="sala">Sala da Aula: </label>
        <input type="text" name="sala" required>
        
        <label for="dia">Dia da aula: </label>
        <select name="dia" required>
          <option value="Segunda-Feira">Segunda-Feira</option>
          <option value="Terca-Feira">Terça-Feira</option>
          <option value="Quarta-Feira">Quarta-Feira</option>
          <option value="Quinta-Feira">Quinta-Feira</option>
          <option value="Sexta-Feira">Sexta-Feira</option>
        </select>

        <label for="materia">Matéria da Aula: </label>
        <select name="materia" required>
          <option value="matematica">Matemática</option>
          <option value="portugues">Português</option>
          <option value="ingles">Inglês</option>
          <option value="historia">História</option>
          <option value="geografia">Geografia</option>
          <option value="filosofia">Filosofia</option>
          <option value="quimica">Química</option>
          <option value="fisica">Física</option>
          <option value="biologia">Biologia</option>
          <option value="ef">Educação Física</option>
          <option value="tecnico">Técnico</option>
        </select>

        <label for="professor">Professor</label>
        <select name="professor" required>
            <?php while ($professor = $result->fetch_assoc()): ?>
                <option value="<?= $professor['id_professor']; ?>">
                    <?= $professor['nome_professor']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="hora">Horário da Aula: </label>
        <input type="time" name="hora" required>

        <label for="anotacoes">Anotações da Aula: </label>
        <input type="text" name="anotacoes">

        <br>
        <input type="submit" value="Adicionar">
    </form>
    <a href="index.php"><button>Ver Quadro de Horário</button></a>
    <a href="add_professor.php"><button>Inserir Professor</button></a>

</body>
</html>

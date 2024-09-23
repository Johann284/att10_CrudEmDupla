<?php
// Deve ser possível inserir uma nova aula no banco de dados.

include"bd.php";
// este if está incompleto já que os dados estõa confusos e não sabemos os valores a serem inseridos na tabela "aulas"
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sala_aula = $_POST['sala'];
        $dia = $_POST['dia'];
        if($sala_aula == null || $dia == null){
            echo 'Valor inválido';
        } else {
            $sql = "INSERT INTO aulas (sala_aula,dia_aula) VALUE ('$sala_aula', '$dia')";
            if ($conn -> query($sql) === TRUE){
                echo "Novo resgistro criado com sucesso!";
            }else{
                echo "Erro" . $sql . "<br>" . $conn -> error;
            }
        } 
    }

 $conn -> close();
?>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
</head>
<body>
    
    <form method="POST" action="">
        <label for="sala">Sala da Aula: </label>
        <input type="text" name="sala" require>
        <label for="dia">Dia da aula: </label>

        <select name="dia" require>
          <option value="segundaFeira">Segunda-Feira:</option>
          <option value="tercaFeira">Terça-Feira</option>
          <option value="quartaFeira">Quarta-Feira</option>
          <option value="quintaFeira">Quinta-Feira</option>
          <option value="sextaFeira">Sexta-Feira</option>
        </select>

        <label for="materia">Matéria da Aula: </label>
        <select name="dia" require>
          <option value="matematica">Matemática:</option>
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

        <label for="hora">Sala da Aula: </label>
        <input type="time" name="hora" require>
        <br>
        <input type="submit" value="Adicionar">
    </form>

    <a href="index.php"><button>Ver Quadro de horário.</button></a>
    <a href="add_professor.php"><button>Inserir Professor.</button></a>


</body>
</html>
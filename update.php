<?php

    include 'db.php';

    // Buscar times para o select
    $times = [];
    $times_result = $conn->query("SELECT id, nome FROM times");
    while ($t = $times_result->fetch_assoc()) {
        $times[] = $t;
    }

    // Posições válidas
    $posicoes = ['Goleiro', 'Zagueiro', 'Lateral', 'Meio-campo', 'Atacante'];

    $id = $_GET['id'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $name = $_POST['name'];
        $posicao = $_POST['posição'];
        $numero_camisa = $_POST['número_camisa'];
        $id_time = $_POST['id_time'];

        // Validação de posição e número da camisa
        if (!in_array($posicao, $posicoes)) {
            die("Posição inválida.");
        }
        if ($numero_camisa < 1 || $numero_camisa > 99) {
            die("Número da camisa deve ser entre 1 e 99.");
        }

        $sql = "UPDATE jogadores SET name ='$name', posição ='$posicao', número_camisa ='$numero_camisa', id_time='$id_time' WHERE id = $id";

        if($conn ->query($sql) === true){
            echo "Registro editado com sucesso.";
        }else{
            echo "Erro" . $sql . "<br>" . $conn->error;
        }

        $conn -> close();
        header("Location: read.php");
        exit();
    }

    $sql = "SELECT * FROM jogadores WHERE id=$id";
    $result = $conn -> query($sql);
    $row = $result -> fetch_assoc();

?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Jogador</title>
</head>
<body>
    <form action="update.php?id=<?php echo $row['id'];?>" method="POST">
        <label for="name">Nome:</label>
        <input type="text" name="name" value="<?php echo $row['name'];?>" required><br>
        <label for="posição">Posição:</label>
        <select name="posição" required>
            <option value="">Selecione</option>
            <?php foreach ($posicoes as $p): ?>
                <option value="<?php echo $p; ?>" <?php if($row['posição'] == $p) echo 'selected'; ?>><?php echo $p; ?></option>
            <?php endforeach; ?>
        </select><br>
        <label for="número_camisa">Número da camisa:</label>
        <input type="number" name="número_camisa" min="1" max="99" value="<?php echo $row['número_camisa'];?>" required><br>
        <label for="id_time">Time:</label>
        <select name="id_time" required>
            <option value="">Selecione</option>
            <?php foreach ($times as $time): ?>
                <option value="<?php echo $time['id']; ?>" <?php if($row['id_time'] == $time['id']) echo 'selected'; ?>><?php echo $time['nome']; ?></option>
            <?php endforeach; ?>
        </select><br>
        <input type="submit" value="Atualizar">
    </form>
</body>
</html>
<?php
    include 'db.php';

    // Buscar times para o select
    $times = [];
    $times_result = $conn->query("SELECT id, nome FROM times");
    while ($t = $times_result->fetch_assoc()) {
        $times[] = $t;
    }

    $posicoes = ['Goleiro', 'Zagueiro', 'Lateral', 'Meio-campo', 'Atacante'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nome = $_POST['name'];
        $posicao = $_POST['posicao'];
        $numero_camisa = $_POST['numero_camisa'];
        $time_id = $_POST['time_id'];

        if (!in_array($posicao, $posicoes)) {
            die("Posição inválida.");
        }
        if ($numero_camisa < 1 || $numero_camisa > 99) {
            die("Número da camisa deve ser entre 1 e 99.");
        }

        $sql = "INSERT INTO jogadores (nome, posicao, numero_camisa, time_id) VALUES ('$nome', '$posicao', '$numero_camisa', '$time_id')";

        if($conn->query($sql) === true){
            $conn->close();
            header("Location: read.php");
            exit();
        }else{
            echo "Erro: " . $sql . "<br>" . $conn->error;
            $conn->close();
        }
    }
?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Jogador</title>
</head>
<body>
    <form method="POST" action="create.php">
        <label for="name">Nome:</label>
        <input type="text" name="name" required><br>
        <label for="posicao">Posição:</label>
        <select name="posição" required>
            <option value="">Selecione</option>
            
            <?php foreach ($posicoes as $p): ?>
                <option value="<?php echo $p; ?>"><?php echo $p; ?></option>
            <?php endforeach; ?>
        </select><br>
        <label for="número_camisa">Número da camisa:</label>
        <input type="number" name="número_camisa" min="1" max="99" required><br>
        <label for="time_id">Time:</label>
        <select name="time_id" required>
            <option value="">Selecione</option>
            <?php foreach ($times as $time): ?>
                <option value="<?php echo $time['id']; ?>"><?php echo $time['nome']; ?></option>
            <?php endforeach; ?>
        </select><br>
        <input type="submit" value="Cadastrar">
    </form>
    <a href="read.php">Ver jogadores</a>
</body>
</html>
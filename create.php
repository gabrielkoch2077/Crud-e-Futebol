<?php
    include 'db.php';

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
  
    <a href="read.php">Painel de controle</a>
</body>
</html>
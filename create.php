<?php
include 'db.php';

$times = [];
$times_result = $conn->query("SELECT id, nome FROM times");
while ($t = $times_result->fetch_assoc()) {
    $times[] = $t;
}

$posicoes = ['Goleiro', 'Zagueiro', 'Lateral', 'Meio-campo', 'Atacante'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    if ($conn->query($sql) === true) {
        $conn->close();
        header("Location: read.php");
        exit();
    } else {
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
    <style>
        .painel-btn {
            display: inline-block;
            padding: 40px 28px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 30px;
            font-weight: bold;
            transition: background 0.2s;
            margin-top: 20px;
        }

        .painel-btn:hover {
            background-color: #0056b3;
        }

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>

<body>
    <div class="center">
        <a href="read.php" class="painel-btn">Painel de Controle</a>
</body>

</html>
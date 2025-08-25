<?php

include 'db.php';


$times = [];
$times_result = $conn->query("SELECT id, nome FROM times");
while ($t = $times_result->fetch_assoc()) {
    $times[] = $t;
}


$posicoes = ['Goleiro', 'Zagueiro', 'Lateral', 'Meio-campo', 'Atacante'];


echo '
<form action="create.php" method="POST">
    <h3>Inserir novo jogador</h3>
    <label>Nome: <input type="text" name="name" required></label><br>
    <label>Posição:
        <select name="posicao" required>
            <option value="">Selecione</option>';
foreach ($posicoes as $p) {
    echo "<option value=\"$p\">$p</option>";
}
echo '  </select>
    </label><br>
    <label>Número da camisa: <input type="number" name="numero_camisa" min="1" max="99" required></label><br>
    <label>Time:
        <select name="time_id" required>
            <option value="">Selecione</option>';
foreach ($times as $time) {
    echo "<option value=\"{$time['id']}\">{$time['nome']}</option>";
}
echo '  </select>
    </label><br>
    <input type="submit" value="Cadastrar">
</form>
<hr>
';


$sql = "SELECT jogadores.*, times.nome as nome_time FROM jogadores 
        LEFT JOIN times ON jogadores.time_id = times.id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Posição</th>
            <th>Número da camisa</th>
            <th>Time</th>
            <th>Ações</th>
        </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nome']}</td>
                <td>{$row['posicao']}</td>
                <td>{$row['numero_camisa']}</td>
                <td>{$row['nome_time']}</td>
                <td>
                    <a href='update.php?id={$row['id']}'>Editar</a> |
                    <a href='delete.php?id={$row['id']}'>Excluir</a>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum registro encontrado.";
}

?>

<?php
echo '
<form action="" method="POST">
    <h3>Criar confronto entre dois times</h3>
    <label>Time 1:
        <select name="time1" required>
            <option value="">Selecione</option>';
foreach ($times as $time) {
    echo "<option value=\"{$time['id']}\">{$time['nome']}</option>";
}
echo '  </select>
    </label><br>
    <label>Time 2:
        <select name="time2" required>
            <option value="">Selecione</option>';
foreach ($times as $time) {
    echo "<option value=\"{$time['id']}\">{$time['nome']}</option>";
}
echo '  </select>
    </label><br>
    <input type="submit" value="Montar Confronto">
</form>
<hr>
';

if (
    isset($_POST['time1']) && isset($_POST['time2']) &&
    $_POST['time1'] != "" && $_POST['time2'] != "" && $_POST['time1'] != $_POST['time2'] &&
    !isset($_POST['descartar'])
) {
    $time1_id = intval($_POST['time1']);
    $time2_id = intval($_POST['time2']);

  
    $nome1 = $nome2 = '';
    foreach ($times as $t) {
        if ($t['id'] == $time1_id) $nome1 = $t['nome'];
        if ($t['id'] == $time2_id) $nome2 = $t['nome'];
    }
   
    $jogadores1 = [];
    $res1 = $conn->query("SELECT nome, posicao, numero_camisa FROM jogadores WHERE time_id = $time1_id");
    while ($j = $res1->fetch_assoc()) $jogadores1[] = $j;

    $jogadores2 = [];
    $res2 = $conn->query("SELECT nome, posicao, numero_camisa FROM jogadores WHERE time_id = $time2_id");
    while ($j = $res2->fetch_assoc()) $jogadores2[] = $j;

    echo "<div style='display: flex; justify-content: flex-start; margin-top: 30px;'>";
echo "<div style='text-align: center; min-width: 400px;'>";
   
    echo "<h3>$nome1</h3>";
    echo "<ul style='list-style: none; padding: 0;'>";
    foreach ($jogadores1 as $j) {
        echo "<li>{$j['nome']} ({$j['posicao']}, {$j['numero_camisa']})</li>";
    }
    echo "</ul>";

  
    echo "<div style='font-size: 2em; font-weight: bold; margin: 20px 0;'>X</div>";

    
    echo "<h3>$nome2</h3>";
    echo "<ul style='list-style: none; padding: 0;'>";
    foreach ($jogadores2 as $j) {
        echo "<li>{$j['nome']} ({$j['posicao']}, {$j['numero_camisa']})</li>";
    }
    echo "</ul>";
echo "</div>";
echo "</div>";


echo '
<form method="POST" style="text-align:left; margin-top:20px;">
    <input type="submit" name="descartar" value="Descartar Confronto">
</form>
';
}
$conn->close();
?>

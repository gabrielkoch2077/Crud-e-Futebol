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

// Formulário para inserir novo jogador
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

// Consulta correta para o banco fornecido
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
$conn->close();
?>
<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "futebol_db";


$conn = new mysqli($servername,$username,$password,$dbname);

if ($conn->connect_error) {
    die("Conexao Falhou: " . $conn -> connect_error);
}

?>
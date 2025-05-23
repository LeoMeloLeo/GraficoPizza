<?php
header('Content-Type: application/json');

// Conexão com o banco de dados
$mysqli = new mysqli("localhost", "root", "", "cadastro");
//ou voce pode alterar para as configurações do seu servidor
//como: "ip do server", "user do mysql" "senha do user do mysql","nome do banco de dados mysql"

if ($mysqli->connect_error) {
    die(json_encode(["Sem dados" => 0]));
}

// Captura dos parâmetros
$funcao = $_GET['funcao'] ?? '';
$turma = $_GET['turma'] ?? '';

// Construção da consulta
$sql = "SELECT turma, COUNT(*) as total FROM registros WHERE 1=1";

if ($funcao !== '') {
    $sql .= " AND funcao = '" . $mysqli->real_escape_string($funcao) . "'";
}

if ($turma !== '') {
    $sql .= " AND turma = '" . $mysqli->real_escape_string($turma) . "'";
}

$sql .= " GROUP BY turma";

// Execução e tratamento dos resultados
$result = $mysqli->query($sql);
$dados = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $dados[$row['turma']] = (int)$row['total'];
    }
}

if (empty($dados)) {
    $dados = ["Sem dados" => 0];
}

echo json_encode($dados);
?>
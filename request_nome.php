<?php
// Informações de conexão com o banco de dados
$servername = "189.22.56.82:10336";
$username = "SCMAdmin";
$password = "Scm@2023!";
$dbname = "projetoscm";

// Código RFID recebido via método GET
$cod_rfid = $_GET['cod_rfid'];

// Cria uma conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi estabelecida com sucesso
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Prepara a consulta SQL com um espaço reservado para o código RFID
$sql = "SELECT nome FROM tb_usuario WHERE cod_rfid = ?";

// Prepara uma instrução SQL com a consulta
$stmt = $conn->prepare($sql);

// Vincula o parâmetro cod_rfid ao espaço reservado
$stmt->bind_param("s", $cod_rfid);

// Executa a consulta
$stmt->execute();

// Armazena o resultado da consulta
$stmt->bind_result($nome);

// Verifica se a consulta retornou resultados
if ($stmt->fetch()) {
    echo "Nome do usuario:" . $nome;
} else {
    echo "Nome do usuario:Sem usuario";
}

// Fecha a instrução e a conexão com o banco de dados
$stmt->close();
$conn->close();
?>

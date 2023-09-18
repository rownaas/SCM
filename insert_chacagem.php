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
$sql_select = "SELECT cod_usuario FROM tb_usuario WHERE cod_rfid = ?";

// Prepara uma instrução SQL com a consulta
$stmt_select = $conn->prepare($sql_select);

// Vincula o parâmetro cod_rfid ao espaço reservado
$stmt_select->bind_param("s", $cod_rfid);

// Executa a consulta
$stmt_select->execute();

// Armazena o resultado da consulta
$stmt_select->bind_result($cod_usuario);

// Verifica se a consulta retornou resultados
if ($stmt_select->fetch()) {
    // Agora que temos o código do usuário, podemos inserir os dados na tabela tb_checagem
    date_default_timezone_set('America/Sao_Paulo');
    $data_ponto = date("Y-m-d");
    $hora_ponto = date("H:i:s");

    $stmt_select->close(); // Feche a consulta de seleção

    $sql_insert = "INSERT INTO tb_checagem (cod_rfid, cod_usuario, data_ponto, hora_ponto) VALUES (?, ?, ?, ?)";

    // Prepara a instrução SQL para a inserção
    $stmt_insert = $conn->prepare($sql_insert);

    // Vincula os parâmetros aos espaços reservados
    $stmt_insert->bind_param("ssss", $cod_rfid, $cod_usuario, $data_ponto, $hora_ponto);

    // Executa a inserção
    if ($stmt_insert->execute()) {
        echo "Registro de checagem inserido com sucesso!";
    } else {
        echo "Erro ao inserir registro de checagem: " . $conn->error;
    }

    // Fecha a instrução de inserção
    $stmt_insert->close();
    
} else {
    echo "Nome do usuário: Sem usuário";
}


// Fecha a instrução de consulta e a conexão com o banco de dados
$stmt_select->close();
$conn->close();
?>

<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: login.html');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<div class="container mt-5">
    <h2>Menu Principal</h2>
    <ul class="list-group mt-4">
        <li class="list-group-item"><a href="admin.php">Video do Consulta Preço</a></li>
        <li class="list-group-item"><a href="config_page.php">Configurações</a></li>
    </ul>
</div>
</body>
</html>
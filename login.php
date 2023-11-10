<?php

session_start();

$user = $_POST['user'];
$pass = $_POST['pass'];

// Verificando usuário e senha
if ($user == 'usuario' && $pass == 'senha') {
    $_SESSION['logado'] = true;
    header("Location: menu.php");
} else {
    echo "Login ou senha inválidos!";
}

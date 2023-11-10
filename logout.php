<?php
session_start();
unset($_SESSION['logado']);  // remove a chave 'logado' da sessão
session_destroy();  // destrói a sessão
header('Location: login.html');  // redireciona para a página de login
exit;
?>

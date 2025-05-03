<?php
require_once '../classes/Auth.php';
// Inicia a sessão e destrói
Auth::destruirSessao();

// Redireciona para a página de login
header('Location: ../index.html');
exit();
?>
<?php
require_once __DIR__ . '/../classes/Usuario.php';
require_once __DIR__ . '/../classes/Auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $usuario = new Usuario();
    if ($usuario->autenticar($email, $senha)) {
        Auth::iniciarSessao($usuario);
        
        // Redireciona com base no email
        if ($email === 'adm@freela.com') {
            header('Location: excluir.php');
        } else {
            header('Location: atualizar_cadastro.php');
        }
        exit();
    }
    
    // Se chegou aqui, o login falhou
    session_start();
    $_SESSION['erro_login'] = 'Email ou senha incorretos';
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FreelaHub</title>
    <link rel="stylesheet" href="css/inner_pages.css" />
</head>
<body>
    <h1>Login - FreelaHub</h1>
    
    <div class="info-box">
        <p>Bem-vindo ao FreelaHub. Faça login para acessar sua conta.</p>
    </div>
    
    <div class="login-form">
        <form id="loginForm" action="login.php" method="POST">

            
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            
            <button type="submit">Entrar</button>
        </form>
        
        <div class="register-link">
            <p>Não tem uma conta? <a href="cadastro.php">Crie uma agora</a></p>
            <a href="../index.html">Ir para página inicial</a>
        </div>
    </div>
</body>
</html>
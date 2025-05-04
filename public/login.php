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
    <link rel="stylesheet" href="../public/css/style.css" />
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="logo-02">
            <img src="../public/images/logo02.png" alt="Logo FreelaHub" />
        </div>
        
        <ul class="nav-links">
            <li><a href="../index.html">Início</a></li>
            <li><a href="cadastro.php">Cadastro</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="consultar.php">Explorar</a></li>
        </ul>
    </nav>

    <!-- LOGIN CONTAINER -->
    <section class="login-container">
        <div class="login-box">
            <div class="login-logo">
                <img src="../public/images/logo01.png" alt="FreelaHub Logo">
                <h1>FreelaHub</h1>
            </div>

            <?php if (isset($_SESSION['erro_login'])): ?>
                <div class="error-message">
                    <?php echo $_SESSION['erro_login']; unset($_SESSION['erro_login']); ?>
                </div>
            <?php endif; ?>

            <form id="loginForm" action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                
                <button type="submit" class="login-button">Entrar</button>
            </form>
            
            <div class="register-link">
                <p>Não tem uma conta? <a href="cadastro.php">Crie uma agora</a></p>
                <a href="../index.html" class="home-link">Ir para página inicial</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="site-footer">
        <p> © 2025 | FreelaHub</p>
    </footer>
</body>
</html>
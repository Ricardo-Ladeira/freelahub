<?php
require_once __DIR__ . '/../classes/Usuario.php';
require_once __DIR__ . '/../classes/Perfil.php';
require_once __DIR__ . '/../classes/Explorador.php';
require_once __DIR__ . '/../classes/Auth.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
Auth::verificarSessao();
$usuarioLogado = Auth::getUsuarioLogado();
// $id = ($_SESSION['usuario_id']);
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['campo'])) {
    $usuario = new Usuario();
    $perfil = new Perfil();
    $campo = ($_POST['campo']);
    if($campo=='id')
    {
    $id = $_POST['valor'];
    }else{
        $explorar = new Explorador();
        $valor = $explorar->buscarIdPorEmail($_POST['valor']);
        $id = $valor[0]['id'];
    }
    if($usuario->carregar($id) && $perfil->carregar($usuario->getPerfilId())){
        $usuario->excluir();
        $perfil->excluir();
}
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta e Exclusão de Dados - FreelaHub</title>
    <link rel="stylesheet" href="./css/cadastro_pages.css" />
    <link rel="stylesheet" href="./css/excluir_pages.css" />
    
</head>
<body>
    <h1>Exclusão de Dados FreelaHub</h1>
    
    <div class="info-box">
        <p>Utilize este painel para excluir usuários e perfis cadastrados no sistema.</p>
    </div>
    
    <div class="warning-box">
        <p>Atenção: A exclusão de usuários é permanente e não pode ser desfeita. Tenha certeza antes de prosseguir.</p>
    </div>
        <?php if ($msg): ?>
        <div class="<?= strpos($msg, 'Sucesso') !== false ? 'success' : 'error' ?>"><?= $msg ?></div>
        <?php endif; ?>

    
    <div class="excluir-form">
        <h2>Excluir Usuário</h2>
        <form action="excluir.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.');">
            <div class="form-group">
                <label for="campo">Buscar usuário por:</label>
                <select name="campo" id="campo" required>
                    <option value="">-- Selecione --</option>
                    <option value="id">ID</option>
                    <option value="email">E-mail</option>
                    <option value="telefone">Telefone</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="valor">Valor:</label>
                <input type="text" name="valor" id="valor" required placeholder="Digite o ID, e-mail ou telefone">
            </div>
            
            <button type="submit" class="btn-danger">Excluir Usuário</button>
        </form>
    </div>
        <div class="login-link">
            <p>Tudo OK? <a href="../index.html">Ir para página inicial</a></p>
            <a  href="logout.php">Logout</a>
        </div>
</body>
</html>
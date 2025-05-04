<?php
require_once __DIR__ . '/../classes/Usuario.php';
require_once __DIR__ . '/../classes/Perfil.php';
require_once __DIR__ . '/../classes/Explorador.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Crud.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
Auth::verificarSessao();
$usuarioLogado = Auth::getUsuarioLogado();
$msg = '';
$crud = new Crud();
$resultados = $crud->SelectAll ('usuario');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['campo'])) {
    $usuario = new Usuario();
    $perfil = new Perfil();
    $campo = $_POST['campo'];
    if ($campo == 'id') {
        $id = $_POST['valor'];
    } else {
        $explorar = new Explorador();
        $valor = $explorar->buscarIdPorEmail($_POST['valor']);
        $id = $valor[0]['id'];
    }
    if ($usuario->carregar($id) && $perfil->carregar($usuario->getPerfilId())) {
        $usuario->excluir();
        $perfil->excluir();
        $msg = "Usuário excluído com sucesso.";
        header('Location: excluir.php');
    } else {
        $msg = "Erro ao excluir o usuário. Verifique os dados.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir - FreelaHub</title>
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

    <!-- CONTAINER PRINCIPAL -->
    <section class="register-container">
        <div class="register-box">
            <div class="register-header">
                <img src="../public/images/logo01.png" alt="FreelaHub Logo">
                <h1>FreelaHub</h1>
                <p>Excluir Usuário</p>
            </div>
            <div class="warning-box">
                <p>Utilize este painel para excluir usuários e perfis cadastrados no sistema.</p>
            </div>
            <div class="danger-box">
                <p><strong>Atenção:</strong> A exclusão é <u>permanente</u> e não pode ser desfeita.</p>
            </div>
            <?php if ($msg): ?>
        <div class="<?= strpos($msg, 'sucesso') !== false ? 'success' : 'error' ?>">
          <?= htmlspecialchars($msg) ?>
        </div>
      <?php endif; ?>

      <div class="excluir-form">
        <h2>Excluir Usuário</h2>
        <form method="POST" onsubmit="return confirm('Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.');">
          <div class="form-group">
            <label for="campo">Buscar por:</label>
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

          <button type="submit" class="delete-button">Excluir Usuário</button>
        </form>
      </div>

      <div class="login-link">
        <p>Voltar para: 
          <a href="../index.html">Página Inicial</a> | 
          <a href="logout.php">Logout</a>
        </p>
      </div>
    </div>
        </div>

         <!-- RESULTADOS -->
        <?php if (!empty($resultados)): ?>
            <div class="results-box">
                <h2>Resultados da Busca</h2>
                
                <div class="professionals-grid">
                    <?php foreach ($resultados as $perfil): ?>
                        <div class="professional-card">
                            <div class="card-header">
                                <h3><?= htmlspecialchars($perfil['u_nome'] ?? '') ?></h3>
                                <h3 class="service-tag"><?= "ID - ".htmlspecialchars($perfil['id'] ?? '') ?></h3>
                            </div>
                            

                            <div class="card-footer">
                                    <p style="color:#fbbc05";>Email</p>
                                    <?="<p style='color:black'>".$perfil['u_email']."</p>"?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
       
    </section>

    <!-- FOOTER -->
    <footer class="site-footer">
        <p> © 2025 | FreelaHub</p>
    </footer>
</body>
</html>
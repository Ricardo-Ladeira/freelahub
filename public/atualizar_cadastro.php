<?php
require_once __DIR__ . '/../classes/Usuario.php';
require_once __DIR__ . '/../classes/Perfil.php';
require_once __DIR__ . '/../classes/Auth.php';

Auth::verificarSessao();
$usuarioLogado = Auth::getUsuarioLogado();
$id = ($_SESSION['usuario_id']);

$msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
unset($_SESSION['msg']);

$usuario = new Usuario();
$perfil = new Perfil();

$temUsuario = $usuario->carregar($id);
if ($temUsuario) {
    $perfil->carregar($usuario->getPerfilId());
    $valores = [
        'email' => $usuario->getEmail(),
        'nome' => $usuario->getNome(),
        'data_nascimento' => $usuario->getdataNascimento(),
        'cidade' => $usuario->getCidade(),
        'uf' => $usuario->getUf(),
        'telefone' => $perfil->getTelefone(),
        'tipo_servico' => $perfil->getTipoServico(),
        'descricao_servico' => $perfil->getDescricaoServico(),
        'experiencia' => $perfil->getExperiencia(),
    ];
}

// Processar exclusão do usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_usuario'])) {
    if ($usuario->excluir() && $perfil->excluir()) {
        $_SESSION['msg'] = 'Usuário excluído com sucesso!';
        header('Location: ../index.html');
        exit();
    } else {
        $msg = 'Erro ao excluir usuário. Por favor, tente novamente.';
    }
}

// Processar atualização do cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
    foreach ($valores as $campo => $valor) {
        if (isset($_POST[$campo])) {
            $valores[$campo] = htmlspecialchars($_POST[$campo]);
        }
    }

    $usuario->setEmail($_POST['email'])
            ->setNome($_POST['nome'])
            ->setDataNascimento($_POST['data_nascimento'])
            ->setCidade($_POST['cidade'])
            ->setUf($_POST['uf']);
    
    if ($usuario->salvar()) {
        $perfil->setUsuarioId($usuario->getId())
               ->setTelefone($_POST['telefone'])
               ->setTipoServico($_POST['tipo_servico'])
               ->setDescricaoServico($_POST['descricao_servico'])
               ->setExperiencia($_POST['experiencia']);
        
        if ($perfil->salvar()) {
            $msg = "Cadastro alterado com sucesso";
        } else {
            $msg = 'Erro ao salvar perfil. Por favor, tente novamente.';
        }
    } else {
        $msg = 'Erro ao criar usuário. Verifique os dados e tente novamente.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Cadastro - FreelaHub</title>
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
    <section class="profile-container">
        <div class="profile-box">
            <div class="profile-header">
                <img src="../public/images/logo03.png" alt="Ícone de perfil">
                <h2>Olá, <?= htmlspecialchars($usuarioLogado->getNome()) ?>!</h2>
                <p>Atualize seus dados pessoais e profissionais abaixo</p>
            </div>

            <?php if ($msg): ?>
                <div class="<?= strpos($msg, 'sucesso') !== false ? 'success-message' : 'error-message' ?>">
                    <?= $msg ?>
                </div>
            <?php endif; ?>

            <form id="cadastroForm" method="POST" class="profile-form">
                <fieldset>
                    <legend>Dados Pessoais</legend>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nome">Nome Completo:</label>
                            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($valores['nome']) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="data_nascimento">Data de Nascimento:</label>
                            <input type="date" id="data_nascimento" name="data_nascimento" value="<?= htmlspecialchars($valores['data_nascimento']) ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($valores['email']) ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cidade">Cidade:</label>
                            <input type="text" id="cidade" name="cidade" value="<?= htmlspecialchars($valores['cidade']) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="uf">UF:</label>
                            <input type="text" id="uf" name="uf" maxlength="2" value="<?= htmlspecialchars($valores['uf']) ?>" required>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Dados Profissionais</legend>
                    
                    <div class="form-group">
                        <label for="telefone">Telefone:</label>
                        <input type="tel" id="telefone" name="telefone" value="<?= htmlspecialchars($valores['telefone']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="tipo_servico">Tipo de Serviço:</label>
                        <input type="text" id="tipo_servico" name="tipo_servico" value="<?= htmlspecialchars($valores['tipo_servico']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="experiencia">Nível de Experiência:</label>
                        <select id="experiencia" name="experiencia" required>
                            <option value="">Selecione</option>
                            <option value="Iniciante" <?= $valores['experiencia'] == 'Iniciante' ? 'selected' : '' ?>>Iniciante</option>
                            <option value="Intermediário" <?= $valores['experiencia'] == 'Intermediário' ? 'selected' : '' ?>>Intermediário</option>
                            <option value="Avançado" <?= $valores['experiencia'] == 'Avançado' ? 'selected' : '' ?>>Avançado</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="descricao_servico">Descrição do Serviço:</label>
                        <textarea id="descricao_servico" name="descricao_servico" rows="4" required><?= htmlspecialchars($valores['descricao_servico']) ?></textarea>
                    </div>
                </fieldset>

                <div class="form-actions">
                    <button type="submit" class="update-button">Atualizar Cadastro</button>
                    
                    <div class="warning-box">
                        <p>Atenção: A exclusão da conta é permanente e irreversível.</p>
                        <button type="submit" form="deleteForm" class="delete-button" 
                                onclick="return confirm('Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.')">
                            Excluir Minha Conta
                        </button>
                    </div>
                </div>
            </form>

            <form id="deleteForm" method="POST" style="display: none;">
                <input type="hidden" name="excluir_usuario" value="1">
            </form>

            <div class="profile-footer">
                <a href="../index.html" class="home-link">Página Inicial</a>
                <a href="logout.php" class="logout-link">Sair</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="site-footer">
        <p> © 2025 | FreelaHub</p>
    </footer>
</body>
</html>
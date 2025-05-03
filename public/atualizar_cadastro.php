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
    <title>Cadastro - FreelaHub</title>
    <link rel="stylesheet" href="css/cadastro_pages.css" />
</head>
<body>

    <h1>Cadastro - FreelaHub</h1>
    <h4 style="text-align: center;">Olá, <?= htmlspecialchars($usuarioLogado->getNome()) ?>!</h4>
    <div class="info-box">
        <p>Preencha o formulário abaixo para atualizar sua conta e perfil de freelancer.</p>
    </div>
    
    <?php if ($msg): ?>
        <div class="<?= strpos($msg, 'sucesso') !== false ? 'success' : 'error' ?>"><?= $msg ?></div>
    <?php endif; ?>
    
    <div class="cadastro-form">
        <form id="cadastroForm" method="POST">
            <h2>Dados Pessoais</h2>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="nome">Nome Completo:</label>
                    <input type="text" id="nome" name="nome" value="<?= $valores['nome'] ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento:</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" value="<?= $valores['data_nascimento'] ?>" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" value="<?= $valores['email'] ?>" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="cidade">Cidade:</label>
                    <input type="text" id="cidade" name="cidade" value="<?= $valores['cidade'] ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="uf">UF:</label>
                    <input type="text" id="uf" name="uf" value="<?= $valores['uf'] ?>" required>
                </div>
            </div>
            
            <h2>Dados Profissionais</h2>
            
            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" value="<?= $valores['telefone'] ?>" required>
            </div>
            
            <div class="form-group">
                <label for="tipo_servico">Tipo de Serviço:</label>
                <input type="text" id="tipo_servico" name="tipo_servico" value="<?= $valores['tipo_servico'] ?>" required>
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
                <textarea id="descricao_servico" name="descricao_servico" rows="4" required><?= $valores['descricao_servico'] ?></textarea>
            </div>
            
            <button type="submit">Atualizar Cadastro</button>
        </form>
        
        <div class="warning-box">
            <p>Atenção: A exclusão da conta é permanente e irreversível. Todos os seus dados serão perdidos.</p>
        </div>
        
        <form method="POST" onsubmit="return confirm('Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.');">
            <input type="hidden" name="excluir_usuario" value="1">
            <button type="submit" class="btn-danger">Excluir Minha Conta</button>
        </form>
        
        <div class="login-link">
            <p>Tudo OK? <a href="../index.html">Ir para página inicial</a></p>
            <a  href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
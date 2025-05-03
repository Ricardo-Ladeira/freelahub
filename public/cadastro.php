<?php
require_once __DIR__ . '/../classes/Usuario.php';
require_once __DIR__ . '/../classes/Perfil.php';


$erro = '';
$valores = [
    'email' => '',
    'nome' => '',
    'data_nascimento' => '',
    'cidade' => '',
    'uf' => '',
    'telefone' => '',
    'tipo_servico' => '',
    'descricao_servico' => '',
    'experiencia' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Manter valores submetidos em caso de erro
    foreach ($valores as $campo => $valor) {
        if (isset($_POST[$campo])) {
            $valores[$campo] = htmlspecialchars($_POST[$campo]);
        }
    }
        $perfil = new Perfil();
        $perfil ->setTelefone($_POST['telefone'])
                ->setTipoServico($_POST['tipo_servico'])
                ->setDescricaoServico($_POST['descricao_servico'])
                ->setExperiencia($_POST['experiencia']);
        if($perfil->salvar()){
                $usuario = new Usuario();
                $usuario->setEmail($_POST['email'])
                ->setNome($_POST['nome'])
                ->setSenha($_POST['senha'])
                ->setDataNascimento($_POST['data_nascimento'])
                ->setCidade($_POST['cidade'])
                ->setPerfilId($perfil->getId())
                ->setUf($_POST['uf']);

        if ($usuario->salvar()) {
            header('Location: login.php');
            exit();
        } else {
            $erro = 'Erro ao salvar usuário. Por favor, tente novamente.';
        }
    } else {
        $erro = 'Erro ao criar perfil. Verifique os dados e tente novamente.';
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
    
    <div class="info-box">
        <p>Preencha o formulário abaixo para criar sua conta e perfil de freelancer.</p>
    </div>
    
    <?php if ($erro): ?>
        <div class="error"><?= $erro ?></div>
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
                
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
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
            
            <button type="submit">Cadastrar</button>
        </form>
        
        <div class="login-link">
            <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
            <a href="../index.html">Ir para página inicial</a>
        </div>
    </div>
</body>
</html>

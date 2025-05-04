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
        $id_perfil = $perfil->salvar();
        if($id_perfil){
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
            $erro = 'Erro ao salvar usuário. Por favor, verifique seu email e tente novamente.';
            $perfil->excluir($id_perfil);
        }
    } else {
        $erro = 'Erro ao criar perfil. Verifique seu telefone e tente novamente.';
    }
}



?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - FreelaHub</title>
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
                <p>Crie sua conta de freelancer</p>
            </div>

            <?php if ($erro): ?>
                <div class="error-message">
                    <?= $erro ?>
                </div>
            <?php endif; ?>

            <form id="cadastroForm" method="POST" class="register-form">
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
                        
                        <div class="form-group">
                            <label for="senha">Senha:</label>
                            <input type="password" id="senha" name="senha" required>
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

                <button type="submit" class="register-button">Cadastrar</button>
                
                <div class="login-link">
                    <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
                    <a href="../index.html" class="home-link">Ir para página inicial</a>
                </div>
            </form>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="site-footer">
        <p> © 2025 | FreelaHub</p>
    </footer>
</body>
</html>
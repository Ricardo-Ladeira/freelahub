<?php
require_once __DIR__ . '/../classes/Explorador.php';

$resultados = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['servico'])) {
    $explorador = new Explorador();
    $servico = $_GET['servico'] ?? '';
    $cidade = $_GET['cidade'] ?? '';
    $uf = $_GET['uf'] ?? '';
    if ($servico == "" or $servico == "*") $servico = "%";
    $resultados = $explorador->buscarPorServico($servico, $cidade, $uf);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de Profissionais - FreelaHub</title>
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
    <section class="search-container">
        <div class="search-box">
            <div class="search-header">
                <img src="../public/images/logo03.png" alt="FreelaHub Logo">
                <h1>Encontre Profissionais</h1>
                <p>Busque os melhores freelancers para seu projeto</p>
            </div>

            <div class="search-form">
                <form method="GET" action="consultar.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="servico">Tipo de Serviço:</label>
                            <input type="text" name="servico" id="servico" 
                                   placeholder="Ex: Pintura, Design, Desenvolvimento" 
                                   value="<?= htmlspecialchars($_GET['servico'] ?? '') ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cidade">Cidade (opcional):</label>
                            <input type="text" name="cidade" id="cidade" 
                                   placeholder="Filtrar por cidade"
                                   value="<?= htmlspecialchars($_GET['cidade'] ?? '') ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="uf">UF (opcional):</label>
                            <input type="text" name="uf" id="uf" 
                                   placeholder="Filtrar por estado" maxlength="2"
                                   value="<?= htmlspecialchars($_GET['uf'] ?? '') ?>">
                        </div>
                    </div>
                    
                    <button type="submit" class="search-button">Buscar Profissionais</button>
                </form>
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
                                <span class="service-tag"><?= htmlspecialchars($perfil['p_tipo_servico'] ?? '') ?></span>
                            </div>
                            
                            <div class="card-body">
                                <p><strong>Localização:</strong> 
                                    <?= htmlspecialchars($perfil['u_cidade'] ?? '') ?>, 
                                    <?= htmlspecialchars($perfil['u_uf'] ?? '') ?>
                                </p>
                                
                                <p><strong>Experiência:</strong> 
                                    <?= htmlspecialchars($perfil['p_experiencia'] ?? '') ?>
                                </p>
                                
                                <p><strong>Descrição:</strong> 
                                    <?= htmlspecialchars($perfil['p_descricao'] ?? '') ?>
                                </p>
                            </div>
                            
                            <div class="card-footer">
                                <a href="mailto:<?= htmlspecialchars($perfil['u_email'] ?? '') ?>" class="contact-link">
                                    <i class="fas fa-envelope"></i> Email
                                    <?="<p style='color:black'>".$perfil['u_email']."</p>"?>
                                </a>
                                <a href="tel:<?= htmlspecialchars($perfil['p_telefone'] ?? '') ?>" class="contact-link">
                                    <i class="fas fa-phone"></i> Telefone
                                    <?="<p style='color:black'>".$perfil['p_telefone']."</p>"?>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['servico'])): ?>
            <div class="no-results">
                <p>Nenhum profissional encontrado com os critérios selecionados.</p>
                <a href="consultar.php" class="try-again">Tentar nova busca</a>
            </div>
        <?php endif; ?>
        
        <div class="home-link">
            <a href="../index.html">Voltar para página inicial</a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="site-footer">
        <p> © 2025 | FreelaHub</p>
    </footer>
</body>
</html>
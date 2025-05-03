<?php
require_once '../classes/Explorador.php';

//Processar a consulta quando o formulário for submetido
$resultados = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['servico'])) {
    $explorador = new Explorador();
    $servico = $_GET['servico'] ?? '';
    $cidade = $_GET['cidade'] ?? '';
    $uf = $_GET['uf'] ?? '';
    if ($servico == "" or $servico =="*") $servico = "%";
    $resultados = $explorador->buscarPorServico($servico, $cidade, $uf);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de Profissionais - FreelaHub</title>
    <link rel="stylesheet" href="css/consultar_pages.css">
</head>
<body>
    <h1>Busca de Profissionais FreelaHub</h1>

    
    <div class="consultar-form">
        <form method="GET" action="consultar.php">
            <div class="form-group">
                <label for="servico">Tipo de Serviço:</label>
                <input type="text" name="servico" id="servico" 
                       placeholder="Ex: Pintura, Design, Desenvolvimento">
            </div>
            
            <div class="form-group">
                <label for="cidade">Cidade (opcional):</label>
                <input type="text" name="cidade" id="cidade" placeholder="Filtrar por cidade">
            </div>
            
            <div class="form-group">
                <label for="uf">UF (opcional):</label>
                <input type="text" name="uf" id="uf" placeholder="Filtrar por estado" maxlength="2">
            </div>
            
            <button type="submit">Buscar Profissionais</button> 

        </form>
                <div class="register-link">
            <a href="../index.html">Ir para página inicial</a>
        </div>

    </div>
    
    <?php if (!empty($resultados)): ?>
        <h2>Resultados da Busca</h2>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Serviço</th>
                    <th>Localização</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th>Experiência</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                 <?php foreach ($resultados as $perfil): ?>
                    <tr>
                        <td><?= htmlspecialchars($perfil['u_nome'] ?? '') ?></td>
                        <td><?= htmlspecialchars($perfil['p_tipo_servico'] ?? '') ?></td>
                        <td>
                            <?= htmlspecialchars($perfil['u_cidade'] ?? '') ?>, 
                            <?= htmlspecialchars($perfil['u_uf'] ?? '') ?>
                        </td>
                        <td><?= htmlspecialchars($perfil['p_telefone'])?></td>
                        <td><?= htmlspecialchars($perfil['u_email'])?></td>
                        <td><?= htmlspecialchars($perfil['p_experiencia'] ?? '') ?></td>
                        <td><?= htmlspecialchars($perfil['p_descricao'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['servico'])): ?>
        <div class="mensagem sem-resultados">
            Nenhum profissional encontrado com os critérios selecionados.
        </div>
    <?php endif; ?>
</body>
</html>

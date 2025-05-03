<?php
require_once __DIR__ . '/Perfil.php';

class Explorador {
    private $crud;
    
    public function __construct() {
        $this->crud = new Crud();
    }

public function buscarPorServico($tipoServico, $cidade = null, $uf = null) {
    $conditions = ['perfil.p_tipo_servico' => $tipoServico];
    $join = "INNER JOIN usuario ON perfil.id = usuario.p_id_perfil ";
    
    if ($cidade) {
        $conditions['usuario.u_cidade'] = $cidade;
    }
    
    if ($uf) {
        $conditions['usuario.u_uf'] = $uf;
    }
    
    $columns = "perfil.id, perfil.p_tipo_servico, perfil.p_experiencia, 
                perfil.p_descricao, usuario.u_nome, usuario.u_cidade, usuario.u_uf,
                perfil.p_telefone,usuario.u_email";
    
    return $this->crud->selectWithJoin(
        'perfil', 
        $join, 
        $columns,
        $conditions,
        null, // sem limite
        true  // ativa busca parcial
    );
}

    public function buscarIdPorEmail($email) {
    $conditions = ['usuario.u_email' => $email];
    $join = "INNER JOIN usuario ON perfil.id = usuario.p_id_perfil";
    
    $columns = 'usuario.id';
    
    return $this->crud->selectWithJoin(
        'perfil', 
        $join, 
        $columns,
        $conditions,
        1
    );
}
}
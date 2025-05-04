<?php
require_once __DIR__ . '/Crud.php';
require_once __DIR__ . '/Usuario.php';

class Perfil {
    private $crud;
    private $id;
    private $usuarioId;
    private $telefone;
    private $tipoServico;
    private $descricaoServico;
    private $experiencia;

    public function __construct() {
        $this->crud = new Crud();
    }

    // Getters e Setters
    public function getId() {
        return $this->id;
    }

    public function getUsuarioId() {
        return $this->id;
    }

    public function setUsuarioId($usuarioId) {
        $this->usuarioId = $usuarioId;
        return $this;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
        return $this;
    }

    public function getTipoServico() {
        return $this->tipoServico;
    }

    public function setTipoServico($tipoServico) {
        $this->tipoServico = $tipoServico;
        return $this;
    }

    public function getDescricaoServico() {
        return $this->descricaoServico;
    }

    public function setDescricaoServico($descricaoServico) {
        $this->descricaoServico = $descricaoServico;
        return $this;
    }

    public function getExperiencia() {
        return $this->experiencia;
    }

    public function setExperiencia($experiencia) {
        $this->experiencia = $experiencia;
        return $this;
    }

    // Métodos de negócio
    public function salvar() {
        $dados = [
            'p_telefone' => $this->telefone,
            'p_tipo_servico' => $this->tipoServico,
            'p_descricao' => $this->descricaoServico,
            'p_experiencia' => $this->experiencia
        ];

        if ($this->id) {
            return $this->crud->update('perfil', $dados, $this->id);
        } else {
            $result = $this->crud->insert('perfil', $dados);
            if ($result) {
                $this->id = $this->crud->getLastInsertId();
            }
            return $result;
        }
    }

    public function carregar($id) {
        $dados = $this->crud->selectById('perfil', $id); 
        if ($dados) {
            $this->carregarDados($dados);
            return true;
        }
        return false;
    }

    private function carregarDados($dados) {
        $this->id = $dados['id'];
        $this->telefone = $dados['p_telefone'];
        $this->tipoServico = $dados['p_tipo_servico'];
        $this->descricaoServico = $dados['p_descricao'];
        $this->experiencia = $dados['p_experiencia'];
    }

    public function excluir() {
        return $this->crud->delete('perfil', $this->id);
    }
}

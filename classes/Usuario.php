<?php
require_once __DIR__ . '/Crud.php';

class Usuario {
    private $crud;
    private $id;
    private $email;
    private $senha;
    private $nome;
    private $dataNascimento;
    private $cidade;
    private $uf;
    private $perfilId;
    
    //Constrói todos os métodos necessários ao CRUD 
    public function __construct() {
        $this->crud = new Crud();
    }

    // Getters e Setters
    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }
        public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
        return $this;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
        return $this;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
        return $this;
    }

    public function getUf() {
        return $this->uf;
    }

    public function setUf($uf) {
        $this->uf = $uf;
        return $this;
    }
        public function getPerfilId() {
        return $this->perfilId;
    }

    public function setPerfilId($perfilId) {
        $this->perfilId = $perfilId;
        return $this;
    }

    // Métodos de negócio
   public function autenticar($email, $senha) {
       $usuario = $this->crud->selectAll('usuario', ['u_email' => $email], 1);
       
       if (!empty($usuario) && password_verify($senha, $usuario[0]['u_senha'])) {
           $this->carregarDados($usuario[0]);
           return true;
       }
       return false;
   }

   public function alterarSenha($novaSenha) {
       $this->senha = password_hash($novaSenha, PASSWORD_DEFAULT);
       return $this->crud->update('usuario', ['u_senha' => $this->senha], $this->id);
   }

    public function salvar() {
        $dados = [
            'p_id_perfil' => $this->perfilId,
            'u_email' => $this->email,
            'u_senha' => $this->senha,
            'u_nome' => $this->nome,
            'u_dt_nascimento' => $this->dataNascimento,
            'u_cidade' => $this->cidade,
            'u_uf' => $this->uf
        ];

        if ($this->id) {
            return $this->crud->update('usuario', $dados, $this->id);
        } else {
            $dados['u_senha'] = password_hash($dados['u_senha'], PASSWORD_DEFAULT);
            $result = $this->crud->insert('usuario', $dados);
            if ($result) {
                $this->id = $this->crud->getLastInsertId();
            }
            return $result;
        }
    }

    public function carregar($id) {
        $dados = $this->crud->selectById('usuario', $id); 
        if ($dados) {
            $this->carregarDados($dados);
            return true;
        }
        return false;
    }

    private function carregarDados($dados) {
        $this->id = $dados['id'];
        $this->email = $dados['u_email'];
        $this->senha = $dados['u_senha'];
        $this->nome = $dados['u_nome'];
        $this->dataNascimento = $dados['u_dt_nascimento'];
        $this->cidade = $dados['u_cidade'];
        $this->uf = $dados['u_uf'];
        $this->perfilId = $dados['p_id_perfil'];
    }

    public function excluir() {
        return $this->crud->delete('usuario', $this->id);
    }


}
?>

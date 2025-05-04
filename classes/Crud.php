<?php
require_once __DIR__ . '/../config/database.php';


class Crud {
    protected $conn;
    
    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
        if ($this->conn->connect_error) {
            die("Erro de conexão: " . $this->conn->connect_error);
        }
        
        $this->conn->set_charset("utf8");
    }

    // Método genérico para inserir
    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);
        
        // Bind dos parâmetros dinamicamente
        $types = str_repeat("s", count($data));
        $values = array_values($data);
        $stmt->bind_param($types, ...$values);
        
        return $stmt->execute();
    }

    // Método genérico para atualizar
    public function update($table, $data, $id) {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = ?";
        }
        $set = implode(", ", $set);
        
        $sql = "UPDATE $table SET $set WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        
        // Adiciona o ID ao final dos valores
        $values = array_values($data);
        $values[] = $id;
        
        // Bind dos parâmetros
        $types = str_repeat("s", count($data)) . "i";
        $stmt->bind_param($types, ...$values);
        
        return $stmt->execute();
    }

    // Método genérico para deletar
    public function delete($table, $id) {
        $sql = "DELETE FROM $table WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }

    // Método para buscar todos os registros
    public function selectAll($table, $conditions = [], $limit = null) {
        $sql = "SELECT * FROM $table";
        $params = [];
        $types = "";
        
        if (!empty($conditions)) {
            $sql .= " WHERE ";
            $where = [];
            foreach ($conditions as $key => $value) {
                $where[] = "$key = ?";
                $params[] = $value;
                $types .= is_int($value) ? "i" : "s";
            }
            $sql .= implode(" AND ", $where);
        }
        
        if ($limit) {
            $sql .= " LIMIT ?";
            $params[] = (int)$limit;
            $types .= "i";
        }
        
        $stmt = $this->conn->prepare($sql);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Método para buscar por ID
    public function selectById($table, $id) {
        $sql = "SELECT * FROM $table WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $this->conn->error);
    }
        // $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    // Fechar conexão quando não for mais necessária
    public function __destruct() {
        $this->conn->close();
    }
    // Fazer o INNER JOIN das duas tabelas
    public function selectWithJoin($table, $join, $columns = '*', $conditions = [], $limit = null, $partialMatch = false) {
    $sql = "SELECT $columns FROM $table $join";
    
    $params = [];
    $types = "";
    $whereClauses = [];
    
    if (!empty($conditions)) {
        foreach ($conditions as $key => $value) {
            if ($partialMatch) {
                $whereClauses[] = "$key LIKE ?";
                $params[] = "%$value%";
                $types .= 's';
            } else {
                $whereClauses[] = "$key = ?";
                $params[] = "$value";
                $types .= is_int($value) ? 'i' : (is_double($value) ? 'd' : 's');
            }
        }
        
        $sql .= " WHERE " . implode(" AND ", $whereClauses);
    }
    
    if ($limit) {
        $sql .= " LIMIT ?";
        $params[] = (int)$limit;
        $types .= 'i';
    }
    
    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Erro ao preparar query: " . $this->conn->error);
    }
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    if (!$stmt->execute()) {
        throw new Exception("Erro ao executar query: " . $stmt->error);
    }
    
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
public function getLastInsertId() {
    return $this->conn->insert_id;

}
}
<?php
class DBConn{

    private static $instance;
    private $connection;

    private function __construct(){
        try {
            $dbhost = 'localhost';
            $dbname = 'desafio';
            $dbuser = 'root';
            $dbpass = '';
            $this->connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection error: ".$e->getMessage());
        }
    }

    public static function getInstance(): DBConn{
        try {
            if(!isset(self::$instance)){
                self::$instance = new self();
            }
            return self::$instance;
        } catch (Exception $e) {
            die("Error getting class instance:" .$e->getMessage());
        }
    }
    
    public function selectID() {
        try {
            $sql = "SELECT c.id_cliente, c.cliente_telefone_id_cliente_telefone FROM cliente as c WHERE id_cliente =".$this->connection->lastInsertId();
            $statement = $this->connection->query($sql);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error executing select: " . $e->getMessage());
        }
    }

    public function selectAll() {
        try {
            $sql = "SELECT c.nome, c.obeservacao, t.telefone FROM cliente as c INNER JOIN cliente_telefone as t ON c.cliente_telefone_id_cliente_telefone = t.id_cliente_telefone";
            $statement = $this->connection->query($sql);
    
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error executing select: " . $e->getMessage());
        }
    }

    public function insert($cliente, $telefone){
        try {
            $ids = $this->selectID();
            $ids['cliente_telefone_id_cliente_telefone']+=1;
            $ids['id_cliente']+=1;
            $sql = "INSERT INTO cliente_telefone(id_cliente_telefone, telefone)  VALUES (".$ids['cliente_telefone_id_cliente_telefone'].", ".$telefone->getTelefone().")";
            $statement = $this->connection->query($sql);
            $sql = "INSERT INTO cliente(id_cliente, nome, obeservacaoo, cliente_telefone_id_cliente_telefone) VALUES (".$ids['id_cliente'].",".$cliente->getNome().", ".$cliente->getObeservacao().")";
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            die("Error executing insert: " . $e->getMessage());
        }
    }

    public function delete($tableName, $condition){
        try{
            $sql = "DELETE FROM $tableName WHERE $condition";
            $statement = $this->connection->prepare($sql);
            $statement->execute();

            return $statement->rowCount();
        }catch (PDOException $e) {
            die("Error executing delete: " . $e->getMessage());
        }
    }

    public function update($tableName, $data, $condition) {
        $setClause = '';
        foreach ($data as $key => $value) {
            $setClause .= "$key = :$key, ";
        }
        $setClause = rtrim($setClause, ', ');
        try{
            $sql = "UPDATE $tableName SET $setClause WHERE $condition";
            $statement = $this->connection->prepare($sql);
            $statement->execute($data);
            return $statement->rowCount();
        }catch (PDOException $e) {
            die("Error executing update: " . $e->getMessage());
        }
        
    }

}
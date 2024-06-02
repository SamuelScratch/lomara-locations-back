<?php

class SqliteManager { // Classe permettant de faire des opérations sur la base de donnée sqlite

    // Propriétés

    public PDO $db;

    // Constructeur

    function __construct($dbName)
    {
        $this->db = new PDO('sqlite:' . './db/' . $dbName . '.db');
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
    }

    // Méthodes
    
    public function Execute($request, $parametre = array()) // Execute simplement la requete passé en paramètre
    {
        $statement = $this->db->prepare($request);
        $statement->execute($parametre);
        $result = $statement->fetchAll();
        return $result;
    }

    public function GetIdOf($table, $field, $val) // Vérifie si une élément existe dans la base de données en fonction de la table, du champ avec lequel on veut repérer l'élément et la valeur de ce champ
    {
        $result = $this->Execute("SELECT id FROM $table WHERE $field = :val", array("val" => $val));
        if (count($result) > 0){
            return $result[0]["id"];
        }
        return false;
    }

    //Create a function that will return values from a table depending on a field value
    public function GetByFieldValue($table, $field, $val, bool $isUnique = false){
        $result = $this->Execute("SELECT * FROM $table WHERE $field = :val", array("val" => $val));
        if ($isUnique && count($result) >= 1){
            return $result[0];
        }
        return $result;
    }

    public function GetById($table, $id){
        $result = $this->Execute("SELECT * FROM $table WHERE id = :id", array("id" => $id));
        return $result[0];
    }

    public function GetAllFromTable($table){
        $result = $this->Execute("SELECT * FROM $table");
        return $result;
    }

    public function InsertDataArray($table, $data){
        $result = $this->Execute("INSERT INTO $table (".implode(",", array_keys($data)).") VALUES (:".implode(",:", array_keys($data)).")", $data);
        return $this->db->lastInsertId();
    }

    public function ReplaceDataArray($table, $data){
        $result = $this->Execute("REPLACE INTO $table (".implode(",", array_keys($data)).") VALUES (:".implode(",:", array_keys($data)).")", $data);
        return $this->db->lastInsertId();
    }


    public function UpdateDataArray($table, $data, $id){
        $result = $this->Execute("UPDATE $table SET ".implode("=?,", array_keys($data))."=? WHERE id = ?", array_values($data) + array($id));
        return $result;
    }

    public function DeleteById($table, $id){
        $result = $this->Execute("DELETE FROM $table WHERE id = :id", array("id" => $id));
        return $result;
    }

    public function ElementIdExists($table, $val){
        $result = $this->Execute("SELECT id FROM $table WHERE id = :val", array("val" => $val));
        if (count($result) > 0){
            return true;
        }
        return false;
    }

    public function ElementExists($table, $field, $val){
        $result = $this->Execute("SELECT id FROM $table WHERE $field = :val", array("val" => $val));
        if (count($result) > 0){
            return true;
        }
        return false;
    }

    public function TestConnexion($table, $name, $password){
        try {
            $result = $this->Execute("SELECT name FROM $table WHERE name = :name", array("name" => $name));
            if(count($result) == 1){
                if ($this->UserPasswordCheck($table, $name, $password)){
                    return true;
                }
            }
        }
        catch(Exception $e) {
            return false;
        }
        return false;
    }

    public function Inscription($table, $name, $mail, $password){
        try {
            $result = $this->Execute("INSERT INTO $table (name, password, mail) VALUES (:name, :password, :mail)", array("name" => $name, "password" => password_hash($password, PASSWORD_DEFAULT), "mail" => $mail));
            $result = $this->Execute("INSERT INTO profile (user_id) VALUES (:id)", array("id" => $this->db->lastInsertId()));
            if ($this->db->lastInsertId() != 0){
                return true;
            }
        }
        catch(Exception $e) {
            return false;
        }
        return false;
    }

    private function UserPasswordCheck($table, $name, $password){
        try {
            $request = "SELECT password FROM $table WHERE name = :name";
            $result = $this->Execute($request, array("name" => $name));
            if(password_verify($password, $result[0]["password"])){
                return true;
            }
        }
        catch(Exception $e) {
            return false;
        }
        return false;
    }
}
?>
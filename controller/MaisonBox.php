<?php

include_once "./lib/HttpBox.php";
include_once "./lib/SqliteManager.php";
include_once "./model/DtoMaison.php";

class MaisonBox extends HttpBox
{
    public DtoMaison $maison;
    public $maisonList = array();
    const TABLE = "maison";
    const DBNAME = "maisons";

    public function get()
    {
        $db = new SqliteManager(self::DBNAME);
        if ($this->getParameterValue("id") != null) {
            $this->maison = new DtoMaison($db->GetById(self::TABLE, $this->getParameterValue("id")));
            echo json_encode($this->maison);
        } 
        else {
            $maisonList = $db->GetAllFromTable(self::TABLE);
            foreach ($maisonList as $value) {
                array_push($this->maisonList, new DtoMaison($value));
            }
            echo json_encode($this->maisonList);
        }
    }

    public function post()
    {
        $db = new SqliteManager(self::DBNAME);
        $this->maison = new DtoMaison($_POST);
        $lastInsertId = $db->InsertDataArray(self::TABLE, $this->maison->DtoToArray());
        if ($lastInsertId != 0) {
            $this->maison->id = $lastInsertId;
            return true;
        } else {
            return false;
        }
    }

    public function put()
    {
        $db = new SqliteManager(self::DBNAME);
        $this->maison = new DtoMaison($_POST);
        $lastInsertId = $db->UpdateDataArray(self::TABLE, $this->maison->DtoToArray(), $this->getParameterValue("id"));
        if ($lastInsertId != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete()
    {
        $db = new SqliteManager(self::DBNAME);
        var_dump($db->DeleteById(self::TABLE, $this->getParameterValue("id")));
    }
}

// Main
$userBox = new MaisonBox($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], isset($params) ? $params : null);
$userBox->execute();
<?php

include_once "./lib/HttpBox.php";
include_once "./lib/SqliteManager.php";
include_once "./model/DtoMaison.php";

class MaisonBox extends HttpBox
{
    public DtoMaison $maison;
    public $maisonList = array();
    const TABLE = "maison";
    const DBNAME = "lomara";

    public function get()
    {
        $db = new SqliteManager(self::DBNAME);
        if ($this->getParameterValue("id") != null && $this->getParameterValue("id") != "-1") {
            $this->maison = new DtoMaison($db->GetById(self::TABLE, $this->getParameterValue("id")));
            if ($this->isApi)
                echo json_encode($this->maison);
        } 
        elseif ($this->getParameterValue("id") == "-1") {
            $this->maison = new DtoMaison(null);
            $this->maison->id = -1;
        }
        else {
            $maisonList = $db->GetAllFromTable(self::TABLE);
            foreach ($maisonList as $value) {
                array_push($this->maisonList, new DtoMaison($value));
            }
            if ($this->isApi)
                echo json_encode($this->maisonList);
        }
    }

    public function post()
    {
        $db = new SqliteManager(self::DBNAME);
        $this->maison = new DtoMaison($_POST);

        if ($this->maison->id == "-1") {
            $this->maison->id = null;
            $maisonArray = $this->maison->DtoToArray();
            unset($maisonArray["images"]);
            unset($maisonArray["equipements"]);
            $lastInsertId = $db->InsertDataArray(self::TABLE, $maisonArray);
        }
        else{
            $maisonArray = $this->maison->DtoToArray();
            unset($maisonArray["images"]);
            unset($maisonArray["equipements"]);
            $lastInsertId = $db->ReplaceDataArray(self::TABLE, $maisonArray);
        }
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
        $db->DeleteFromTable(EquipementBox::TABLE, "maison_id", $this->getParameterValue("id"));
        $db->DeleteFromTable(ImageBox::TABLE, "maison_id", $this->getParameterValue("id"));
        var_dump($db->DeleteById(self::TABLE, $this->getParameterValue("id")));
    }
}

// Main
if (str_starts_with($_SERVER["REQUEST_URI"], "/biens")) {
    $userBox = new MaisonBox($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], isset($params) ? $params : null);
    $userBox->execute();
}
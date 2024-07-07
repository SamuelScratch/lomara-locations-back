<?php

include_once "./lib/HttpBox.php";
include_once "./lib/SqliteManager.php";
include_once "./model/DtoEquipement.php";
include_once "./model/DtoAssociationEquipement.php";

class EquipementBox extends HttpBox
{
    const TABLE = "association_equipement";
    const DBNAME = "lomara";
    public $equipementList = array();
    public $associationEquipementList = array();

    public function get()
    {
        $db = new SqliteManager(self::DBNAME);
        $this->equipementList = $db->GetAllFromTable("equipement");
        $this->associationEquipementList = $db->GetByFieldValue("association_equipement", "maison_id", $this->getParameterValue("maison_id"));
        include_once "./view/ViewEquipement.php";
    }

    public function post()
    {
        var_dump($_POST);
        $db = new SqliteManager(self::DBNAME);
        $db->DeleteFromTable("association_equipement", "maison_id", $this->getParameterValue("maison_id"));
        foreach ($_POST as $key => $value) {
            $associationEquipement = new DtoAssociationEquipement(null);
            $associationEquipement->equipement_id = $key;
            $associationEquipement->maison_id = $this->getParameterValue("maison_id");
            $db->InsertDataArray("association_equipement", $associationEquipement->DtoToArray());
        }
        header("Location: /admin/" . $this->getParameterValue("maison_id") . "/equipement", true, 303);
    }

    public function put()
    {
    }

    public function delete()
    {
    }

    public function EquipementExists($id)
    {
        foreach ($this->associationEquipementList as $value) {
            if ($value["equipement_id"] == $id) {
                return true;
            }
        }
    }
}
global $equipementBox;

$equipementBox = new EquipementBox($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], isset($params) ? $params : null);
$equipementBox->execute();

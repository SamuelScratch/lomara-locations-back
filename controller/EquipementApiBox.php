<?php

include_once "./lib/HttpBox.php";
include_once "./lib/SqliteManager.php";
include_once "./model/DtoEquipement.php";
include_once "./model/DtoAssociationEquipement.php";

class EquipementApiBox extends HttpBox
{
    const TABLE = "association_equipement";
    const DBNAME = "lomara";
    public $equipementList = array();
    public $associationEquipementList = array();
    public $equipementMaison = array();

    public function get()
    {
        $db = new SqliteManager(self::DBNAME);
        $this->equipementList = $db->GetAllFromTable("equipement");
        $this->associationEquipementList = $db->GetByFieldValue("association_equipement", "maison_id", $this->getParameterValue("maison_id"));
        foreach ($this->equipementList as $value) {
            if ($this->EquipementExists($value["id"])) {
                array_push($this->equipementMaison, new DtoEquipement($value));
            }
        }
        echo json_encode($this->equipementMaison);
    }

    public function post()
    {
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

$equipementBox = new EquipementApiBox($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], isset($params) ? $params : null);
$equipementBox->execute();

<?php

include_once "./lib/DtoObject.php";
include_once "./model/DtoImage.php";
include_once "./lib/SqliteManager.php";
include_once "./model/DtoEquipement.php";
include_once "./model/DtoAssociationEquipement.php";

class DtoMaison extends DtoObject {
    public $id;
	public $nom;
	public $adresse;
    public $code_postal;
    public $ville;
    public $description;
    public $texte_tarif;
    public $vignette;
    public $nb_personne;
    public $images = array();
    public $equipements = array();

    public function __construct($data)
    {
        $this->initDto($data);
        $db = new SqliteManager("lomara");
        $this->images = $db->GetAllFromTableWithWhere("image", "maison_id", $this->id);
        
        $equipementList = $db->GetAllFromTable("equipement");
        foreach ($equipementList as $value) {
            if ($this->EquipementExists($value["id"])) {
                array_push($this->equipements, new DtoEquipement($value));
            }
        }
    }
    
    public function EquipementExists($id)
    {
        $db = new SqliteManager("lomara");
        $associationEquipementList = $db->GetByFieldValue("association_equipement", "maison_id", $this->id);
        foreach ($associationEquipementList as $value) {
            if ($value["equipement_id"] == $id) {
                return true;
            }
        }
    }
}


?>
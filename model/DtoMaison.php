<?php

include_once "./lib/DtoObject.php";
include_once "./model/DtoImage.php";
include_once "./lib/SqliteManager.php";

class DtoMaison extends DtoObject {
    public $id;
	public $nom;
	public $adresse;
    public $code_postal;
    public $description;
    public $vignette;
    public $images = array();

    public function __construct($data)
    {
        $this->initDto($data);
        $db = new SqliteManager("lomara");
        $this->images = $db->GetAllFromTableWithWhere("image", "maison_id", $this->id);
    }
}


?>
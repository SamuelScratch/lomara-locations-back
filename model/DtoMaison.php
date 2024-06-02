<?php

include_once "./lib/DtoObject.php";

class DtoMaison extends DtoObject {
    public $id;
	public $nom;
	public $adresse;
    public $code_postal;
    public $description;
    public $vignette;
}


?>
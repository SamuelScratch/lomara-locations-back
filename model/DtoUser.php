<?php

include_once "./lib/DtoObject.php";

class DtoUser extends DtoObject {
    public $id;
	public $username;
	public $password;
    public $email;
}


?>
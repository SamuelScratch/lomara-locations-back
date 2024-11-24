<?php

include_once "./lib/HttpBox.php";
include_once "./lib/SqliteManager.php";
include_once "./controller/MaisonBox.php";

class AdminBox extends HttpBox
{
    const TABLE = "utilisateur";
    const DBNAME = "lomara";
    public $mess_err = "";

    public function get()
    {
        if ($this->getParameterValue("id") != null)
            include_once "./view/ViewMaison.php";
        else
            include_once "./view/ViewMaisons.php";
    }

    public function post()
    {
        $db = new SqliteManager(self::DBNAME);
        $maisonBox = new MaisonBox($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], $this->parameter);
        $maisonBox->execute();
        header("Location: /admin/". $maisonBox->maison->id, true, 303);
    }

    public function put()
    {
    }

    public function delete()
    {
        $db = new SqliteManager(self::DBNAME);
        $db->DeleteFromTable("association_equipement", "maison_id", $this->getParameterValue("id"));
        $db->DeleteFromTable("image", "maison_id", $this->getParameterValue("id"));
        var_dump($db->DeleteById("maison", $this->getParameterValue("id")));
    }
}

// Main
$maisonBox = new AdminBox($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], isset($params) ? $params : null);
$maisonBox->execute();

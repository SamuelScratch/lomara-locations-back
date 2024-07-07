<?php

include_once "./lib/HttpBox.php";
include_once "./lib/SqliteManager.php";

class LoginBox extends HttpBox
{
    const TABLE = "utilisateur";
    const DBNAME = "lomara";
    public $mess_err = "";

    public function get()
    {
        include_once "./view/ViewLogin.php";
    }

    public function post()
    {
        $db = new SqliteManager(self::DBNAME);
        if ($db->TestConnexion(self::TABLE, $_POST["username"], $_POST["password"], true)) {
            session_start();
            $_SESSION["user_id"] = 999;
            header("Location: /admin", true, 303);
        }
        else {
            session_start();
            session_destroy();
            header("Location: /login", true, 303);
        }
    }

    public function put()
    {
    }

    public function delete()
    {
    }
}

// Main
$loginBox = new LoginBox($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], isset($params) ? $params : null);
$loginBox->execute();

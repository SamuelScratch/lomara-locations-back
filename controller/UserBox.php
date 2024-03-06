<?php

include_once "./lib/HttpBox.php";
include_once "./lib/SqliteManager.php";
include_once "./model/DtoUser.php";

class UserBox extends HttpBox
{
    public DtoUser $user;
    public $userList = array();
    const TABLE = "user";
    const DBNAME = "sections";

    public function get()
    {
        $db = new SqliteManager(self::DBNAME);
        if ($this->getParameterValue("id") != null) {
            $this->user = new DtoUser($db->GetById(self::TABLE, $this->getParameterValue("id")));
            echo json_encode($this->user);
        } 
        else {
            $userList = $db->GetAllFromTable(self::TABLE);
            foreach ($userList as $value) {
                array_push($this->userList, new DtoUser($value));
            }
            echo json_encode($this->userList);
        }
    }

    public function post()
    {
        $db = new SqliteManager(self::DBNAME);
        $this->user = new DtoUser($_POST);
        $lastInsertId = $db->InsertDataArray(self::TABLE, $this->user->DtoToArray());
        if ($lastInsertId != 0) {
            $this->user->id = $lastInsertId;
            return true;
        } else {
            return false;
        }
    }

    public function put()
    {
        $db = new SqliteManager(self::DBNAME);
        $this->user = new DtoUser($_POST);
        $lastInsertId = $db->UpdateDataArray(self::TABLE, $this->user->DtoToArray(), $this->getParameterValue("id"));
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
$userBox = new UserBox($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], isset($params) ? $params : null);
$userBox->execute();
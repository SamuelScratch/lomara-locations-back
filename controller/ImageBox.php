<?php

include_once "./lib/HttpBox.php";
include_once "./lib/SqliteManager.php";
include_once "./model/DtoImage.php";
include_once "./model/DtoMaison.php";

class ImageBox extends HttpBox
{
    const TABLE = "image";
    const DBNAME = "lomara";
    public DtoImage $image;
    public $imageList = array();
    public DtoMaison $maison;

    public function get()
    {
        $db = new SqliteManager(self::DBNAME);
        $imageList = $db->GetAllFromTable(self::TABLE);
        $this->initMaison();
        if (isset($this->parameter["image_id"]) && $this->getParameterValue("image_id") != null && $this->getParameterValue("image_id") != "-1") {
            $this->image = new DtoImage($db->GetById(self::TABLE, $this->getParameterValue("image_id")));
            if ($this->isApi)
                echo json_encode($this->image);
            else
                include_once "./view/ViewImage.php";
        } elseif (isset($this->parameter["image_id"]) && $this->getParameterValue("image_id") == "-1") {
            $this->image = new DtoImage(null);
            $this->image->maison_id = $this->getParameterValue("maison_id");
            $this->image->id = -1;
            if (!$this->isApi)
                include_once "./view/ViewImage.php";
        } else {
            foreach ($imageList as $value) {
                if ($value["maison_id"] == $this->getParameterValue("maison_id"))
                    array_push($this->imageList, new DtoImage($value));
                if (count($this->imageList) == 0) {
                    $this->imageList = array();
                }
            }
            if ($this->isApi)
                echo json_encode($this->imageList);
            else
                include_once "./view/ViewImages.php";
        }
    }

    public function post()
    {
        $db = new SqliteManager(self::DBNAME);
        $this->image = new DtoImage($_POST);
        if ($this->image->id == "-1") {
            $this->image->id = null;
            $lastInsertId = $db->InsertDataArray(self::TABLE, $this->image->DtoToArray());
        } else {
            $lastInsertId = $db->ReplaceDataArray(self::TABLE, $this->image->DtoToArray());
        }
        if ($this->isApi) {
            if ($lastInsertId != 0) {
                $this->image->id = $lastInsertId;
                return true;
            } else {
                return false;
            }
        }
        header("Location: /admin/" . $this->getParameterValue("maison_id") . "/image", true, 303);
    }

    public function put()
    {
    }

    public function delete()
    {
        $db = new SqliteManager(self::DBNAME);
        var_dump($db->DeleteById(self::TABLE, $this->getParameterValue("image_id")));
        //header("Location: /admin/" . $this->getParameterValue("maison_id") . "/image", true, 303);
    }

    public function initMaison()
    {
        $db = new SqliteManager(self::DBNAME);
        $this->maison = new DtoMaison($db->GetById("maison", $this->getParameterValue("maison_id")));
    }
}

// Main
global $imageBox;
if (str_starts_with($_SERVER["REQUEST_URI"], "/images")) {
    $imageBox = new ImageBox($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], isset($params) ? $params : null);
    $imageBox->execute();
} else {
    $imageBox = new ImageBox($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], isset($params) ? $params : null);
    $imageBox->isApi = false;
    $imageBox->execute();
}

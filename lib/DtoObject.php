<?php
include_once "./lib/SqliteManager.php";

class DtoObject
{
    public function __construct($data)
    {
        $this->initDto($data);
    }

    protected function initDto($data)
    {
        $vars = DtoTools::getVars($this);
        foreach ($vars as $key => $value) {
            if (isset($data[$key])){
                $this->$key = $data[$key];
            }
        }
    }

    public function DtoToArray() {
        $vars = DtoTools::getVars($this);
        $array = array();
        foreach ($vars as $key => $value) {
            if (isset($this->$key))
                $array += [$key => $this->$key];
        }
        return $array;
    }
}

class DtoObjectList 
{
    public $dtoArary;
    public function __construct($dbName, $table)
    {
        $db = new SqliteManager($dbName);
        $result = $db->GetAllFromTable($table);
        
        foreach($result as $value) {
            array_push($this->dtoArary, new DtoObject($value));
        }
    }
}

class DtoTools
{
    public static function getVars($object)
    {
        return get_class_vars(get_class($object));
    }
}

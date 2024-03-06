<?php

include_once "./lib/HttpBox.php";

class HomeBox extends HttpBox
{
    public function get()
    {
        $this->render();
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

    protected function render()
    {
        include "./view/UserView.php";
    }
}

$homeBox = new HomeBox($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"], isset($params) ? $params : null);
$homeBox->execute();
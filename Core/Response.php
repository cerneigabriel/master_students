<?php

namespace MasterStudents\Core;

class Response
{
    public function __construct()
    {
        return $this;
    }

    public function setStatusCode($code)
    {
        \http_response_code($code);
    }

    public function json($data, $code = 200)
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');

        $this->setStatusCode($code);

        return json_encode($data);
    }

    public function redirect($path)
    {
        Header("Location: $path");
        exit();
    }
}

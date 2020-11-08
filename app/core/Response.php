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
}

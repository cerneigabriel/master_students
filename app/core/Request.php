<?php

namespace MasterStudents\Core;

use Collections\Map;
use Collections\Pair;
use Collections\Vector;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class Request
{
    public function getPath(): string
    {
        $path = $_SERVER["REQUEST_URI"] ?? "/";
        $position = strpos($path, "?");

        if ($position === false) {
            return $path;
        }

        return substr($path, 0, $position);
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function all(): Map
    {
        switch ($this->getMethod()) {
            case "post":
                $input_type = INPUT_POST;
                $request = new Map(array_keys($_POST));
                break;
            case "get":
            default:
                $input_type = INPUT_GET;
                $request = new Map(array_keys($_GET));
                break;
        }

        $inputs = new Map();

        $request->each(function ($item) use ($input_type, $inputs) {
            $inputs->add(new Pair($item, trim(filter_input($input_type, $item, FILTER_SANITIZE_SPECIAL_CHARS))));
        });

        return $inputs->filter(fn ($value) => ($value !== "" && !is_null($value)));
    }

    public function validate(array $rules)
    {
        $validator = new Validator;

        return $validator->validate($this->all()->toArray(), $rules);
    }
}

<?php

namespace MasterStudents\Core;

use Collections\Map;
use Collections\Pair;
use MasterStudents\Core\Validation\ExistsInTableRule;
use MasterStudents\Core\Validation\UniqueRule;
use Rakit\Validation\Validator;

class Request
{
    public function getPath(): string
    {
        $path = server("REQUEST_URI") ?? "/";
        $position = strpos($path, "?");

        if ($position === false) {
            return $path;
        }

        return substr($path, 0, $position);
    }

    public function getMethod(): string
    {
        return strtolower(server("REQUEST_METHOD"));
    }

    public function ip(): string
    {
        return !!server('HTTP_CLIENT_IP') ? server('HTTP_CLIENT_IP') : (!!server('HTTP_X_FORWARDED_FOR') ? server('HTTP_X_FORWARDED_FOR') : server('REMOTE_ADDR'));
    }

    public function all(): Map
    {
        switch ($this->getMethod()) {
            case "post":
                $input_type = INPUT_POST;
                $request = map(array_keys($_POST));
                break;
            case "get":
            default:
                $input_type = INPUT_GET;
                $request = map(array_keys($_GET));
                break;
        }

        $inputs = map();

        $request->each(function ($item) use ($input_type, $inputs) {
            $inputs->add(new Pair($item, trim(filter_input($input_type, $item, FILTER_SANITIZE_SPECIAL_CHARS))));
        });

        return $inputs->filter(fn ($value) => ($value !== "" && !is_null($value)));
    }

    public function validate(array $rules)
    {
        $validator = new Validator;

        $validator->addValidator('unique', new UniqueRule());
        $validator->addValidator('exists_in_table', new ExistsInTableRule());

        return $validator->validate($this->all()->toArray(), $rules);
    }

    public function get($key, $instead = null)
    {
        return $this->all()->get($key) ?? $instead;
    }
}

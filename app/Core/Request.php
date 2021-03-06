<?php

namespace MasterStudents\Core;

use Collections\Map;
use Collections\Pair;
use MasterStudents\Core\Validation\ExistsInTableRule;
use MasterStudents\Core\Validation\PasswordMatch;
use MasterStudents\Core\Validation\UniqueRule;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class Request
{
    /**
     * Get Current Path
     *
     * @return string
     */
    public function getPath(): string
    {
        $path = server("REQUEST_URI") ?? "/";
        $position = strpos($path, "?");

        if ($position === false) {
            return $path;
        }

        return substr($path, 0, $position);
    }

    /**
     * Get Current Method
     *
     * @return string
     */
    public function getMethod(): string
    {
        return strtolower(server("REQUEST_METHOD"));
    }

    /**
     * Get Current Ip Address
     *
     * @return string
     */
    public function ip(): string
    {
        return !!server('HTTP_CLIENT_IP') ? server('HTTP_CLIENT_IP') : (!!server('HTTP_X_FORWARDED_FOR') ? server('HTTP_X_FORWARDED_FOR') : server('REMOTE_ADDR'));
    }

    /**
     * Get All Request Data
     *
     * @return Map
     */
    public function all(): Map
    {
        switch ($this->getMethod()) {
            case "post":
                $reques_inputs = map($_POST);
                $input_type = INPUT_POST;
                $request = map(array_keys($_POST));
                break;
            case "get":
            default:
                $reques_inputs = map($_GET);
                $input_type = INPUT_GET;
                $request = map(array_keys($_GET));
                break;
        }

        $inputs = map();

        $request->each(function ($item) use ($input_type, $inputs, $reques_inputs) {
            if (in_array(gettype($reques_inputs->get($item)), ["array", "object"]))
                $inputs->add(new Pair($item, $reques_inputs->get($item)));
            else
                $inputs->add(new Pair($item, trim(filter_input($input_type, $item, FILTER_SANITIZE_SPECIAL_CHARS))));
        });

        return $inputs->filter(fn ($value) => ($value !== "" && !is_null($value)));
    }

    /**
     * Validate Request Data
     *
     * @param array $rules
     * @return Validation
     */
    public function validate(array $rules): Validation
    {
        $validator = new Validator;

        $validator->addValidator('unique', new UniqueRule());
        $validator->addValidator('exists_in_table', new ExistsInTableRule());
        $validator->addValidator('password_match', new PasswordMatch());

        return $validator->validate($this->all()->toArray(), $rules);
    }

    /**
     * Get Item from request data by key
     *
     * @param string | int $key
     * @param mixed $instead
     * @return void
     */
    public function get($key, $instead = null)
    {
        return $this->all()->get($key) ?? $instead;
    }
}

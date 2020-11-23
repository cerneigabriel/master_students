<?php

namespace MasterStudents\Core;

use Rakit\Validation\Validation;

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

    public function handleErrorWithView(Validation $validator, Request $request, string $view, $model = null, array $params = [])
    {
        $model = !is_null($model) ? map(array_merge($model->toArray(), $request->all()->toArray())) : $request->all();
        return View::view($view, [
            "errors" => $validator->errors(),
            "model" => $model,
            ...$params
        ])->render();
    }

    public function handleErrorWithJSON(Validation $validator, int $code)
    {
        return $this->json([
            "status" => 401,
            "errors" => $validator->errors()
        ], $code);
    }
}

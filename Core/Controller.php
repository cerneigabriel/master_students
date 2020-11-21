<?php

namespace MasterStudents\Core;

use MasterStudents\Core\Traits\DatabaseManagerTrait;
use Rakit\Validation\Validation;

abstract class Controller
{
    use DatabaseManagerTrait;

    public function __construct()
    {
        $this->selectDatabase();

        if (isset($this->table))
            $this->repository = $this->db->table($this->table);
    }

    public function handleErrorWithView(Validation $validator, Request $request, string $view)
    {
        return View::view($view, [
            "errors" => $validator->errors(),
            "model" => $request->all()
        ])->render();
    }

    public function handleErrorWithJSON(Validation $validator, int $code)
    {
        return response()->json([
            "status" => 401,
            "errors" => $validator->errors()
        ], $code);
    }
}

<?php
namespace App\Controllers;

use App\Helpers\Sanitizer;
use App\Validators\ItemValidator;
use App\Helpers\Response;

class ItemController {
    public function create() {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];

        // 1. Sanitizamos primero con el nuevo Helper
        $cleanData = Sanitizer::clean($input);

        // 2. Validamos los datos ya limpios
        $errors = ItemValidator::validate($cleanData);

        if (!empty($errors)) {
            return Response::json(['ok' => false, 'errors' => $errors], 400);
        }

        // 3. Éxito
        return Response::json([
            'ok' => true, 
            'item' => array_merge(['id' => rand(1, 99)], $cleanData, ['created_at' => date('Y-m-d H:i:s')])
        ], 201);
    }
}
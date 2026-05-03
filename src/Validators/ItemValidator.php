<?php
namespace App\Validators;

class ItemValidator {
    public static function validate(array $data): array {
        $errors = [];

        if (strlen($data['name']) < 3 || strlen($data['name']) > 50) {
            $errors['name'] = "Entre 3 y 50 caracteres";
        }

        if ($data['quantity'] < 1 || $data['quantity'] > 100) {
            $errors['quantity'] = "Entre 1 y 100";
        }

        if ($data['price'] <= 0) {
            $errors['price'] = "Debe ser mayor a 0";
        }

        return $errors;
    }
}
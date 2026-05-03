<?php
namespace App\Validators;

use App\Models\Item;

class ItemValidator {

    public static function validarItem(array $data): array {
        // Array para acumular errores de validación
        $errors = [];

        // Validar name
        $name = $data['name'] ?? '';  
        if (empty($name)) {
            $errors['name'] = 'Campo obligatorio';
        } elseif (strlen($name) < 3 || strlen($name) > 50) {
            $errors['name'] = 'Debe tener entre 3 y 50 caracteres';
        }

        // Validar quantity
        $quantity = $data['quantity'] ?? '';
        if ($quantity === null || $quantity === '') {
            $errors['quantity'] = 'Campo obligatorio';
        } elseif (!is_numeric($quantity) || $quantity < 1 || $quantity > 100) {
            $errors['quantity'] = 'Debe ser un número entre 1 y 100';
        }

        // Validar price
        $price = $data['price'] ?? '';
        if ($price === null || $price === '') {
            $errors['price'] = 'Campo obligatorio';
        } elseif (!is_numeric($price) || $price < 0.01 || $price > 10000) {
            $errors['price'] = 'Debe ser un número entre 0.01 y 10000';
        }

        return $errors;
    }

}
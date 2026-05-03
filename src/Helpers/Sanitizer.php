<?php
namespace App\Helpers;

class Sanitizer {
    /**
     * Limpia un array de datos según el tipo especificado
     */
    public static function clean(array $data): array {
        $clean = [];
        
        $clean['name']     = isset($data['name']) ? htmlspecialchars(strip_tags(trim($data['name']))) : '';
        $clean['quantity'] = isset($data['quantity']) ? (int)$data['quantity'] : 0;
        $clean['price']    = isset($data['price']) ? (float)$data['price'] : 0.0;
        
        return $clean;
    }
}
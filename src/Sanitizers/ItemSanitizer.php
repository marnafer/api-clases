<?php
namespace App\Sanitizers;

use App\Models\Item;

class ItemSanitizer {
	public static function sanitizarItem(array $data): array {
		return [
			'name' => trim($data['name'] ?? ''),
			'quantity' => isset($data['quantity']) ? (int)$data['quantity'] : null,
			'price' => isset($data['price']) ? (float)$data['price'] : null,
		];
	}
}
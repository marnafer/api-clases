<?php
namespace App\Controllers;

use App\Validators\ItemValidator;
use App\Helpers\Response;
use App\Sanitizers\ItemSanitizer;

class ItemsController {

	### 1. Formulario de Creación
	public function itemsForm() {
		require __DIR__ . '/../../views/items_form.php';
	}


	### 2. Listar Items
	//GET /api/items
	//Descripción: Obtiene listado completo de items del inventario.
	//Respuesta esperada (200 OK): array de objetos Item.
	public function listarItems() {
		$items = [
			[
				"id" => 1,
				"name" => "Item A",
				"quantity" => 10,
				"price" => 99.99,
				"created_at" => "2024-03-01T12:00:00Z"
			],
			[
				"id" => 2,
				"name" => "Item B",
				"quantity" => 5,
				"price" => 49.99,
				"created_at" => "2024-03-05T15:30:00Z"
			]
		];
		Response::json([
			'ok' => true,
			'items' => $items
		]);
	}

	### 3. Obtener Item por ID
	//GET /api/items/{id}
	//Descripción: Obtiene detalle de un item específico.
	//Respuestas: 200 OK (item encontrado) o 404 Not Found.

	### 4. Crear Item
	//POST /api/items
	//Descripción: Crea un nuevo item en el inventario.
	//Body esperado: objeto JSON con datos del item.
	//Respuesta: 201 Created con el item creado.
	public function crearItem() {

	    $inputRaw = file_get_contents('php://input');
		$itemData = json_decode($inputRaw, true) ?? $_POST;

		$itemLimpio = ItemSanitizer::sanitizarItem($itemData);

		$errores = ItemValidator::validarItem($itemLimpio);

		if (!empty($errores)) {
			return Response::json([
				'status' => 'error',
				'errors' => $errores
			], 400);
		}

		$nuevoItem = [	

			"id" => rand(1,1000),
			"name" => $itemLimpio['name'],
			"quantity" => $itemLimpio['quantity'],
			"price" => $itemLimpio['price'],
			"created_at" => date('Y-m-d H:i:s')

		];
		
		http_response_code(201);
			header('Content-Type: application/json');
			echo json_encode([
				'ok' => true,
				'item' => $nuevoItem
			]);
			exit;
	}
	

	### 5. Listar Categorías
	//GET /api/categorias
	//Descripción: Obtiene listado de categorías disponibles.
}
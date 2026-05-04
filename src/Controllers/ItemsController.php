<?php
namespace App\Controllers;

use App\Validators\ItemValidator;
use App\Helpers\Response;
use App\Sanitizers\ItemSanitizer;
use App\Models\Item;

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
		
		try {
			// 1. Capturamos el parámetro 'q' de la URL (si no existe, queda vacío)
			$busqueda = $_GET['q'] ?? '';

			// 2. Evaluamos si hay que filtrar o traer todo
			if (!empty($busqueda)) {
				// Usamos Eloquent con un operador 'like' y comodines '%' 
				// para que busque coincidencias parciales (ej: "item5")
				$items = Item::where('name', 'like', '%' . $busqueda . '%')->get();
			} else {
				// Si no hay búsqueda, traemos todos
				$items = Item::all(); 
			}

				Response::json([
					'ok' => true,
					'items' => $items
				]);
			
		} catch (\Exception $e) {

				Response::json([
					'ok' => false,
					'error' => 'Error al obtener items: ' . $e->getMessage()
				], 500);
		}
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

		$nuevoItem = Item::create($itemLimpio);
		
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
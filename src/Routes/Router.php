<?php

namespace App\Routes;

use App\Helpers\Response;
use App\Controllers\ItemsController;

$controller = new ItemsController();

switch (true) { 
    
    case $path === "/items/new":
            if ($method === 'GET') {
                $controller->itemsForm($method, $path);
            } else {
                Response::json([
                    'success' => false, 
                    'error' => 'Method Not Allowed'
                ], 405);
            }
            break;
    case $path === "/items":
        switch ($method) {
            case 'GET':
                $controller->listarItems();
                break;
             case 'POST':
                $controller->crearItem();
                break;
            default:
                Response::json([
                    "success" => false,
                    'error' => 'Method Not Allowed'
                ], 405);
        }
   
}	
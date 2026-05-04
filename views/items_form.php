<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Item</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 50px auto; padding: 20px; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px; }
        button { margin-top: 20px; padding: 10px 20px; background: #87ADFD; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #AAE4FE; }
        /* Estilos simples para mensajes de feedback */
        #mensajes { margin-top: 15px; font-weight: bold; }
        #mensajes.error { color: red !important; }
        #mensajes.ok { color: green !important; }
    </style>
</head>
<body>
    <h1>Crear Nuevo Item</h1>
    
    <!-- 1. Agregamos el ID al form -->
    <form id="form-nuevo-item">

        <!-- 2. Agregamos IDs a los inputs para que el JS los pueda leer -->
        <label>Nombre del Item:
            <input type="text" id="name" name="name" required>
        </label>
        
        <label>Cantidad:
            <input type="number" id="quantity" name="quantity" min="1" required>
        </label>

        <label>Precio:
            <input type="number" id="price" name="price" step="0.01" min="0.01" required>
        </label>
        
        <button type="submit">Crear Item</button>
    </form>

    <!-- Contenedor donde mostraremos las alertas o errores -->
    <div id="mensajes"></div>

    <!-- VISTA DE LA LISTA-->
    <?php include __DIR__ . '/items_list.php'; ?>

    <script>
        const form = document.getElementById('form-nuevo-item');
        const mensajesDiv = document.getElementById('mensajes');

        form.addEventListener('submit', async (e) => {
            e.preventDefault(); // Evitar recarga de página (comportamiento por defecto del form)
            
            // 1. Capturar datos del form
            const nuevoItem = {
                name: document.getElementById('name').value,
                quantity: parseInt(document.getElementById('quantity').value),
                price: parseFloat(document.getElementById('price').value)
            };
            
            try {
                // Limpiar mensajes previos
                mensajesDiv.innerHTML = 'Enviando...';
                mensajesDiv.className = '';

                // 2. Hacer el request POST 
                const response = await fetch('/api-clases/items', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(nuevoItem)
                });
            
                // 3. Parsear respuesta
                const data = await response.json();
            
                // 4. Procesar resultado
                // Validamos si tu backend devolvió ok: true 
                if (response.ok && data.ok) {
                    mensajesDiv.className = 'ok';
                    mensajesDiv.innerHTML = '¡Item creado exitosamente!';
                    form.reset(); // Limpiar form
                    
                    // Llamamos a la función de la otra vista para que actualice la lista
                    if (typeof cargarItems === 'function') {
                        cargarItems(); 
                    }
                } else {
                    mensajesDiv.className = 'error';
                    
                    // Lógica para mostrar los errores específicos de tu validador
                    if (data.errors) {
                        let erroresHTML = 'Por favor, corrige los siguientes errores:<ul>';
                        for (const campo in data.errors) {
                            erroresHTML += `<li><strong>${campo}:</strong> ${data.errors[campo]}</li>`;
                        }
                        erroresHTML += '</ul>';
                        mensajesDiv.innerHTML = erroresHTML;
                    } else if (data.error) {
                        mensajesDiv.innerHTML = data.error; // Para el error de "Method Not Allowed" u otros
                    } else {
                        mensajesDiv.innerHTML = 'Ocurrió un error al crear el item.';
                    }
                }
            
            } catch (error) {
                console.error('Error de red:', error);
                mensajesDiv.className = 'error';
                mensajesDiv.innerHTML = 'No se pudo conectar con el servidor';
            }
        });
    </script>
</body>
</html>
<style>
    .tabla-items { width: 100%; border-collapse: collapse; margin-top: 15px; font-family: Arial, sans-serif; }
    .tabla-items th, .tabla-items td { border: 1px solid #ddd; padding: 10px; text-align: left; }
    .tabla-items th { background-color: #87ADFD; color: white; font-weight: bold; }
    .tabla-items tr:nth-child(even) { background-color: #f9f9f9; }
    .tabla-items tr:hover { background-color: #f1f1f1; }
    .text-center { text-align: center !important; }
    
    /* Estilos para el buscador */
    .buscador-container { margin-bottom: 15px; display: flex; gap: 10px; }
    .buscador-container input { flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
    .btn-buscar { padding: 8px 15px; background: #87ADFD; color: white; border: none; border-radius: 4px; cursor: pointer; }
    .btn-limpiar { padding: 8px 15px; background: #ccc; color: #333; border: none; border-radius: 4px; cursor: pointer; }
</style>

<div style="margin-top: 40px; padding-top: 20px; border-top: 2px solid #eee;">
    <h2>Inventario de Items</h2>
    
    <!-- NUEVO: Contenedor del buscador -->
    <div class="buscador-container">
        <input type="text" id="input-busqueda" placeholder="Buscar por nombre (ej: item54)...">
        <button class="btn-buscar" onclick="ejecutarBusqueda()">Buscar</button>
        <button class="btn-limpiar" onclick="limpiarBusqueda()">Limpiar</button>
    </div>
    
    <table class="tabla-items">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody id="items-tbody">
            <tr>
                <td colspan="4" class="text-center">Cargando items...</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
// Ahora la función recibe un parámetro opcional "terminoBusqueda"
async function cargarItems(terminoBusqueda = '') {
    // 1. Agarramos el cuerpo de la tabla apenas entra a la función
    const tbody = document.getElementById('items-tbody');
    
    // 2. Mostramos el estado de carga ANTES de ir al servidor.
    // Si está buscando algo específico dice "Buscando...", si no, "Cargando..."
    const mensajeCarga = terminoBusqueda 
        ? `Buscando "${terminoBusqueda}"...` 
        : 'Cargando items...';
        
    tbody.innerHTML = `<tr><td colspan="4" class="text-center" style="color: #87ADFD; font-style: italic; font-weight: bold;">⏳ ${mensajeCarga}</td></tr>`;

    try {
        // 3. Recién ahora hacemos la pausa (await) para ir a buscar los datos
        const url = terminoBusqueda 
            ? `/api-clases/items?q=${encodeURIComponent(terminoBusqueda)}` 
            : '/api-clases/items';

        const response = await fetch(url);
        const textoCrudo = await response.text(); 
        const data = JSON.parse(textoCrudo);
        
        if (response.ok && data.ok) { 
            // 4. El servidor ya respondió. Borramos el "Cargando..."
            tbody.innerHTML = ''; 
            
            if (data.items.length === 0) {
                const mensaje = terminoBusqueda 
                    ? `<b>Sin resultados</b> para la búsqueda "${terminoBusqueda}"` 
                    : 'No hay items registrados todavía.';
                
                tbody.innerHTML = `<tr><td colspan="4" class="text-center">${mensaje}</td></tr>`;
                return;
            }

            data.items.forEach(item => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${item.id}</td>
                    <td><strong>${item.name}</strong></td>
                    <td>${item.quantity}</td>
                    <td>$${item.price}</td>
                `;
                tbody.appendChild(tr);
            });
        }
        
    } catch (error) {
        console.error('Error:', error);
        tbody.innerHTML = '<tr><td colspan="4" class="text-center" style="color:red;">Error de conexión.</td></tr>';
    }
}

// Funciones auxiliares para los botones del buscador
function ejecutarBusqueda() {
    const texto = document.getElementById('input-busqueda').value;
    cargarItems(texto);
}

function limpiarBusqueda() {
    document.getElementById('input-busqueda').value = '';
    cargarItems(''); // Recarga la tabla entera
}

// Cargar la tabla entera apenas entramos
document.addEventListener('DOMContentLoaded', () => cargarItems(''));
</script>
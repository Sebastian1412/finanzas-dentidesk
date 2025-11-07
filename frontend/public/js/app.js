// frontend/js/app.js

// 1. URL CORREGIDA - ajusta según tu estructura real
const API_URL = 'http://localhost/proyectos/finanzas-dentidesk/backend/api/transaccion.php';

// 2. Token - DEBES CREAR UNO VÁLIDO en tu base de datos
const TOKEN = 'token_de_prueba_123';

// 3. Funciones auxiliares para API
async function apiCall(endpoint = '', options = {}) {
    const url = endpoint ? `${API_URL}${endpoint}` : API_URL;
    
    const defaultOptions = {
        headers: {
            'Authorization': `Bearer ${TOKEN}`,
            'Content-Type': 'application/json',
        }
    };

    try {
        const response = await fetch(url, { ...defaultOptions, ...options });
        
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        console.error('Error en API call:', error);
        throw error;
    }
}

// 4. Cargar datos iniciales
async function cargarDatos() {
    try {
        // Cargar totales
        const totales = await apiCall('?totales=true');
        actualizarTotales(totales);
        
        // Cargar transacciones
        const transacciones = await apiCall();
        actualizarTabla(transacciones);
        
    } catch (error) {
        console.error('Error cargando datos:', error);
        document.querySelector('#tabla-transacciones tbody').innerHTML = 
            '<tr><td colspan="5" class="text-center text-danger">Error cargando datos</td></tr>';
    }
}

// 5. Actualizar los totales en el HTML
function actualizarTotales(totales) {
    const ingresos = parseFloat(totales.total_ingresos || 0);
    const egresos = parseFloat(totales.total_egresos || 0);
    const gananciaNeta = ingresos - egresos;

    document.getElementById('total-ingresos').textContent = `$${ingresos.toFixed(2)}`;
    document.getElementById('total-egresos').textContent = `$${egresos.toFixed(2)}`;
    document.getElementById('ganancia-neta').textContent = `$${gananciaNeta.toFixed(2)}`;
    
    // Color para ganancia neta
    const gananciaElement = document.getElementById('ganancia-neta').parentElement.parentElement;
    gananciaElement.className = gananciaNeta >= 0 ? 
        'card text-white bg-primary mb-3' : 'card text-white bg-warning mb-3';
}

// 6. Actualizar tabla de transacciones
function actualizarTabla(transacciones) {
    const tbody = document.querySelector('#tabla-transacciones tbody');
    
    if (!transacciones || transacciones.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center">No hay transacciones</td></tr>';
        return;
    }

    tbody.innerHTML = transacciones.map(trans => `
        <tr>
            <td>${formatearFecha(trans.fecha)}</td>
            <td>
                <span class="badge ${trans.tipo === 'ingreso' ? 'bg-success' : 'bg-danger'}">
                    ${trans.tipo}
                </span>
            </td>
            <td>${trans.descripcion || '-'}</td>
            <td class="text-end ${trans.tipo === 'ingreso' ? 'text-success' : 'text-danger'}">
                $${parseFloat(trans.monto).toFixed(2)}
            </td>
            <td class="text-center">
                <button class="btn btn-sm btn-outline-danger" onclick="eliminarTransaccion(${trans.id})">
                    Eliminar
                </button>
            </td>
        </tr>
    `).join('');
}

// 7. Formatear fecha
function formatearFecha(fechaString) {
    const fecha = new Date(fechaString);
    return fecha.toLocaleDateString('es-ES');
}

// 8. Manejar envío del formulario
document.getElementById('transaccion-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = {
        tipo: document.getElementById('tipo').value,
        descripcion: document.getElementById('descripcion').value,
        monto: parseFloat(document.getElementById('monto').value)
    };

    try {
        const resultado = await apiCall('', {
            method: 'POST',
            body: JSON.stringify(formData)
        });

        if (resultado.success) {
            // Limpiar formulario
            this.reset();
            document.getElementById('tipo').value = 'ingreso'; // Reset a valor por defecto
            
            // Recargar datos
            await cargarDatos();
            
            // Mostrar mensaje de éxito
            alert('Transacción guardada correctamente');
        } else {
            alert('Error al guardar transacción');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al conectar con el servidor');
    }
});

// 9. Eliminar transacción
async function eliminarTransaccion(id) {
    if (!confirm('¿Estás seguro de eliminar esta transacción?')) {
        return;
    }

    try {
        const resultado = await apiCall(`?id=${id}`, {
            method: 'DELETE'
        });

        if (resultado.success) {
            await cargarDatos();
            alert('Transacción eliminada');
        } else {
            alert('Error al eliminar transacción');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al conectar con el servidor');
    }
}

// 10. Inicializar la aplicación cuando carga la página
document.addEventListener('DOMContentLoaded', function() {
    cargarDatos();
});
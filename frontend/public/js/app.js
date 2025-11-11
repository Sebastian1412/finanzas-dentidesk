// frontend/js/app.js

const API_URL = '../../../backend/api/transaccion.php';
const TOKEN = 'token_de_prueba_123';

let dataTableInstance = null;

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
        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
        return await response.json();
    } catch (error) {
        console.error('Error en API call:', error);
        throw error;
    }
}

async function cargarDatos() {
    try {
        const totales = await apiCall('?totales=true');
        actualizarTotales(totales);
        
        const transacciones = await apiCall();
        actualizarTabla(transacciones);
        
    } catch (error) {
        console.error('Error cargando datos:', error);
        alert('Error cargando datos de la tabla');
    }
}

function actualizarTotales(totales) {
    const ingresos = parseFloat(totales.total_ingresos || 0);
    const egresos = parseFloat(totales.total_egresos || 0);
    const gananciaNeta = ingresos - egresos;

    document.getElementById('total-ingresos').textContent = `$${ingresos.toFixed(2)}`;
    document.getElementById('total-egresos').textContent = `$${egresos.toFixed(2)}`;
    document.getElementById('ganancia-neta').textContent = `$${gananciaNeta.toFixed(2)}`;
    
    const gananciaElement = document.getElementById('ganancia-neta').parentElement.parentElement;
    gananciaElement.className = gananciaNeta >= 0 ? 
        'card text-white bg-primary mb-3' : 'card text-white bg-warning mb-3';
}

function actualizarTabla(transacciones) {
    if ($.fn.DataTable.isDataTable('#tabla-transacciones')) {
        $('#tabla-transacciones').DataTable().destroy();
    }

    if (!transacciones || transacciones.length === 0) {
        // Si no hay datos, inicializamos una tabla vacía
        $('#tabla-transacciones').DataTable({ data: [] });
        return;
    }

    // Inicializamos DataTables
    dataTableInstance = $('#tabla-transacciones').DataTable({
        data: transacciones, 
        columns: [
            { 
                data: 'fecha',
                render: function(data) { return formatearFecha(data); } 
            },
            { 
                data: 'tipo',
                render: function(data) {
                    const color = data === 'ingreso' ? 'success' : 'danger';
                    return `<span class="badge bg-${color}">${data}</span>`;
                }
            },
            { data: 'descripcion' },
            { 
                data: 'monto',
                className: 'text-end', // Alinear a la derecha (Bootstrap class)
                render: function(data, type, row) {
                    const color = row.tipo === 'ingreso' ? 'text-success' : 'text-danger';
                    return `<span class="${color}">$${parseFloat(data).toFixed(2)}</span>`;
                }
            },
            { 
                data: null, // Columna de acciones (no viene de la BD)
                className: 'text-center',
                orderable: false, // No ordenar por esta columna
                render: function(data, type, row) {
                    return `<button class="btn btn-sm btn-outline-danger" onclick="eliminarTransaccion(${row.id})">Eliminar</button>`;
                }
            }
        ],

        dom: 'Bfrtip', 
        buttons: [
            { extend: 'excel', text: 'Exportar Excel', className: 'btn btn-success btn-sm' },
            { extend: 'pdf', text: 'PDF', className: 'btn btn-danger btn-sm' },
            { extend: 'print', text: 'Imprimir', className: 'btn btn-secondary btn-sm' }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        order: [[0, 'desc']]
    });
}

function formatearFecha(fechaString) {
    if (!fechaString) return '';
    const partes = fechaString.split('-');
    if (partes.length !== 3) return fechaString;
    return `${partes[2]}/${partes[1]}/${partes[0]}`;
}

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
            this.reset();
            document.getElementById('tipo').value = 'ingreso';
            await cargarDatos(); 
            alert('Transacción guardada correctamente');
        } else {
            alert('Error al guardar transacción');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al conectar con el servidor');
    }
});

async function eliminarTransaccion(id) {
    if (!confirm('¿Estás seguro de eliminar esta transacción?')) return;

    try {
        const resultado = await apiCall(`?id=${id}`, { method: 'DELETE' });

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

document.addEventListener('DOMContentLoaded', function() {
    cargarDatos();
});
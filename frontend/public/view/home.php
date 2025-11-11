<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finanzas DENTIDESK</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

</head>
<body class="bg-light">

    <div class="container py-5">
        <h1 class="mb-4 text-center">Mantenedor de Finanzas</h1>


        <div class="row mb-4 text-center" id="totales-section">
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Ingresos del Mes</div>
                    <div class="card-body">
                        <h3 class="card-title" id="total-ingresos">$0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Egresos del Mes</div>
                    <div class="card-body">
                        <h3 class="card-title" id="total-egresos">$0</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Ganancia Neta</div>
                    <div class="card-body">
                        <h3 class="card-title" id="ganancia-neta">$0</h3>
                    </div>
                </div>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-header">Registrar Nueva Transacción</div>
            <div class="card-body">
                <form id="transaccion-form">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="tipo" class="form-label visually-hidden">Tipo</label>
                            <select class="form-select" id="tipo" required>
                                <option value="ingreso" selected>Ingreso</option>
                                <option value="egreso">Egreso</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="descripcion" class="form-label visually-hidden">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" placeholder="Descripción" required>
                        </div>
                        <div class="col-md-2">
                            <label for="monto" class="form-label visually-hidden">Monto</label>
                            <input type="number" class="form-control" id="monto" placeholder="Monto" min="0.01" step="0.01" required>
                        </div>
                        <div class="col-md-2 d-grid">
                            <button type="submit" class="btn btn-dark">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Últimas Transacciones</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle" id="tabla-transacciones" style="width:100%">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th class="text-end">Monto</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td colspan="5" class="text-center p-4">Cargando datos...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- jQuery (Obligatorio para DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- JS de Bootstrap (Ya lo tenías) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS de DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    
    <script src="../js/app.js"></script>
</body>
</html>
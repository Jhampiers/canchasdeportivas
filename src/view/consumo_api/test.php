<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">🧪 Prueba de Consumo API</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>?c=dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Consumo API</li>
    </ol>

    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-paper-plane me-1"></i>
                    Formulario de Prueba
                </div>
                <div class="card-body">
                    <form id="formTestAPI">
                        <div class="mb-3">
                            <label for="token" class="form-label">Token *</label>
                            <select class="form-select" id="token" name="token" required>
                                <option value="">Seleccione un token...</option>
                                <?php foreach ($tokens as $t): ?>
                                    <?php if ($t['estado'] === 'Activo'): ?>
                                        <option value="<?= htmlspecialchars($t['token']) ?>">
                                            <?= htmlspecialchars($t['razon_social']) ?> - <?= htmlspecialchars($t['token']) ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de Operación *</label>
                            <select class="form-select" id="tipo" name="tipo" required>
                                <option value="">Seleccione...</option>
                                <option value="listar_canchas">Listar todas las canchas</option>
                                <option value="listar_canchas_disponibles">Listar canchas disponibles</option>
                                <option value="buscar_cancha_nombre">Buscar por nombre</option>
                                <option value="buscar_cancha_ubicacion">Buscar por ubicación</option>
                            </select>
                        </div>

                        <div class="mb-3" id="divData" style="display: none;">
                            <label for="data" class="form-label">Dato de búsqueda</label>
                            <input type="text" class="form-control" id="data" name="data" 
                                   placeholder="Ingrese nombre o ubicación">
                            <small class="text-muted">Solo necesario para búsquedas específicas</small>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-rocket"></i> Enviar Petición
                        </button>
                        <button type="button" class="btn btn-secondary" id="btnLimpiar">
                            <i class="fas fa-eraser"></i> Limpiar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-code me-1"></i>
                    Respuesta JSON
                </div>
                <div class="card-body">
                    <div id="loading" style="display: none;" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-2">Procesando petición...</p>
                    </div>
                    
                    <div id="resultado" class="bg-dark text-light p-3 rounded" style="min-height: 300px; font-family: monospace; font-size: 13px; overflow-x: auto;">
                        <em class="text-muted">La respuesta aparecerá aquí...</em>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-info-circle me-1"></i>
                    Información de uso
                </div>
                <div class="card-body">
                    <h6>Tipos de operación disponibles:</h6>
                    <ul>
                        <li><strong>listar_canchas:</strong> Retorna todas las canchas registradas</li>
                        <li><strong>listar_canchas_disponibles:</strong> Retorna solo canchas con estado "Disponible"</li>
                        <li><strong>buscar_cancha_nombre:</strong> Busca canchas por nombre (requiere dato)</li>
                        <li><strong>buscar_cancha_ubicacion:</strong> Busca canchas por ubicación (requiere dato)</li>
                    </ul>
                    
                    <h6 class="mt-3">Ejemplo de petición con cURL:</h6>
                    <pre class="bg-light p-3 rounded"><code>curl -X POST "<?= BASE_URL ?>?c=consumoApi&a=procesar" \
  -d "token=tok_40a78860f5d858373341647213247af7-9" \
  -d "tipo=listar_canchas"</code></pre>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Mostrar/ocultar campo de datos según el tipo
document.getElementById('tipo').addEventListener('change', function() {
    const divData = document.getElementById('divData');
    const inputData = document.getElementById('data');
    
    if (this.value === 'buscar_cancha_nombre' || this.value === 'buscar_cancha_ubicacion') {
        divData.style.display = 'block';
        inputData.required = true;
    } else {
        divData.style.display = 'none';
        inputData.required = false;
        inputData.value = '';
    }
});

// Enviar formulario
document.getElementById('formTestAPI').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const loading = document.getElementById('loading');
    const resultado = document.getElementById('resultado');
    const formData = new FormData(this);
    
    loading.style.display = 'block';
    resultado.innerHTML = '<em class="text-muted">Esperando respuesta...</em>';
    
    try {
        const response = await fetch('<?= BASE_URL ?>?c=consumoApi&a=procesar', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        resultado.innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        
    } catch (error) {
        resultado.innerHTML = '<pre class="text-danger">Error: ' + error.message + '</pre>';
    } finally {
        loading.style.display = 'none';
    }
});

// Limpiar formulario
document.getElementById('btnLimpiar').addEventListener('click', function() {
    document.getElementById('formTestAPI').reset();
    document.getElementById('divData').style.display = 'none';
    document.getElementById('resultado').innerHTML = '<em class="text-muted">La respuesta aparecerá aquí...</em>';
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
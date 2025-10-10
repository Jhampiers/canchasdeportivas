<?php
// Mostrar todos los errores (muy útil para depurar)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Requerir el modelo (ajustado a tu ruta real)
require_once __DIR__ . '/../src/model/ClienteApi.php';  // <-- cambia a /model/ si no tienes /src/

// Crear objeto del modelo
$objApi = new ClienteApi();

// --- PRUEBA 1: Buscar cancha por denominación ---
echo "<h2>✅ Prueba 1: buscarCanchaByDenominacion('futbol')</h2>";

try {
    $resultado = $objApi->buscarCanchaByDenominacion("futbol");
    echo "<pre>";
    print_r($resultado);
    echo "</pre>";
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Error en buscarCanchaByDenominacion: " . $e->getMessage() . "</p>";
}

// --- PRUEBA 2: Buscar cliente por ID ---
echo "<h2>✅ Prueba 2: buscarclienteById(1)</h2>";

if (method_exists($objApi, 'buscarclienteById')) {
    try {
        $cliente = $objApi->buscarclienteById(1);
        echo "<pre>";
        print_r($cliente);
        echo "</pre>";
    } catch (Exception $e) {
        echo "<p style='color:red;'>❌ Error en buscarclienteById: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color:orange;'>⚠️ El método buscarclienteById() aún no existe en ClienteApi.php</p>";
}

echo "<hr><p style='color:gray;'>Archivo de prueba ejecutado correctamente ✅</p>";


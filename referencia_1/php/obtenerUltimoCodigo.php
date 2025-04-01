<?php
// Datos de conexión a la base de datos
$host = 'localhost';
$usuario = 'root';
$clave = '';
$base_datos = 'pdo';

try {
    // Crear conexión usando PDO
    $conexion = new PDO("mysql:host=$host;dbname=$base_datos;charset=utf8", $usuario, $clave);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL para obtener el último código
    $sql = "SELECT codigo FROM paciente_aceptado ORDER BY codigo DESC LIMIT 1";

    // Preparar y ejecutar la consulta
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    // Obtener el resultado
    $ultimoCodigo = $stmt->fetchColumn();

    // Verificar si se encontró un código
    if ($ultimoCodigo) {
        echo json_encode(['ultimoCodigo' => $ultimoCodigo]);
    } else {
        echo json_encode(['ultimoCodigo' => null]); // No se encontró un código
    }
} catch (PDOException $e) {
    // Manejo de errores
    echo json_encode(['error' => 'Error de conexión o consulta: ' . $e->getMessage()]);
} finally {
    // Cerrar la conexión
    $conexion = null;
}
?>
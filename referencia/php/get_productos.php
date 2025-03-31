<?php
require_once "../php/main.php";

$conexion = conexion();
$searchTerm = $_GET['term'];
$type = $_GET['type'];

if ($type == 'producto') {
    $query = $conexion->prepare("SELECT producto_id AS id, producto_nombre AS nombre FROM producto WHERE producto_nombre LIKE :term");
} else if ($type == 'categoria') {
    $query = $conexion->prepare("SELECT categoria_id AS id, categoria_nombre AS nombre FROM categoria WHERE categoria_nombre LIKE :term");
} else if ($type == 'contrato') {
    $query = $conexion->prepare("SELECT contrato_id AS id, contrato_nombre AS nombre FROM contrato WHERE contrato_nombre LIKE :term");
}

$query->execute(['term' => '%' . $searchTerm . '%']);
$result = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);
?>
<?php
include '../../../config/config.php';
include '../../../php/conexion.php';
require('../../../plugins/fpdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage('L', 'A4');
$pdf->SetFont('Arial', 'B', 14);

$resultado = $conexion->query("SELECT nombre_sucursal, img_logo, telefono, correo FROM sucursales WHERE sucursal_id = 1");
if ($row = $resultado->fetch_object()) :
    $pdf->Image('../../../img/sucursal/logo.png', 20, 10, 30);
    $pdf->Cell(40);
    $pdf->Cell(20, 10, utf8_decode($row->nombre_sucursal), 0, 1, 'L');

    $pdf->SetFont('Arial', '', 11);

    $pdf->Cell(40);
    $pdf->Cell(20, 10, utf8_decode($row->correo), 0, 1, 'L');

    $pdf->Cell(40);
    $pdf->Cell(20, 10, utf8_decode($row->telefono), 0, 0, 'L');
endif;

$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(120);
$pdf->Cell(20, 10, utf8_decode('LISTA DE CLIENTES'), 0, 0, 'C');
$pdf->Ln(6);

$pdf->SetFont('Arial', 'I', 12);

$pdf->Cell(180);
$pdf->Cell(20, 10, utf8_decode('Generado: ' . date("Y-m-d")), 0, 0, 'C');
$pdf->Ln(10);


# AQUI COMIENZA LA CABECERA DE LA TABLA
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(8, 5, utf8_decode('#'), 1, 0, 'L');
$pdf->Cell(70, 5, utf8_decode('Cliente'), 1, 0, 'L');
$pdf->Cell(70, 5, utf8_decode('Correo'), 1, 0, 'L');
$pdf->Cell(90, 5, utf8_decode('Domicilio'), 1, 0, 'L');
$pdf->Cell(40, 5, utf8_decode('Fecha de registro'), 1, 1, 'L');


$pdf->SetFont('Arial', '', 7);
# CUERPO DE LA TABLA
$resultado = $conexion->query("SELECT usuario_id, nombre, apellidos, correo, calle, num_ex, c.nombre_colonia, m.nombre_municipio, e.nombre_estado, fecha_registro FROM usuarios u
                                INNER JOIN colonia c ON u.colonia_id = c.colonia_id
                                INNER JOIN municipios m ON u.municipio_id = m.municipio_id
                                INNER JOIN estados e ON u.estado_id = e.estado_id
                                WHERE rol_id = 2 ORDER BY usuario_id");
while ($row = $resultado->fetch_object()) :
    $pdf->Cell(8, 5, utf8_decode($row->usuario_id), 1, 0, 'L');
    $pdf->Cell(70, 5, utf8_decode($row->nombre . " " . $row->apellidos), 1, 0, 'L');
    $pdf->Cell(70, 5, utf8_decode($row->correo), 1, 0, 'L');
    $pdf->Cell(90, 5, utf8_decode($row->calle . " #" . $row->num_ex . " " . $row->nombre_colonia . " " . $row->nombre_municipio . ", " . $row->nombre_estado), 1, 0, 'L');
    $pdf->Cell(40, 5, utf8_decode($row->fecha_registro), 1, 1, 'L');
endwhile;



$pdf->Output();

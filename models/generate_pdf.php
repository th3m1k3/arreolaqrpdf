<?php
/**
 * Genera un archivo PDF de una credencial con los datos del formulario y la foto subida.
 *
 * @param array $postData Arreglo asociativo que contiene los datos del formulario:
 *      - usuario: ID del usuario
 *      - nombre: Primer nombre del usuario
 *      - apellidos: Apellidos del usuario
 *      - estado: Estado del usuario
 *      - pais: País del usuario
 *      - tipoSangre: Tipo de sangre del usuario
 *      - emergencia: Nombre del contacto de emergencia
 *      - telefonoEmergencia: Teléfono del contacto de emergencia
 *      - enfermedad: Enfermedades del usuario
 *      - alergia: Alergias del usuario
 *      - fechaNacimiento: Fecha de nacimiento del usuario
 *      - vigencia: Vigencia de la credencial
 * @param array $fileData Contiene la información de la foto subida:
 *      - foto: Archivo de la foto subida
 *
 * @return void Genera y muestra el PDF de la credencial.
 */

require('../fpdf/fpdf.php');

$usuario = $_POST['usuario'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$estado = $_POST['estado'];
$pais = $_POST['pais'];
$tipoSangre = $_POST['tipo_sangre'];
$emergencia = $_POST['emergencia'];
$telefonoEmergencia = $_POST['telefono_emergencia'];
$enfermedad = $_POST['enfermedad'];
$alergia = $_POST['alergia'];
$fechaNacimiento = $_POST['fecha_nacimiento'];
$vigencia = $_POST['vigencia'];

if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $targetDir = "../views/img";
    $targetFile = $targetDir . basename($_FILES["foto"]["name"]);

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile)) {
        $foto = $targetFile;
    } else {
        $foto = '';
    }
} else {
    $foto = '';
}

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetMargins(3, 3, 70);
$pdf->SetAutoPageBreak(true, 5);

$pdf->SetFillColor(255, 255, 255);
$pdf->Rect(0, 0, 210, 125, 'F');

$pdf->SetDrawColor(0, 0, 0);
$pdf->Rect(10, 10, 100, 70);

$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(50, 15);

$pdf->SetFont('Arial', '', 7);
$pdf->Cell(0, 6, 'Nombre: ' . $nombre . ' ' . $apellidos, 5, 1, 'C');
$pdf->Cell(0, 6, 'Estado: ' . $estado, 0, 1, 'C');
$pdf->Cell(0, 6, 'País: ' . $pais, 0, 1, 'C');
$pdf->Cell(0, 6, 'Tipo de Sangre: ' . $tipoSangre, 0, 1, 'C');
$pdf->Cell(0, 5, 'Contacto de Emergencia: ' . $emergencia, 0, 1, 'C');
$pdf->Cell(0, 6, 'Teléfono de Emergencia: ' . $telefonoEmergencia, 0, 1, 'C');
$pdf->Cell(0, 6, 'Enfermedad: ' . $enfermedad, 0, 1, 'C');
$pdf->Cell(0, 6, 'Alergia: ' . $alergia, 0, 1, 'C');
$pdf->Cell(0, 6, 'Fecha de Nacimiento: ' . $fechaNacimiento, 0, 1, 'C');
$pdf->Cell(0, 6, 'Vigencia: ' . $vigencia, 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->SetXY(24, 47);
$pdf->Cell(0, 6, 'ID: ' . $usuario, 0, 1, 'L');

if (!empty($foto)) {
    $pdf->Image($foto, 15, 15, 30, 30);
} else {
    $pdf->SetXY(10, 65);
    $pdf->Cell(30, 30, '', 1, 1, 'C');
}

$pdf->Output('I', 'credencial.pdf');
?>

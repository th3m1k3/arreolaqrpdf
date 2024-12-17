<?php
require_once '../models/CredencialModel.php';

/**
 * Controlador para gestionar las credenciales.
 */
class CredencialController {
    /**
     * Instancia del modelo de credencial.
     *
     * @var CredencialModel
     */
    private $model;

    /**
     * Constructor de la clase.
     * Crea una instancia del modelo de credencial.
     */
    public function __construct() {
        $this->model = new CredencialModel();
    }

    /**
     * Crear una nueva credencial.
     *
     * @param array $data Datos de la credencial a crear.
     * @return void
     */
    public function create($data) {
        /**
         * Llamar al modelo para generar el PDF y guardar los datos en la base de datos.
         *
         * @var string $pdfPath Ruta donde se guarda el PDF generado.
         */
        $pdfPath = $this->model->generatePdfAndSaveToDb(
            $data['usuario'], $data['nombre'], $data['apellidos'],
            $data['estado'], $data['pais'], $data['tipo_sangre'],
            $data['emergencia'], $data['telefono_emergencia'], 
            $data['enfermedad'], $data['alergia'], 
            $data['fecha_nacimiento'], $data['vigencia']
        );

        /**
         * Mostrar el PDF directamente al usuario.
         */
        header("Content-Type: application/pdf");
        header("Content-Disposition: inline; filename='credencial.pdf'");
        readfile($pdfPath);
        exit;
    }

    /**
     * Actualizar una credencial existente.
     *
     * @param int $id ID de la credencial a actualizar.
     * @param array $data Nuevos datos para la credencial.
     * @return void
     */
    public function update($id, $data) {
        $this->model->updateCredencial($id, $data);
    }

    /**
     * Eliminar una credencial existente.
     *
     * @param int $id ID de la credencial a eliminar.
     * @return void
     */
    public function delete($id) {
        $this->model->deleteCredencial($id);
    }

    /**
     * Obtener todas las credenciales.
     *
     * @return array Lista de todas las credenciales.
     */
    public function list() {
        return $this->model->getCredenciales();
    }

    /**
     * Obtener una credencial por su ID.
     *
     * @param int $id ID de la credencial.
     * @return array Detalles de la credencial.
     */
    public function getById($id) {
        return $this->model->getCredencialById($id);
    }

    /**
     * Obtener el modelo de credencial para pruebas u otros usos.
     *
     * @return CredencialModel
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * Ver la credencial en formato PDF.
     * 
     * @param int $id ID de la credencial.
     * @return void
     */
    public function viewPdf($id) {
        // Obtener los datos de la credencial por ID
        $credencial = $this->model->getCredencialById($id);

        // Generar el PDF con FPDF (o cualquier otra librería)
        $this->generatePdf($credencial);
    }

    /**
     * Generar el PDF de la credencial.
     * 
     * @param array $credencial Datos de la credencial a mostrar en el PDF.
     * @return void
     */
    private function generatePdf($credencial) {
        // Usamos FPDF o TCPDF para generar el PDF
        require_once '../fpdf/fpdf.php';  // Asegúrate de tener la librería FPDF en tu proyecto

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        // Datos de la credencial
        $pdf->Cell(40, 10, 'Usuario: ' . $credencial['usuario']);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Nombre: ' . $credencial['nombre']);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Apellidos: ' . $credencial['apellidos']);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Estado: ' . $credencial['estado']);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Pais: ' . $credencial['pais']);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Tipo de Sangre: ' . $credencial['tipo_sangre']);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Fecha de Nacimiento: ' . $credencial['fecha_nacimiento']);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Vigencia: ' . $credencial['vigencia']);
        $pdf->Ln();

        // Mostrar el PDF al usuario
        $pdf->Output('I', 'credencial_' . $credencial['id'] . '.pdf');
        exit;
    }
}

/**
 * Manejo de acciones del controlador de credenciales.
 */
if (isset($_GET['action'])) {
    $controller = new CredencialController();

    switch ($_GET['action']) {
        case 'create':
            $controller->create($_POST);
            header("Location: ../views/index.php");
            break;

        case 'update':
            $id = $_GET['id'];
            $controller->update($id, $_POST);
            header("Location: ../views/index.php");
            break;

        case 'edit':
            $id = $_GET['id'];
            $credencial = $controller->getById($id);
            include '../views/edit.php';
            break;

        case 'delete':
            $id = $_GET['id'];
            $controller->delete($id);
            header("Location: ../views/index.php");
            break;

        case 'viewPdf':
            $id = $_GET['id'];
            $controller->viewPdf($id);
            break;

        default:
            echo "Acción no válida.";
            break;
    }
}

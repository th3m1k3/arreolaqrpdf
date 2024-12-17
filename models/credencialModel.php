<?php

require_once '../fpdf/fpdf.php';
require_once '../config/Database.php';

/**
 * Modelo para gestionar las credenciales.
 */
class CredencialModel {

    /**
     * Conexión a la base de datos.
     *
     * @var PDO
     */
    private $conn;

    /**
     * Constructor de la clase.
     * Establece la conexión a la base de datos.
     */
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Genera un PDF con los datos de la credencial y guarda los datos en la base de datos.
     *
     * @param string $usuario Usuario asociado a la credencial.
     * @param string $nombre Nombre de la persona asociada a la credencial.
     * @param string $apellidos Apellidos de la persona asociada a la credencial.
     * @param string $estado Estado donde reside la persona.
     * @param string $pais País donde reside la persona.
     * @param string $tipoSangre Tipo de sangre de la persona.
     * @param string $emergencia Nombre del contacto de emergencia.
     * @param string $telefonoEmergencia Teléfono del contacto de emergencia.
     * @param string $enfermedad Enfermedades conocidas de la persona.
     * @param string $alergia Alergias conocidas de la persona.
     * @param string $fechaNacimiento Fecha de nacimiento de la persona.
     * @param string $vigencia Fecha de vigencia de la credencial.
     * @return void
     */
    public function generatePdfAndSaveToDb($usuario, $nombre, $apellidos, $estado, $pais, $tipoSangre, $emergencia, $telefonoEmergencia, $enfermedad, $alergia, $fechaNacimiento, $vigencia) {
        ob_clean(); // Limpiar cualquier salida previa

        // Guardar los datos en la base de datos
        $query = "INSERT INTO credenciales (usuario, nombre, apellidos, estado, pais, tipo_sangre, contacto_emergencia, telefono_emergencia, enfermedad, alergia, fecha_nacimiento, vigencia)
                  VALUES (:usuario, :nombre, :apellidos, :estado, :pais, :tipo_sangre, :contacto_emergencia, :telefono_emergencia, :enfermedad, :alergia, :fecha_nacimiento, :vigencia)";
        
        $stmt = $this->conn->prepare($query);

        // Enlazar los parámetros
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':pais', $pais);
        $stmt->bindParam(':tipo_sangre', $tipoSangre);
        $stmt->bindParam(':contacto_emergencia', $emergencia);
        $stmt->bindParam(':telefono_emergencia', $telefonoEmergencia);
        $stmt->bindParam(':enfermedad', $enfermedad);
        $stmt->bindParam(':alergia', $alergia);
        $stmt->bindParam(':fecha_nacimiento', $fechaNacimiento);
        $stmt->bindParam(':vigencia', $vigencia);

        // Ejecutar la consulta para guardar los datos
        if ($stmt->execute()) {
            // Generar el PDF
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 10);

            // Establecer dimensiones del rectángulo tamaño credencial
            $pdf->SetXY(10, 10);
            $pdf->Rect(10, 10, 95, 90); // Rectángulo de tamaño credencial

            // Dibujar un recuadro para la foto de perfil
            $pdf->Rect(15, 15, 25, 25); // Foto de perfil

            // Añadir los datos al PDF
            $pdf->SetXY(45, 15);
            $pdf->MultiCell(40, 6, 'Nombre: ' . $nombre);

            $pdf->SetXY(45, 21);
            $pdf->MultiCell(40, 6, 'Apellidos: ' . $apellidos);

            $pdf->SetXY(45, 27);
            $pdf->MultiCell(40, 6, 'Usuario: ' . $usuario);

            $pdf->SetXY(45, 33);
            $pdf->MultiCell(40, 6, 'Estado: ' . $estado);

            $pdf->SetXY(45, 39);
            $pdf->MultiCell(40, 6, 'Tipo de Sangre: ' . $tipoSangre);

            $pdf->SetXY(45, 45);
            $pdf->MultiCell(40, 6, 'Vigencia: ' . $vigencia);

            $pdf->SetXY(45, 51);
            $pdf->MultiCell(40, 6, 'Pais: ' . $pais);

            $pdf->SetXY(45, 57);
            $pdf->MultiCell(40, 6, 'Emergencia: ' . $emergencia);

            $pdf->SetXY(45, 63);
            $pdf->MultiCell(40, 3, 'Telefono Emergencia: ' . $telefonoEmergencia);

            $pdf->SetXY(45, 69);
            $pdf->MultiCell(40, 6, 'Enfermedad: ' . $enfermedad);

            $pdf->SetXY(45, 75);
            $pdf->MultiCell(40, 6, 'Alergia: ' . $alergia);

            $pdf->SetXY(45, 81);
            $pdf->MultiCell(40, 6, 'Fecha de Nacimiento: ' . $fechaNacimiento);

            $pdf->SetXY(17, 40);
            $pdf->MultiCell(40, 6, 'ID: ' . $usuario);

            // Generar el PDF en el navegador
            $pdf->Output('I', 'credencial.pdf');
        } else {
            echo "Error al guardar los datos en la base de datos.";
        }
    }

    /**
     * Obtener todas las credenciales desde la base de datos.
     *
     * @return array Lista de todas las credenciales.
     */
    public function getCredenciales() {
        $query = "SELECT * FROM credenciales";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devolver todas las credenciales
    }

    /**
     * Eliminar una credencial existente.
     *
     * @param int $id ID de la credencial a eliminar.
     * @return void
     */
    public function deleteCredencial($id) {
        $query = "DELETE FROM credenciales WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
    
        if ($stmt->execute()) {
            echo "Credencial eliminada exitosamente.";
        } else {
            echo "Error al eliminar la credencial.";
        }
    }

    /**
     * Obtener una credencial por su ID.
     *
     * @param int $id ID de la credencial.
     * @return array Detalles de la credencial.
     */
    public function getCredencialById($id) {
        $query = "SELECT * FROM credenciales WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Devolver una sola credencial
    }

    /**
     * Actualizar una credencial existente.
     *
     * @param int $id ID de la credencial a actualizar.
     * @param array $data Nuevos datos de la credencial.
     * @return void
     */
    public function updateCredencial($id, $data) {
        $query = "UPDATE credenciales SET 
                    usuario = :usuario,
                    nombre = :nombre,
                    apellidos = :apellidos,
                    estado = :estado,
                    pais = :pais,
                    tipo_sangre = :tipo_sangre,
                    contacto_emergencia = :contacto_emergencia,
                    telefono_emergencia = :telefono_emergencia,
                    enfermedad = :enfermedad,
                    alergia = :alergia,
                    fecha_nacimiento = :fecha_nacimiento,
                    vigencia = :vigencia
                  WHERE id = :id";
       
        $stmt = $this->conn->prepare($query);

        // Enlazar los parámetros
        $stmt->bindParam(':usuario', $data['usuario']);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':apellidos', $data['apellidos']);
        $stmt->bindParam(':estado', $data['estado']);
        $stmt->bindParam(':pais', $data['pais']);
        $stmt->bindParam(':tipo_sangre', $data['tipo_sangre']);
        $stmt->bindParam(':contacto_emergencia', $data['emergencia']);
        $stmt->bindParam(':telefono_emergencia', $data['telefono_emergencia']);
        $stmt->bindParam(':enfermedad', $data['enfermedad']);
        $stmt->bindParam(':alergia', $data['alergia']);
        $stmt->bindParam(':fecha_nacimiento', $data['fecha_nacimiento']);
        $stmt->bindParam(':vigencia', $data['vigencia']);
        $stmt->bindParam(':id', $id);

        // Ejecutar la consulta para actualizar los datos
        if ($stmt->execute()) {
            echo "Credencial actualizada exitosamente.";
        } else {
            echo "Error al actualizar la credencial.";
        }
    }
}
?>

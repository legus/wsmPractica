<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Asignaturas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
$metodo = intval($_POST["metodo"]);
class Asignatura {
    public $nombre;
    public $codigo;
    public $creditos;
    public $profesor;
    
    function __construct($nombre = null, $codigo = null, $creditos = null, $profesor = null) {
        $this->nombre = $nombre;
        $this->codigo = $codigo;
        $this->creditos = $creditos;
        $this->profesor = $profesor;
    }

    function getConnection() {
        // Configura aquí tu conexión a la base de datos
        $servername = "localhost";   // Cambia a tu nombre de servidor
        $username = "root";          // Cambia al nombre de usuario de tu base de datos
        $password = "";              // Cambia si tu base de datos tiene una contraseña
        $dbname = "gestion_asignaturas"; // Cambia al nombre de tu base de datos
    
        // Crear la conexión
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        return $conn;
    }
    // Crear una nueva asignatura
    function crearAsignatura($nombre, $codigo, $creditos, $profesor) {
        include 'conx.php';
        $conn = $this->getConnection();
        $verificacion = "SELECT * FROM Asignatura WHERE codigo = '$codigo'";
        $query = mysqli_query($conn, $verificacion);

        if ($query->num_rows == 0) {
            $Insql = "INSERT INTO Asignatura VALUES ('$nombre', '$codigo', $creditos, '$profesor')";
            $query = mysqli_query($conn, $Insql);
            
            if ($query) {
                echo '<div class="alert alert-success">Asignatura registrada correctamente</div>';
            } else {
                echo '<div class="alert alert-danger">Error al registrar la asignatura</div>';
            }
        } else {
            echo '<div class="alert alert-warning">La asignatura con código ' . $codigo . ' ya existe.</div>';
        }
        $conn->close();
    }

    // Consultar una asignatura por su código
    function consultarAsignatura($codigo) {
        include 'conx.php';
        $conn = $this->getConnection();
        $consulta = "SELECT * FROM Asignatura WHERE codigo = '$codigo'";
        $query = mysqli_query($conn, $consulta);

        if ($query->num_rows > 0) {
            $asignatura = $query->fetch_assoc();
            echo "
            <div class='container mt-5'>
                <div class='card shadow-lg border-0'>
                    <div class='card-header bg-primary text-white text-center'>
                        <h3>Datos de la Asignatura</h3>
                    </div>
                    <div class='card-body'>
                        <table class='table table-hover'>
                            <tr><td><strong>Nombre:</strong></td><td>{$asignatura['nombre']}</td></tr>
                            <tr><td><strong>Código:</strong></td><td>{$asignatura['codigo']}</td></tr>
                            <tr><td><strong>Créditos:</strong></td><td>{$asignatura['creditos']}</td></tr>
                            <tr><td><strong>Profesor:</strong></td><td>{$asignatura['profesor']}</td></tr>
                        </table>
                    </div>
                </div>
            </div>";
        } else {
            echo '<div class="alert alert-danger">No se encontró la asignatura con código ' . $codigo . '</div>';
        }
        $conn->close();
    }

    // Editar una asignatura existente
    function editarAsignatura($codigo, $nombreNuevo, $creditos, $profesor) {
        include 'conx.php';
        $conn = $this->getConnection();
        $consulta = "SELECT * FROM Asignatura WHERE codigo = '$codigo'";
        $query = mysqli_query($conn, $consulta);

        if ($query->num_rows > 0) {
            $datosActualizados = [];
            if (!empty($nombreNuevo)) $datosActualizados[] = "nombre = '$nombreNuevo'";
            if (!empty($creditos)) $datosActualizados[] = "creditos = $creditos";
            if (!empty($profesor)) $datosActualizados[] = "profesor = '$profesor'";
            
            if (!empty($datosActualizados)) {
                $updateSQL = "UPDATE Asignatura SET " . implode(", ", $datosActualizados) . " WHERE codigo = '$codigo'";
                if (mysqli_query($conn, $updateSQL)) {
                    echo '<div class="alert alert-success">Asignatura actualizada correctamente</div>';
                } else {
                    echo '<div class="alert alert-danger">Error al actualizar la asignatura</div>';
                }
            } else {
                echo '<div class="alert alert-warning">No se realizaron cambios.</div>';
            }
        } else {
            echo '<div class="alert alert-danger">No se encontró la asignatura con el código ' . $codigo . '</div>';
        }
        $conn->close();
    }

    // Eliminar una asignatura por su código
    function eliminarAsignatura($codigo) {
        include 'conx.php';
        $conn = $this->getConnection();
        $consulta = "SELECT * FROM Asignatura WHERE codigo = '$codigo'";
        $query = mysqli_query($conn, $consulta);

        if ($query->num_rows > 0) {
            $delete = "DELETE FROM Asignatura WHERE codigo = '$codigo'";
            if (mysqli_query($conn, $delete)) {
                echo '<div class="alert alert-success">Asignatura eliminada correctamente</div>';
            } else {
                echo '<div class="alert alert-danger">Error al eliminar la asignatura</div>';
            }
        } else {
            echo '<div class="alert alert-danger">No se encontró la asignatura con código ' . $codigo . '</div>';
        }
        $conn->close();
    }
}

// Lógica para determinar la acción a realizar
if ($metodo == 1) {
    // Crear asignatura
    $nombre = $_POST["nombre"];
    $codigo = $_POST["codigo"];
    $creditos = $_POST["creditos"];
    $profesor = $_POST["profesor"];
    $asignatura = new Asignatura();
    echo $asignatura->crearAsignatura($nombre, $codigo, $creditos, $profesor);
} elseif ($metodo == 2) {
    // Consultar asignatura
    $codigo = $_POST["codigo"];
    $asignatura = new Asignatura();
    echo $asignatura->consultarAsignatura($codigo);
} elseif ($metodo == 3) {
    // Editar asignatura
    $codigo = $_POST["codigo"];
    $nombreNuevo = $_POST["nombreNuevo"];
    $creditos = $_POST["creditos"];
    $profesor = $_POST["profesor"];
    $asignatura = new Asignatura();
    echo $asignatura->editarAsignatura($codigo, $nombreNuevo, $creditos, $profesor);
} elseif ($metodo == 4) {
    // Eliminar asignatura
    $codigo = $_POST["codigo"];
    $asignatura = new Asignatura();
    echo $asignatura->eliminarAsignatura($codigo);
} else {
    echo '<div class="alert alert-danger">¡Error! Método no válido.</div>';
}

echo "<a href='index.html' class='btn btn-success btn-block mt-4'>Regresar</a>";
?>
</body>
</html>

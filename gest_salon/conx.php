<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicación Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
$metodo = intval($_POST["metodo"]);
class Salon {
    public $nombre;
    public $capacidad;
    public $ubicacion;
    public $tipo;
    function __construct($nombre = null, $capacidad = null, $ubicacion = null, $tipo = null) {
        $this->nombre = $nombre;
        $this->capacidad = $capacidad;
        $this->ubicacion = $ubicacion;
        $this->tipo = $tipo;
    }
    function crearSalon($nombre, $capacidad, $ubicacion, $tipo){
        $host = "localhost"; 
        $user = "DaniJay10"; 
        $pass = "git123"; 
        $db = "Colegio"; 
        $conn = new mysqli($host, $user, $pass, $db);
        if($conn->connect_error){
            die("Conexión fallida: ". $conn->connect_error);
        }
        $verificacion = "SELECT * FROM Salon WHERE nombre = '$nombre'";
        $query = mysqli_query($conn, $verificacion);
        if ($query->num_rows == 0) {
        $Insql = "INSERT INTO Salon VALUES ('$nombre', $capacidad, '$ubicacion', '$tipo')";
        $query = mysqli_query($conn, $Insql);
        if($query){
            echo '<div class="alert alert-success">Salon registrado correctamente</div>';
        }else{
            echo '<div class="alert alert-danger" role="alert">ERROR!!! El salon no se ha podido registrar</div>';
        }
    }else{
        echo '<div class="alert alert-warning" role="alert">El salon ' . $nombre . ' ya existe en la base de datos.</div>';
    }
        $conn->close();
    }
    function consultarSalones($nombre){
        $host = "localhost"; 
        $user = "DaniJay10"; 
        $pass = "git123"; 
        $db = "Colegio"; 
        $conn = new mysqli($host, $user, $pass, $db);
        if($conn->connect_error){
            die("Conexión fallida: ". $conn->connect_error);
        }
        $verificacion = "SELECT * FROM Salon WHERE nombre = '$nombre'";
        $query = mysqli_query($conn, $verificacion);
        if ($query->num_rows > 0) {
            $salon = $query->fetch_assoc(); 
            echo "
            <div class='container mt-5'>
                <div class='card shadow-lg border-0'>
                    <div class='card-header bg-primary text-white text-center'>
                        <h3>Datos del salón</h3>
                    </div>
                    <div class='card-body'>
                        <table class='table table-hover'>
                            <tr>
                                <td><strong>Nombre del salon:</strong></td>
                                <td>" . $salon['nombre'] . "</td>
                            </tr>
                            <tr>
                                <td><strong>Capacidad:</strong></td>
                                <td>" . $salon['capacidad'] . "</td>
                            </tr>
                            <tr>
                                <td><strong>Ubicación:</strong></td>
                                <td>" . $salon['ubicacion'] . "</td>
                            </tr>
                            <tr>
                                <td><strong>Tipo Salón:</strong></td>
                                <td>" . $salon['tipo'] . "</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>";
    }else{
        echo '<div class="alert alert-danger" role="alert">No se encontró el salon ' . $nombre . ' en la base de datos.</div>';
    }
    $conn->close();
    }
     
    function editarSalon($nombre, $nombreN, $capacidad, $ubicacion, $tipo) {
        $host = "localhost"; 
        $user = "DaniJay10"; 
        $pass = "git123"; 
        $db = "Colegio"; 
        $conn = new mysqli($host, $user, $pass, $db);
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $verificacion = "SELECT * FROM Salon WHERE nombre = '$nombre'";
        $query = mysqli_query($conn, $verificacion);
        if ($query->num_rows > 0) {
            $datosSalon = $query->fetch_assoc();
            $nombreSalon = $datosSalon['nombre'];
            $datosActualizados = [];
            if (!empty($nombreN)) {
                $datosActualizados[] = "nombre = '$nombreN'";
            }
            if (!empty($capacidad)) {
                if (is_numeric($capacidad)) {
                    $datosActualizados[] = "capacidad = " . intval($capacidad);
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error: El valor de "capacidad" debe ser un número válido.</div>';
                    $conn->close();
                    return;
                }
            }
            if (!empty($ubicacion)) {
                $datosActualizados[] = "ubicacion = '$ubicacion'";
            }
            if (!empty($tipo)) {
                $datosActualizados[] = "tipo = '$tipo'";
            }
            if (!empty($datosActualizados)) {
                $updateSQL = "UPDATE Salon SET " . implode(", ", $datosActualizados) . " WHERE nombre = '$nombre'";
                if (mysqli_query($conn, $updateSQL)) {
                    echo '<div class="alert alert-success">Los datos del salón ' . $nombreSalon . ' han sido actualizados correctamente en base de datos.</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error al actualizar: ' . $conn->error . '</div>';
                }
            } else {
                echo '<div class="alert alert-warning" role="alert">No se realizaron cambios en los datos.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">No se encontró un salón con el nombre ' . $nombre . ' en la base de datos.</div>';
        }
    
        $conn->close();
    }
    

    function eliminarSalon($nombre){
        $host = "localhost"; 
        $user = "DaniJay10"; 
        $pass = "git123"; 
        $db = "Colegio"; 
        $conn = new mysqli($host, $user, $pass, $db);
        if($conn->connect_error){
            die("Conexión fallida: ". $conn->connect_error);
        }
        $verificacion = "SELECT * FROM Salon WHERE nombre = '$nombre'";
        $query = mysqli_query($conn, $verificacion);
        if ($query->num_rows > 0) {
            $delete = "DELETE FROM Salon WHERE nombre = '$nombre'";
            $query = mysqli_query($conn, $delete);
            if($query) {
                echo '<div class="alert alert-success">Se elimino correctamente el salon ' . $nombre. '.</div>';
              } else {
                  echo '<div class="alert alert-danger" role="alert">Error al eliminar el salon' . $nombre . ': ' . $conn->error . '</div>';
              }
        }else{
            echo '<div class="alert alert-danger" role="alert">No se encontró el salon ' . $nombre . ' en la base de datos.</div>';
        }
        $conn->close();
    }
}

//creacion salon
if($metodo == 1){
    $nom=$_POST["nombre"];
    $cap=$_POST["capacidad"];
    $ubi=$_POST["ubicacion"];
    $tip=$_POST["tipo"];
    if (is_numeric($cap)) {
        $cap = intval($cap);
        $Salon = new Salon();
        echo $Salon->crearSalon($nom, $cap, $ubi, $tip);
    }else{
        echo '<div class="alert alert-danger" role="alert">¡¡¡Error!!! El valor de "capacidad" debe ser un número válido.</div>';
        echo '<div class="alert alert-warning" role="alert">El salón no se ha podido registrar en base de datos debido a un valor incorrecto en "capacidad".</div>';
    }

}
//ver salon
else if($metodo == 2){
    $nom=$_POST["salon"];
    $Salon = new Salon();
    echo $Salon->consultarSalones($nom);  
}
//editar salon
else if($metodo == 3){
    $nom=$_POST["nombre"];
    $nomN=$_POST["nombreN"];
    $cap=$_POST["capacidad"];
    $ubi=$_POST["ubicacion"];
    $tip=$_POST["tipo"];
        $Salon = new Salon();
        echo $Salon->editarSalon($nom, $nomN, $cap, $ubi, $tip);  
}
//eliminar salon
else if($metodo == 4){
    $nom=$_POST["salon"];
    $Salon = new Salon();
    echo $Salon->eliminarSalon($nom);  
}    
else {
    echo '<p>¡¡¡ERROR!!! Hubo algun error en procesos internos</p>';
}

echo "<a href='index.html' class='btn btn-success btn-block mt-4'>Regresar</a>";
?>
</body>
</html>

<?php
include 'conexion.php'; 
$message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buscar"])) {
    $cedula = $_POST["cedula"];
    $sql = "SELECT cedula, nombre, asignatura, horas FROM docente WHERE cedula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cedula);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró un docente
    if ($result->num_rows > 0) {
        $docente = $result->fetch_assoc();
    } else {
        $message = "No se encontró un docente con la cédula proporcionada.";
    }

    $stmt->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar"])) {
    $cedula = $_POST["cedula"];
    $nombre = $_POST["nombre"];
    $asignatura = $_POST["asignatura"];
    $horas = $_POST["horas"];

    $sql = "UPDATE docente SET nombre = ?, asignatura = ?, horas = ? WHERE cedula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $asignatura, $horas, $cedula);

    if ($stmt->execute()) {
        $message = "Docente actualizado exitosamente.";
    } else {
        $message = "Error al actualizar el docente: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Docente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Inicio</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="agregar_docente.php">Agregar docente</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="editar_docente.php">Editar docente</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5 pt-5">
        <h1>Editar Docente</h1>
        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>


        <form method="post" action="editar_docente.php">
            <div class="mb-3">
                <label for="cedula" class="form-label">Ingrese la cédula del docente</label>
                <input type="number" name="cedula" id="cedula" class="form-control" required value="<?php echo isset($docente['cedula']) ? htmlspecialchars($docente['cedula']) : ''; ?>">
            </div>
            <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
        </form>


        <?php if (isset($docente)): ?>
            <form method="post" action="editar_docente.php" class="mt-4">
                <input type="hidden" name="cedula" value="<?php echo htmlspecialchars($docente['cedula']); ?>">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($docente['nombre']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="asignatura" class="form-label">Asignatura</label>
                    <input type="text" name="asignatura" id="asignatura" class="form-control" value="<?php echo htmlspecialchars($docente['asignatura']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="horas" class="form-label">Horas</label>
                    <input type="number" name="horas" id="horas" class="form-control" value="<?php echo htmlspecialchars($docente['horas']); ?>" required>
                </div>
                <button type="submit" name="actualizar" class="btn btn-success">Actualizar</button>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

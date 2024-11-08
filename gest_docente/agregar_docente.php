<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';

    $cedula = $_POST["cedula"];
    $nombre = $_POST["nombre"];
    $asignatura = $_POST["asignatura"];
    $horas = $_POST["horas"];


    $checkStmt = $conn->prepare("SELECT * FROM docente WHERE cedula = ?");
    $checkStmt->bind_param("i", $cedula);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        $message = "La cédula ya está registrada en el sistema, Por favor ingrese una diferente .";
    } else {

        $stmt = $conn->prepare("INSERT INTO docente (cedula, nombre, asignatura, horas) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $cedula, $nombre, $asignatura, $horas);

        if ($stmt->execute()) {
            $message = "Nuevo docente agregado exitosamente.";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkStmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Docente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">inicio</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="agregar_docente.php">Agregar docente</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="editar_docente.php">Editar docente</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5 pt-5">
        <h1>Agregar Docente</h1>
        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="post" action="agregar_docente.php">
            <div class="mb-3">
                <label for="cedula" class="form-label">Cédula</label>
                <input type="number" name="cedula" id="cedula" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="asignatura" class="form-label">Asignatura</label>
                <input type="text" name="asignatura" id="asignatura" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="horas" class="form-label">Horas</label>
                <input type="number" name="horas" id="horas" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Docente</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

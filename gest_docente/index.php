<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Docentes</title>
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
                            <a class="nav-link" href="editar_docente.php">Editar docente</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5 pt-5">
        <h1>Listado de Docentes</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Asignatura</th>
                    <th>Horas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'conexion.php';
                $sql = "SELECT cedula, nombre, asignatura, horas FROM docente";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . htmlspecialchars($row["cedula"]) . "</td>
                            <td>" . htmlspecialchars($row["nombre"]) . "</td>
                            <td>" . htmlspecialchars($row["asignatura"]) . "</td>
                            <td>" . htmlspecialchars($row["horas"]) . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay docentes registrados.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

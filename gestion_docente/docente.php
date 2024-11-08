<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" action="gestionar_docente.php">
        <h4>Ingrese cedula del docente</h4>
        <input type="number" name="cedula" id="cedula" required>

        <h4>Ingrese el nombre del docente</h4>
        <input type="text" name="Nombre" id="Nombre" required>

        <h4>Ingrese la asignatura a dictar</h4>
        <input type="text" name="asignatura" id="asignatura" required>

        <h4>Ingrese las horas a dictar</h4>
        <input type="number" name="horas" id="horas" required><br>

        <input type="hidden" name="action" value="Agregar">
        <button type="submit" class="btn btn-primary">Agregar Docente</button>
    </form>
</body>
</html>
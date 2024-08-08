<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> <!-- Esto asegura que el navegador interprete el contenido en UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envío de Correos desde CSV</title>
</head>
<body>
    <h1>Envío de Correos desde CSV</h1>
    <form action="send_mail.php" method="post" enctype="multipart/form-data">
        <label for="csvfile">Sube tu archivo CSV:</label>
        <input type="file" id="csvfile" name="csvfile" accept=".csv" required><br><br>
        <input type="submit" value="Enviar Correos">
    </form>
</body>
</html>

<!-- templates/Tarjetas/crear_tarjeta.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Tarjeta</title>
</head>
<body>
    <h1>Crear Tarjeta</h1>
    <?php if ($mensaje): ?>
        <p>La tarjeta se creó correctamente.</p>
    <?php else: ?>
        <p>Hubo un error al crear la tarjeta. Por favor, inténtalo de nuevo.</p>
    <?php endif; ?>
</body>
</html>

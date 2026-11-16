<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Tienda.php';

$database = new Database();
$db = $database->connect();
$tiendaModel = new Tienda($db);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id_tienda', FILTER_VALIDATE_INT);
}

if (!$id) {
    header('Location: index.php?mensaje=Identificador de tienda no válido.');
    exit;
}

$tienda = $tiendaModel->getById($id);

if (!$tienda) {
    header('Location: index.php?mensaje=La tienda solicitada no existe.');
    exit;
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nombre_tienda' => trim($_POST['nombre_tienda'] ?? ''),
        'direccion' => trim($_POST['direccion'] ?? ''),
        'ciudad' => trim($_POST['ciudad'] ?? ''),
        'telefono' => trim($_POST['telefono'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
    ];

    if ($datos['nombre_tienda'] === '') {
        $errores[] = 'El nombre de la tienda es obligatorio.';
    }

    if ($datos['direccion'] === '') {
        $errores[] = 'La dirección es obligatoria.';
    }

    if ($datos['ciudad'] === '') {
        $errores[] = 'La ciudad es obligatoria.';
    }

    if (
        $datos['email'] !== '' &&
        !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)
    ) {
        $errores[] = 'El correo electrónico no es válido.';
    }

    if (empty($errores)) {
        $tiendaModel->update($id, $datos);

        header(
            'Location: index.php?mensaje=' .
            urlencode('Tienda actualizada correctamente.')
        );
        exit;
    }

    $tienda = array_merge($tienda, $datos);
}

$pageTitle = 'Editar tienda';
$pageSubtitle = 'Actualiza la información de la tienda';

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Editar tienda</h4>
                <p class="text-muted mb-0">
                    Modifica los datos de la tienda seleccionada.
                </p>
            </div>

            <a href="index.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Volver
            </a>
        </div>

        <?php if (!empty($errores)): ?>
            <div class="alert alert-danger">
                <strong>Revisa los siguientes datos:</strong>

                <ul class="mb-0 mt-2">
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="editar.php?id=<?= (int) $id ?>">
            <input
                type="hidden"
                name="id_tienda"
                value="<?= (int) $id ?>"
            >

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre_tienda" class="form-label">
                        Nombre de la tienda *
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="nombre_tienda"
                        name="nombre_tienda"
                        value="<?= htmlspecialchars($tienda['nombre_tienda']) ?>"
                        required
                    >
                </div>

                <div class="col-md-6">
                    <label for="ciudad" class="form-label">
                        Ciudad *
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="ciudad"
                        name="ciudad"
                        value="<?= htmlspecialchars($tienda['ciudad']) ?>"
                        required
                    >
                </div>

                <div class="col-12">
                    <label for="direccion" class="form-label">
                        Dirección *
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="direccion"
                        name="direccion"
                        value="<?= htmlspecialchars($tienda['direccion']) ?>"
                        required
                    >
                </div>

                <div class="col-md-6">
                    <label for="telefono" class="form-label">
                        Teléfono
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="telefono"
                        name="telefono"
                        value="<?= htmlspecialchars($tienda['telefono'] ?? '') ?>"
                    >
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">
                        Correo electrónico
                    </label>

                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        value="<?= htmlspecialchars($tienda['email'] ?? '') ?>"
                    >
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-floppy"></i>
                    Guardar cambios
                </button>

                <a href="index.php" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
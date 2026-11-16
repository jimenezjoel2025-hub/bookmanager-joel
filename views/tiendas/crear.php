<?php

require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/models/Tienda.php';

$pageTitle = 'Registrar tienda';
$errores = [];

$datos = [
    'nombre_tienda' => '',
    'direccion' => '',
    'ciudad' => '',
    'telefono' => '',
    'email' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos['nombre_tienda'] = trim($_POST['nombre_tienda'] ?? '');
    $datos['direccion'] = trim($_POST['direccion'] ?? '');
    $datos['ciudad'] = trim($_POST['ciudad'] ?? '');
    $datos['telefono'] = trim($_POST['telefono'] ?? '');
    $datos['email'] = trim($_POST['email'] ?? '');

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
        try {
            $database = new Database();
            $db = $database->connect();

            $tiendaModel = new Tienda($db);
            $tiendaModel->create($datos);

            header(
                'Location: index.php?mensaje=' .
                urlencode('Tienda registrada correctamente.')
            );
            exit;

        } catch (PDOException $exception) {
            $errores[] = 'No fue posible registrar la tienda.';
        }
    }
}

require_once dirname(__DIR__, 2) . '/includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="card card-dashboard">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between mb-4">
                    <div>
                        <h2 class="h4 fw-bold mb-1">
                            Nueva tienda
                        </h2>

                        <p class="text-secondary mb-0">
                            Completa los datos de la tienda.
                        </p>
                    </div>

                    <a href="index.php" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Volver
                    </a>
                </div>

                <?php if (!empty($errores)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errores as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST">

                    <div class="mb-3">
                        <label for="nombre_tienda" class="form-label">
                            Nombre de la tienda
                        </label>

                        <input
                            type="text"
                            id="nombre_tienda"
                            name="nombre_tienda"
                            class="form-control"
                            value="<?= htmlspecialchars($datos['nombre_tienda']) ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">
                            Dirección
                        </label>

                        <input
                            type="text"
                            id="direccion"
                            name="direccion"
                            class="form-control"
                            value="<?= htmlspecialchars($datos['direccion']) ?>"
                            required
                        >
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ciudad" class="form-label">
                                Ciudad
                            </label>

                            <input
                                type="text"
                                id="ciudad"
                                name="ciudad"
                                class="form-control"
                                value="<?= htmlspecialchars($datos['ciudad']) ?>"
                                required
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">
                                Teléfono
                            </label>

                            <input
                                type="text"
                                id="telefono"
                                name="telefono"
                                class="form-control"
                                value="<?= htmlspecialchars($datos['telefono']) ?>"
                            >
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label">
                            Correo electrónico
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            value="<?= htmlspecialchars($datos['email']) ?>"
                        >
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i>
                        Guardar tienda
                    </button>

                    <a href="index.php" class="btn btn-light">
                        Cancelar
                    </a>

                </form>
            </div>
        </div>

    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/includes/footer.php'; ?>
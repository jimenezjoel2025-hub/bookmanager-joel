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
    header(
        'Location: index.php?mensaje=' .
        urlencode('Identificador de tienda no válido.')
    );
    exit;
}

$tienda = $tiendaModel->getById($id);

if (!$tienda) {
    header(
        'Location: index.php?mensaje=' .
        urlencode('La tienda solicitada no existe.')
    );
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tiendaModel->delete($id);

    header(
        'Location: index.php?mensaje=' .
        urlencode('Tienda eliminada correctamente.')
    );
    exit;
}

$pageTitle = 'Eliminar tienda';
$pageSubtitle = 'Confirma la eliminación del registro';

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="mb-4">
            <h4 class="text-danger mb-1">
                <i class="bi bi-exclamation-triangle"></i>
                Eliminar tienda
            </h4>

            <p class="text-muted mb-0">
                Revisa la información antes de continuar.
            </p>
        </div>

        <div class="alert alert-warning">
            Esta acción eliminará la tienda de manera permanente.
        </div>

        <div class="border rounded p-3 mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <strong>Nombre:</strong>
                    <div>
                        <?= htmlspecialchars($tienda['nombre_tienda']) ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <strong>Ciudad:</strong>
                    <div>
                        <?= htmlspecialchars($tienda['ciudad']) ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <strong>Dirección:</strong>
                    <div>
                        <?= htmlspecialchars($tienda['direccion']) ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <strong>Teléfono:</strong>
                    <div>
                        <?= htmlspecialchars($tienda['telefono'] ?? 'No registrado') ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <strong>Correo electrónico:</strong>
                    <div>
                        <?= htmlspecialchars($tienda['email'] ?? 'No registrado') ?>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="eliminar.php?id=<?= (int) $id ?>">
            <input
                type="hidden"
                name="id_tienda"
                value="<?= (int) $id ?>"
            >

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i>
                    Sí, eliminar tienda
                </button>

                <a href="index.php" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Titulo.php';

$database = new Database();
$db = $database->connect();

$tituloModel = new Titulo($db);

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id_titulo', FILTER_VALIDATE_INT);
}

if (!$id) {
    header(
        'Location: index.php?mensaje=' .
        urlencode('Identificador de título no válido.')
    );
    exit;
}

$libro = $tituloModel->getById($id);

if (!$libro) {
    header(
        'Location: index.php?mensaje=' .
        urlencode('El título solicitado no existe.')
    );
    exit;
}

$nombrePublicador = 'Sin editorial';
$publicadores = $tituloModel->getPublicadores();

foreach ($publicadores as $publicador) {
    if ((int) $publicador['id_pub'] === (int) $libro['id_pub']) {
        $nombrePublicador = $publicador['nombre'];
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tituloModel->delete($id);

    header(
        'Location: index.php?mensaje=' .
        urlencode('Título eliminado correctamente.')
    );
    exit;
}

$pageTitle = 'Eliminar título';
$pageSubtitle = 'Confirma la eliminación del libro';

require_once __DIR__ . '/../../includes/header.php';
?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="mb-4">
            <h4 class="text-danger mb-1">
                <i class="bi bi-exclamation-triangle"></i>
                Eliminar título
            </h4>

            <p class="text-muted mb-0">
                Revisa la información antes de continuar.
            </p>
        </div>

        <div class="alert alert-warning">
            Esta acción eliminará el libro de manera permanente.
        </div>

        <div class="border rounded p-3 mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <strong>Título:</strong>

                    <div>
                        <?= htmlspecialchars($libro['titulo']) ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <strong>Tipo:</strong>

                    <div>
                        <?= htmlspecialchars($libro['tipo']) ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <strong>Editorial:</strong>

                    <div>
                        <?= htmlspecialchars($nombrePublicador) ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <strong>Precio:</strong>

                    <div>
                        RD$ <?= number_format(
                            (float) $libro['precio'],
                            2
                        ) ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <strong>Stock:</strong>

                    <div>
                        <?= (int) $libro['stock'] ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <strong>Fecha de publicación:</strong>

                    <div>
                        <?= htmlspecialchars(
                            (string) (
                                $libro['fecha_publicacion']
                                ?? 'Sin fecha'
                            )
                        ) ?>
                    </div>
                </div>

                <div class="col-12">
                    <strong>Descripción:</strong>

                    <div>
                        <?= nl2br(
                            htmlspecialchars(
                                (string) (
                                    $libro['descripcion']
                                    ?? 'Sin descripción'
                                )
                            )
                        ) ?>
                    </div>
                </div>
            </div>
        </div>

        <form
            method="POST"
            action="eliminar.php?id=<?= (int) $id ?>"
        >
            <input
                type="hidden"
                name="id_titulo"
                value="<?= (int) $id ?>"
            >

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i>
                    Sí, eliminar título
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